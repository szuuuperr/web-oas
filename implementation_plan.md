# Plan Implementasi: PWI Industrial OS — Sistem Lengkap

## Ringkasan

Membangun **seluruh backend + integrasi frontend** agar semua data di setiap halaman bersifat **dinamis dari database**, bukan lagi hardcoded HTML.

---

## Kondisi Saat Ini

| Komponen | Status | Detail |
|----------|--------|--------|
| **20 Halaman Blade** (4 role × 5) | ✅ UI selesai | Semua data hardcoded/statik |
| **20 Controller** (4 role × 5) | ✅ Kerangka ada | Semua hanya `return view()` |
| **13 Model Eloquent** | ✅ Selesai | Relationship sudah benar |
| **17 Migration files** | ✅ Dibuat | Belum pasti sudah `migrate` |
| **Seeder** | ✅ Parsial | User, Category, Supplier, Material, Settings sudah ada |
| **Role Middleware** | ❌ Belum | Belum ada proteksi role |
| **Backend Logic** | ❌ Belum | CRUD, SMA, approve/reject belum ada |
| **Frontend ↔ Backend** | ❌ Belum | View belum terima variabel dari controller |

---

## Fase 1: Database & Seed Data Lengkap

> Fondasi — semua fitur butuh data di database

### 1.1 Jalankan Migrasi
```bash
php artisan migrate
```

### 1.2 [MODIFY] `database/seeders/DatabaseSeeder.php`
Tambah seed data berikut (yang belum ada):

| Data | Jumlah | Tujuan |
|------|--------|--------|
| Stock Transactions | ~30 record | Dummy data masuk/keluar agar dashboard ada konten |
| Purchase Orders + Items | 5-8 PO | Campuran status: pending, approved, rejected |
| Stock Alerts | 5-8 alert | Beberapa resolved, beberapa aktif |
| Activity Logs | ~15 log | Berbagai aksi untuk halaman admin |
| Notifications | 5 notifikasi | Untuk menguji header bell icon |
| Update `minimum_stock` | 15 material | Set minimum_stock agar alert bisa terpicu |
| Update `current_stock` | 15 material | Set stok awal agar data realistis |

---

## Fase 2: Role-based Middleware (Keamanan)

> [!WARNING]
> Saat ini user manapun bisa akses `/admin`, `/manager`, `/gudang`, `/logistik` — berbahaya!

### 2.1 [NEW] `app/Http/Middleware/RoleMiddleware.php`

```php
// Logika: cek $request->user()->role terhadap daftar role yang diizinkan
// Jika tidak cocok → abort(403) atau redirect ke dashboard sendiri
```

### 2.2 [MODIFY] `app/Http/Kernel.php`
Tambah alias middleware:
```php
'role' => \App\Http\Middleware\RoleMiddleware::class,
```

### 2.3 [MODIFY] `routes/web.php`
Tambah middleware `role` pada setiap group:
```php
// Sebelum:
Route::middleware(['auth'])->prefix('admin')...

// Sesudah:
Route::middleware(['auth', 'role:admin'])->prefix('admin')...
Route::middleware(['auth', 'role:manager'])->prefix('manager')...
Route::middleware(['auth', 'role:staff_gudang'])->prefix('gudang')...
Route::middleware(['auth', 'role:staff_logistik'])->prefix('logistik')...
```

---

## Fase 3: Staff Gudang — Backend + View Integrasi

> Role operasional harian — input stok masuk & keluar

### 3.1 [MODIFY] `Gudang/DashboardController.php`

| Method | Query | Pass ke View |
|--------|-------|--------------|
| `index()` | Count material, sum stok, count transaksi hari ini, recent 5 transactions | `$totalItems`, `$totalStock`, `$todayIn`, `$todayOut`, `$recentTransactions` |

### 3.2 [MODIFY] `Gudang/StockInController.php`

| Method | Logika |
|--------|--------|
| `index()` | Ambil daftar material (untuk dropdown), recent stok masuk |
| `store()` | Validasi form → INSERT `stock_transactions` (type=in) → UPDATE `materials.current_stock += qty` → Cek & resolve alert jika stok sudah di atas minimum → Log activity |

### 3.3 [MODIFY] `Gudang/StockOutController.php`

| Method | Logika |
|--------|--------|
| `index()` | Ambil daftar material (untuk dropdown), recent stok keluar |
| `store()` | Validasi form → Cek stok cukup → INSERT `stock_transactions` (type=out) → UPDATE `materials.current_stock -= qty` → Cek & generate alert jika stok < minimum → Log activity |

### 3.4 [MODIFY] `Gudang/ItemController.php`

| Method | Query |
|--------|-------|
| `index()` | `Material::with('category','supplier')->paginate(15)` |

### 3.5 [MODIFY] `Gudang/HistoryController.php`

| Method | Query |
|--------|-------|
| `index()` | `StockTransaction::with('material','user')->latest()->filter(request)->paginate(20)` |

### 3.6 [MODIFY] View files
Update 5 file `resources/views/gudang/*.blade.php`:
- Replace hardcoded tabel rows → `@foreach($data as $item)`
- Replace hardcoded angka statistics → `{{ $totalItems }}`
- Add form action URLs → `action="{{ route('gudang.stock-in.store') }}"`
- Add `@csrf` dan `@error()` untuk form validation

### 3.7 [MODIFY] `routes/web.php`
Tambah POST routes:
```php
Route::post('/stock-in', [StockInController::class, 'store'])->name('stock-in.store');
Route::post('/stock-out', [StockOutController::class, 'store'])->name('stock-out.store');
```

---

## Fase 4: Staff Logistik — Backend + View Integrasi

> Analisis kebutuhan & pengadaan

### 4.1 [MODIFY] `Logistik/DashboardController.php`

| Method | Query | Pass ke View |
|--------|-------|--------------|
| `index()` | Count alert aktif, count PO pending, sum PO value, recent PO | `$activeAlerts`, `$pendingPO`, `$totalPOValue`, `$recentPO` |

### 4.2 [MODIFY] `Logistik/PredictionController.php`

| Method | Logika |
|--------|--------|
| `index()` | Ambil semua material → Hitung SMA-3 per material berdasarkan `stock_transactions` 30 hari terakhir → Hitung estimated days remaining → Pass data ke view untuk chart |

**Logika SMA:**
```
Per material:
1. Ambil stock_transactions type=out, 30 hari terakhir
2. Group by tanggal, sum(quantity) per hari
3. SMA-N = rata-rata N hari terakhir
4. predicted_daily_usage = SMA-N
5. days_remaining = current_stock / predicted_daily_usage
6. estimated_runout_date = today + days_remaining
```

### 4.3 [MODIFY] `Logistik/AlertController.php`

| Method | Query |
|--------|-------|
| `index()` | `StockAlert::with('material')->where('is_resolved', false)->latest()->paginate(15)` |

### 4.4 [MODIFY] `Logistik/PurchaseOrderController.php`

| Method | Logika |
|--------|--------|
| `index()` | List PO yang dibuat logistik ini + form buat PO baru |
| `store()` | Validasi → Generate PO number → INSERT `purchase_orders` (status=pending) → INSERT `purchase_order_items` → Kirim notification ke manager → Log activity |

### 4.5 [MODIFY] `Logistik/ReportController.php`

| Method | Query |
|--------|-------|
| `index()` | Aggregate `stock_transactions` per material: sum in, sum out, saldo → Filter by date range & category |

### 4.6 [MODIFY] View files
Update 5 file `resources/views/logistik/*.blade.php`:
- Replace hardcoded → `@foreach`, `{{ $variable }}`
- Add form action untuk PO creation
- Add JavaScript chart data dari PHP variables

### 4.7 [MODIFY] `routes/web.php`
Tambah POST route:
```php
Route::post('/po', [PurchaseOrderController::class, 'store'])->name('po.store');
```

---

## Fase 5: Manager — Backend + View Integrasi

> Approve/reject PO & review laporan

### 5.1 [MODIFY] `Manager/DashboardController.php`

| Method | Query | Pass ke View |
|--------|-------|--------------|
| `index()` | Total materials, total stock value, pending PO count, approved PO count, monthly trend data | `$totalMaterials`, `$totalStockValue`, `$pendingPO`, `$approvedPO`, `$monthlyData`, `$recentActivity` |

### 5.2 [MODIFY] `Manager/ReportController.php`

| Method | Query |
|--------|-------|
| `index()` | Same as Logistik report — aggregate stock transactions per material, filter by date/category |

### 5.3 [MODIFY] `Manager/PredictionController.php`

| Method | Logika |
|--------|--------|
| `index()` | Same SMA logic as Logistik — but manager view is read-only (tidak bisa buat PO dari sini) |

### 5.4 [MODIFY] `Manager/ApprovalController.php`

| Method | Logika |
|--------|--------|
| `index()` | List all PO: pending, approved, rejected dengan filter |
| `approve(PurchaseOrder $po)` | Update `$po->status = 'approved'`, `$po->approved_by = auth()->id()` → Kirim notification ke logistik creator → Log activity |
| `reject(Request $request, PurchaseOrder $po)` | Validasi rejection_reason → Update `$po->status = 'rejected'`, `$po->rejection_reason = $request->reason` → Kirim notification → Log activity |

### 5.5 [MODIFY] `Manager/ExportController.php`

| Method | Logika |
|--------|--------|
| `index()` | List available report types + riwayat export sebelumnya |
| `download(Request $request)` | Generate PDF/CSV berdasarkan report_type & date range → Log activity → Return download |

### 5.6 [MODIFY] View files
Update 5 file `resources/views/manager/*.blade.php`:
- Replace hardcoded → dynamic data
- Tambah form approve/reject dengan modal
- Tambah CSRF dan POST method

### 5.7 [MODIFY] `routes/web.php`
Tambah routes:
```php
Route::post('/approvals/{po}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
Route::post('/approvals/{po}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');
Route::post('/export/download', [ExportController::class, 'download'])->name('export.download');
```

---

## Fase 6: Admin — Backend + View Integrasi

> Kelola user, barang, dan sistem

### 6.1 [MODIFY] `Admin/UserController.php`

| Method | Logika |
|--------|--------|
| `dashboard()` | Count users per role, total materials, total transactions, recent logs |
| `index()` | `User::paginate(15)` |
| `store(Request $request)` | Validasi → INSERT user → Log activity |
| `update(Request $request, User $user)` | Validasi → UPDATE user → Log activity |
| `destroy(User $user)` | DELETE user → Log activity |

### 6.2 [MODIFY] `Admin/ItemController.php`

| Method | Logika |
|--------|--------|
| `index()` | `Material::with('category','supplier')->paginate(15)` |
| `store()` | Validasi → INSERT material → Log activity |
| `update()` | Validasi → UPDATE material → Log activity |
| `destroy()` | DELETE material → Log activity |

### 6.3 [MODIFY] `Admin/LogController.php`

| Method | Query |
|--------|-------|
| `index()` | `ActivityLog::with('user')->latest()->filter(request)->paginate(20)` |

### 6.4 [MODIFY] `Admin/SettingsController.php`

| Method | Logika |
|--------|--------|
| `index()` | `SystemSetting::all()->groupBy('group')` |
| `update(Request $request)` | Loop & update settings → Log activity |

### 6.5 [MODIFY] View files
Update 5 file `resources/views/admin/*.blade.php`:
- Replace hardcoded → dynamic data
- Add CRUD form modals
- Add delete confirmations

### 6.6 [MODIFY] `routes/web.php`
Tambah CRUD routes:
```php
// Admin Users
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Admin Items
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::put('/items/{material}', [ItemController::class, 'update'])->name('items.update');
Route::delete('/items/{material}', [ItemController::class, 'destroy'])->name('items.destroy');

// Admin Settings
Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
```

---

## File Baru yang Dibuat

| File | Tujuan |
|------|--------|
| `app/Http/Middleware/RoleMiddleware.php` | Proteksi route berdasarkan role |

## Total File yang Dimodifikasi

| Kategori | Jumlah |
|----------|--------|
| Controllers (logic bisnis) | 20 file |
| Views (integrasi data dinamis) | 20 file |
| Routes | 1 file |
| Seeder | 1 file |
| Kernel (middleware alias) | 1 file |
| **Total** | **~43 file** |

---

## Urutan Eksekusi yang Direkomendasikan

```
Fase 1 (DB & Seed)  →  Fase 2 (Middleware)  →  Fase 3 (Gudang)  →  Fase 4 (Logistik)  →  Fase 5 (Manager)  →  Fase 6 (Admin)
```

Alasan urutan ini mengikuti **alur bisnis**:
1. **Gudang duluan** — karena semua data dimulai dari input stok masuk/keluar
2. **Logistik kedua** — karena butuh data stok dari gudang untuk prediksi & buat PO
3. **Manager ketiga** — karena butuh PO dari logistik untuk di-approve
4. **Admin terakhir** — karena admin mengelola master data & user, bisa dikerjakan kapan saja

---

## Verification Plan

### Per Fase
```bash
# Fase 1: Cek database
php artisan migrate --seed
php artisan tinker → Material::count()  # harus 15
php artisan tinker → StockTransaction::count()  # harus ~30

# Fase 2: Cek middleware
# Login sebagai gudang → akses /admin → harus 403/redirect
# Login sebagai admin → akses /gudang → harus 403/redirect

# Fase 3-6: Cek per halaman
# Login → navigasi ke setiap halaman → data harus tampil dari DB
# Submit form → data harus tersimpan di DB
# Refresh halaman → data baru harus muncul
```

### Tes End-to-End (Setelah Semua Selesai)
1. **Admin** buat user baru (role: staff_gudang)
2. **Admin** tambah material baru
3. **Staff Gudang** login → input stok masuk → stok bertambah
4. **Staff Gudang** input stok keluar sampai di bawah minimum → alert muncul
5. **Staff Logistik** lihat alert → lihat prediksi → buat PO
6. **Manager** lihat PO pending → approve → notifikasi terkirim
7. **Manager** export laporan PDF/Excel
