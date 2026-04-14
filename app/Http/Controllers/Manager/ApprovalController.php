<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'creator', 'purchaseOrderItems.material']);

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('po_number', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected', 'received'])) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('order_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        $purchaseOrders = $query->latest('order_date')->paginate(15)->appends($request->query());

        // Summary counts
        $pendingCount = PurchaseOrder::where('status', 'pending')->count();
        $approvedCount = PurchaseOrder::where('status', 'approved')->count();
        $rejectedCount = PurchaseOrder::where('status', 'rejected')->count();
        $pendingValue = PurchaseOrder::where('status', 'pending')->sum('total_amount');

        return view('manager.approvals', compact(
            'purchaseOrders',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'pendingValue'
        ));
    }

    public function show(PurchaseOrder $po)
    {
        $po->load(['supplier', 'creator', 'purchaseOrderItems.material', 'approver']);

        return view('manager.approval-detail', compact('po'));
    }

    public function approve(Request $request, PurchaseOrder $po)
    {
        if ($po->status !== 'pending') {
            return back()->with('error', 'PO ini sudah diproses sebelumnya.');
        }

        $po->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Send notification to the logistics user who created the PO
        Notification::create([
            'user_id' => $po->created_by,
            'type' => 'success',
            'title' => 'Purchase Order Approved',
            'message' => "PO {$po->po_number} telah disetujui oleh Manager",
            'link' => route('logistik.po'),
        ]);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'approve',
            'module' => 'purchase_order',
            'description' => "Menyetuju Purchase Order {$po->po_number}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('manager.approvals')
            ->with('success', "PO {$po->po_number} berhasil disetujui.");
    }

    public function reject(Request $request, PurchaseOrder $po)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        if ($po->status !== 'pending') {
            return back()->with('error', 'PO ini sudah diproses sebelumnya.');
        }

        $po->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Send notification to the logistics user who created the PO
        Notification::create([
            'user_id' => $po->created_by,
            'type' => 'error',
            'title' => 'Purchase Order Rejected',
            'message' => "PO {$po->po_number} ditolak. Alasan: {$request->rejection_reason}",
            'link' => route('logistik.po'),
        ]);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'reject',
            'module' => 'purchase_order',
            'description' => "Menolak Purchase Order {$po->po_number}. Alasan: {$request->rejection_reason}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('manager.approvals')
            ->with('success', "PO {$po->po_number} ditolak.");
    }

    public function bulkApprove(Request $request)
    {
        $poIds = $request->get('po_ids', []);

        if (empty($poIds)) {
            return back()->with('error', 'Pilih PO yang akan disetujui.');
        }

        $count = PurchaseOrder::whereIn('id', $poIds)
            ->where('status', 'pending')
            ->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'bulk_approve',
            'module' => 'purchase_order',
            'description' => "Menyetuju {$count} Purchase Order sekaligus",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "{$count} PO berhasil disetujui.");
    }
}
