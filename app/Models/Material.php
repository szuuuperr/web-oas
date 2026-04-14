<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_code',
        'material_name',
        'spec',
        'category_id',
        'supplier_id',
        'unit',
        'current_stock',
        'minimum_stock',
        'unit_price',
        'remarks',
        'is_active',
    ];

    protected $casts = [
        'current_stock' => 'integer',
        'minimum_stock' => 'integer',
        'unit_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi: Material milik satu Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: Material milik satu Supplier (default)
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Relasi: Material memiliki banyak Stock Transaction
     */
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    /**
     * Relasi: Material memiliki banyak Purchase Order Item
     */
    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    /**
     * Relasi: Material memiliki banyak Stock Prediction
     */
    public function stockPredictions()
    {
        return $this->hasMany(StockPrediction::class);
    }

    /**
     * Relasi: Material memiliki banyak Stock Alert
     */
    public function stockAlerts()
    {
        return $this->hasMany(StockAlert::class);
    }

    /**
     * Cek apakah stok material di bawah minimum
     */
    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->minimum_stock;
    }
}
