<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockPrediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'period',
        'method',
        'predicted_value',
        'actual_value',
        'accuracy',
        'prediction_date',
    ];

    protected $casts = [
        'period' => 'integer',
        'predicted_value' => 'decimal:2',
        'actual_value' => 'decimal:2',
        'accuracy' => 'decimal:2',
        'prediction_date' => 'date',
    ];

    /**
     * Relasi: Prediksi milik satu Material
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
