<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::with(['category', 'supplier']);

        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('material_code', 'like', "%{$search}%")
                    ->orWhere('material_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where(function ($q) use ($request) {
                if ($request->status === 'critical') {
                    $q->whereRaw('minimum_stock > 0 AND (current_stock / minimum_stock) <= 0.3');
                } elseif ($request->status === 'replenish') {
                    $q->whereRaw('minimum_stock > 0 AND (current_stock / minimum_stock) > 0.3 AND (current_stock < minimum_stock)');
                } elseif ($request->status === 'healthy') {
                    $q->whereRaw('current_stock >= minimum_stock');
                }
            });
        }

        $materials = $query->latest()->paginate(15)->appends($request->query());

        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        $totalMaterials = Material::count();
        $totalCategories = Category::count();
        $lowStockCount = Material::whereRaw('current_stock < minimum_stock')->count();

        return view('admin.items', compact('materials', 'categories', 'suppliers', 'totalMaterials', 'totalCategories', 'lowStockCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_code' => 'required|string|max:50|unique:materials',
            'material_name' => 'required|string|max:255',
            'spec' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'unit' => 'required|string|max:20',
            'current_stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $material = Material::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'materials',
            'description' => "Menambahkan material baru: {$material->material_name} ({$material->material_code})",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.items')
            ->with('success', "Material {$material->material_name} berhasil ditambahkan.");
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'material_code' => ['required', 'string', 'max:50', Rule::unique('materials')->ignore($material->id)],
            'material_name' => 'required|string|max:255',
            'spec' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'unit' => 'required|string|max:20',
            'current_stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $material->update($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'materials',
            'description' => "Mengupdate material: {$material->material_name}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.items')
            ->with('success', "Material {$material->material_name} berhasil diupdate.");
    }

    public function destroy(Request $request, Material $material)
    {
        $materialName = $material->material_name;
        $material->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'module' => 'materials',
            'description' => "Menghapus material: {$materialName}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Material {$materialName} berhasil dihapus.");
    }
}
