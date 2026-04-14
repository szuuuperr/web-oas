<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'material_id',
        'user_id',
        'type',
        'quantity',
        'unit_price',
        'total_amount',
        'batch_number',
        'notes',
        'transaction_date',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    /**
     * Relasi: Transaksi milik satu Material
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Relasi: Transaksi dilakukan oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
