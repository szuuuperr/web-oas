<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'alert_type',
        'message',
        'current_stock',
        'minimum_stock',
        'is_resolved',
        'resolved_at',
        'resolved_by',
    ];

    protected $casts = [
        'current_stock' => 'integer',
        'minimum_stock' => 'integer',
        'is_resolved' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    /**
     * Relasi: Alert milik satu Material
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Relasi: Alert di-resolve oleh satu User
     */
    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
