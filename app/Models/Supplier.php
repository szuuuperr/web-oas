<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi: Supplier memiliki banyak Material
     */
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    /**
     * Relasi: Supplier memiliki banyak Purchase Order
     */
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
