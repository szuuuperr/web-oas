<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportExport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'report_type',
        'filters',
        'file_path',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'filters' => 'array',
        'completed_at' => 'datetime',
    ];

    /**
     * Relasi: Report milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
