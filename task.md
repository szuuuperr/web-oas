# Task Progress: PWI Industrial OS

## Fase 1: Database & Seed Data
- [x] Jalankan `php artisan migrate:fresh` — 17 tabel dibuat
- [x] Perkaya `DatabaseSeeder.php` dengan data lengkap:
  - [x] 4 Users (admin, manager, gudang, logistik)
  - [x] 5 Kategori + 5 Supplier (dengan contact & alamat)
  - [x] 15 Materials (dengan current_stock & minimum_stock realistis)
  - [x] ~30+ Stock Transactions (30 hari terakhir, masuk & keluar)
  - [x] 6 Purchase Orders (campuran: pending, approved, rejected, received)
  - [x] PO Items untuk setiap PO
  - [x] Stock Alerts (aktif & resolved)
  - [x] 20 Activity Logs (berbagai aksi dari semua role)
  - [x] 10 Notifications (untuk manager, logistik, gudang)
  - [x] Stock Predictions (SMA-3 untuk 5 material, 7 hari)
  - [x] 5 System Settings
- [x] Jalankan `php artisan migrate:fresh --seed` — sukses

## Fase 2: Role-based Middleware
- [x] Buat `RoleMiddleware.php`
- [x] Register di `Kernel.php`
- [x] Terapkan di `routes/web.php`

## Fase 3: Staff Gudang
- [ ] Backend controllers (Dashboard, StockIn, StockOut, Items, History)
- [ ] View integration dengan data dinamis
- [ ] POST routes untuk form

## Fase 4: Staff Logistik
- [ ] Backend controllers (Dashboard, Prediction, Alert, PO, Report)
- [ ] SMA calculation logic
- [ ] View integration + POST routes

## Fase 5: Manager
- [ ] Backend controllers (Dashboard, Report, Prediction, Approval, Export)
- [ ] Approve/Reject logic
- [ ] View integration + POST routes

## Fase 6: Admin
- [ ] Backend controllers (Dashboard/Users, Items, Logs, Settings)
- [ ] CRUD operations
- [ ] View integration + POST routes
