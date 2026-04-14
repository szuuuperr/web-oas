<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Material;
use App\Models\Notification;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['creator', 'purchaseOrderItems.material']);

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected', 'received'])) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date_from')) {
            $query->whereDate('order_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        $purchaseOrders = $query->latest('order_date')->paginate(10)->appends($request->query());

        // Summary
        $pendingCount = PurchaseOrder::where('status', 'pending')->count();
        $approvedCount = PurchaseOrder::where('status', 'approved')->count();
        $rejectedCount = PurchaseOrder::where('status', 'rejected')->count();

        // For create form
        $suppliers = Supplier::where('is_active', true)->orderBy('name')->get();
        $materials = Material::where('is_active', true)->orderBy('material_name')->get();

        // Recent PO for activity widget (latest 5)
        $recentPO = PurchaseOrder::with(['creator'])
            ->latest()
            ->limit(5)
            ->get();

        return view('logistik.po', compact(
            'purchaseOrders',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'suppliers',
            'materials',
            'recentPO'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.material_id' => 'required|exists:materials,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'delivery_date' => 'required|date|after_or_equal:today',
            'priority' => 'nullable|in:low,normal,high,urgent',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Generate PO number
        $prefix = SystemSetting::getValue('po_auto_number_prefix', 'PO-2026');
        $lastPO = PurchaseOrder::orderBy('id', 'desc')->first();
        $nextNum = $lastPO ? ((int) substr($lastPO->po_number, -4)) + 1 : 1;
        $poNumber = sprintf('%s-%04d', $prefix, $nextNum);

        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $totalAmount += $item['quantity'] * $item['unit_price'];
        }

        DB::transaction(function () use ($validated, $poNumber, $totalAmount, $request) {
            $po = PurchaseOrder::create([
                'po_number' => $poNumber,
                'supplier_id' => $validated['supplier_id'],
                'created_by' => auth()->id(),
                'status' => 'pending',
                'order_date' => Carbon::now(),
                'expected_date' => $validated['delivery_date'],
                'total_amount' => $totalAmount,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $material = Material::find($item['material_id']);

                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'material_id' => $item['material_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            // Get managers to notify
            $managers = \App\Models\User::where('role', 'manager')->get();

            foreach ($managers as $manager) {
                Notification::create([
                    'user_id' => $manager->id,
                    'type' => 'warning',
                    'title' => 'Purchase Order Baru',
                    'message' => "PO {$poNumber} dari ".auth()->user()->name.' menunggu persetujuan',
                    'link' => route('manager.approvals'),
                ]);
            }

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'create',
                'module' => 'purchase_order',
                'description' => "Membuat Purchase Order {$poNumber}",
                'ip_address' => request()->ip(),
            ]);

            $request->session()->put('created_po', $poNumber);
        });

        return redirect()->route('logistik.po')
            ->with('success', "Purchase Order {$poNumber} berhasil dibuat dan menunggu persetujuan Manager.");
    }

    public function show(PurchaseOrder $po)
    {
        $po->load(['supplier', 'creator', 'purchaseOrderItems.material', 'approver']);

        return view('logistik.po-detail', compact('po'));
    }
}
