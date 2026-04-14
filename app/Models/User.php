<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ========== Role Helpers ==========

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isStaffGudang()
    {
        return $this->role === 'staff_gudang';
    }

    public function isStaffLogistik()
    {
        return $this->role === 'staff_logistik';
    }

    // ========== Relationships ==========

    /**
     * Transaksi stok yang dilakukan user ini
     */
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    /**
     * Purchase Order yang dibuat user ini
     */
    public function createdPurchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'created_by');
    }

    /**
     * Purchase Order yang disetujui user ini
     */
    public function approvedPurchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'approved_by');
    }

    /**
     * Activity logs milik user ini
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Notifikasi milik user ini
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Report exports milik user ini
     */
    public function reportExports()
    {
        return $this->hasMany(ReportExport::class);
    }
}
