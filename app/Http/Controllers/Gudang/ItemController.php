<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::with(['category', 'supplier'])->where('is_active', true);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('material_name', 'like', '%'.$request->search.'%')
                    ->orWhere('material_code', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('status')) {
            $query->where(function ($q) use ($request) {
                if ($request->status === 'critical') {
                    $q->whereRaw('minimum_stock > 0 AND (current_stock / minimum_stock) <= 0.5');
                } elseif ($request->status === 'replenish') {
                    $q->whereRaw('minimum_stock > 0 AND (current_stock / minimum_stock) > 0.5 AND (current_stock < minimum_stock)');
                } elseif ($request->status === 'healthy') {
                    $q->whereRaw('current_stock >= minimum_stock');
                }
            });
        }

        $materials = $query->orderBy('material_name')->paginate(15)->appends($request->query());
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $suppliers = Supplier::where('is_active', true)->orderBy('name')->get();

        return view('gudang.items', compact('materials', 'categories', 'suppliers'));
    }
}
