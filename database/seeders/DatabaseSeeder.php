<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Material;
use App\Models\Notification;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\StockAlert;
use App\Models\StockPrediction;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\SystemSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // 1. Default Users (satu per role)
        // =============================================
        $admin = User::firstOrCreate(
            ['email' => 'admin@pwi.co.id'],
            ['name' => 'Administrator', 'role' => 'admin', 'password' => Hash::make('password')]
        );

        $manager = User::firstOrCreate(
            ['email' => 'manager@pwi.co.id'],
            ['name' => 'Rudi Hartono', 'role' => 'manager', 'password' => Hash::make('password')]
        );

        $gudang = User::firstOrCreate(
            ['email' => 'gudang@pwi.co.id'],
            ['name' => 'Budi Santoso', 'role' => 'staff_gudang', 'password' => Hash::make('password')]
        );

        $logistik = User::firstOrCreate(
            ['email' => 'logistik@pwi.co.id'],
            ['name' => 'Sari Dewi', 'role' => 'staff_logistik', 'password' => Hash::make('password')]
        );

        // =============================================
        // 2. Kategori Material
        // =============================================
        $categories = [
            ['name' => 'Tape & Lakban',              'description' => 'Lakban bening, tape cutter, dan sejenisnya'],
            ['name' => 'Stiker & Label',             'description' => 'Stiker QC, stiker arrow, stiker FIFO, stiker Released, dll'],
            ['name' => 'Alat & Perlengkapan',        'description' => 'Tools operasional gudang dan pabrik'],
            ['name' => 'Buku & Dokumen',             'description' => 'Swatch book, form, dan dokumen operasional'],
            ['name' => 'Lakban Lantai / Floor Tape',  'description' => 'Lakban lantai warna untuk marking area'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], $cat);
        }

        // =============================================
        // 3. Suppliers
        // =============================================
        $suppliers = [
            ['name' => 'DARMA SUKSES MANDIRI CV.',  'contact_person' => 'Pak Darto',   'email' => 'darma@supplier.co.id',   'phone' => '021-5551001', 'address' => 'Jl. Industri Raya No. 12, Tangerang', 'is_active' => true],
            ['name' => 'CV. DUTA ANGGARA',          'contact_person' => 'Ibu Ratna',   'email' => 'duta@supplier.co.id',    'phone' => '021-5551002', 'address' => 'Jl. Raya Serang KM 18, Tangerang',    'is_active' => true],
            ['name' => 'MIRE JAYA INDONESIA PT.',   'contact_person' => 'Pak Surya',   'email' => 'mire@supplier.co.id',    'phone' => '021-5551003', 'address' => 'Kawasan EJIP Plot 7, Cikarang',        'is_active' => true],
            ['name' => 'SILKROAD INDONESIA PT.',    'contact_person' => 'Ms. Linda',   'email' => 'silk@supplier.co.id',    'phone' => '021-5551004', 'address' => 'Jl. Jababeka XVI Blok V, Cikarang',   'is_active' => true],
            ['name' => 'CHEONG MA TECH, PT.',       'contact_person' => 'Mr. Kim',     'email' => 'cheong@supplier.co.id',  'phone' => '021-5551005', 'address' => 'Kawasan MM2100 Block DD-1, Bekasi',    'is_active' => true],
        ];

        foreach ($suppliers as $sup) {
            Supplier::firstOrCreate(['name' => $sup['name']], $sup);
        }

        // =============================================
        // 4. Materials (data nyata PWI) — dengan stok & minimum_stock realistis
        // =============================================
        $materials = [
            ['code' => 'MAT-001', 'name' => 'Tape cutter',                                'spec' => 'joyco 70 mm',     'unit' => 'pcs',  'price' => 20000,  'stock' => 45,    'min' => 20,   'category' => 'Alat & Perlengkapan',        'supplier' => 'DARMA SUKSES MANDIRI CV.',  'remarks' => 'Untuk mengganti tape cutter yg sudah rusak'],
            ['code' => 'MAT-002', 'name' => 'Lakban Bening Polos Besar',                   'spec' => '48 mm x 50 m',    'unit' => 'roll', 'price' => 5600,   'stock' => 320,   'min' => 200,  'category' => 'Tape & Lakban',              'supplier' => 'CV. DUTA ANGGARA',          'remarks' => 'untuk dipakai di all Factory, Inc.mat B1 dan B2'],
            ['code' => 'MAT-003', 'name' => 'Stiker panah utuh / Arrow sticker',           'spec' => 'merah',           'unit' => 'ea',   'price' => 3,      'stock' => 8500,  'min' => 5000, 'category' => 'Stiker & Label',             'supplier' => 'MIRE JAYA INDONESIA PT.',   'remarks' => 'untuk menandai sepatu defect'],
            ['code' => 'MAT-004', 'name' => 'Stiker Panah Bulat / Round Arrow Sticker',    'spec' => 'merah',           'unit' => 'ea',   'price' => 3,      'stock' => 4200,  'min' => 5000, 'category' => 'Stiker & Label',             'supplier' => 'MIRE JAYA INDONESIA PT.',   'remarks' => 'untuk dipakai di AQL inspection F1, F2, F3, F4'],
            ['code' => 'MAT-005', 'name' => 'Stiker LINE QC Checked',                      'spec' => 'Biru',            'unit' => 'ea',   'price' => 38,     'stock' => 3100,  'min' => 2000, 'category' => 'Stiker & Label',             'supplier' => 'MIRE JAYA INDONESIA PT.',   'remarks' => 'untuk dipakai di AQL inspection F1, F2, F3, F4'],
            ['code' => 'MAT-006', 'name' => 'Stiker R',                                    'spec' => 'diameter 12 mm',  'unit' => 'ea',   'price' => 3,      'stock' => 1200,  'min' => 3000, 'category' => 'Stiker & Label',             'supplier' => 'MIRE JAYA INDONESIA PT.',   'remarks' => 'untuk dipakai di AQL inspection F1, F2, F3, F4'],
            ['code' => 'MAT-007', 'name' => 'Stiker Released',                             'spec' => '3.6 x 300 mm',   'unit' => 'pack', 'price' => 35,     'stock' => 180,   'min' => 100,  'category' => 'Stiker & Label',             'supplier' => 'MIRE JAYA INDONESIA PT.',   'remarks' => 'untuk digunakan di Incoming Material B1 Dan B2'],
            ['code' => 'MAT-008', 'name' => 'Stiker FIFO 4',                               'spec' => '-',               'unit' => 'ea',   'price' => 17,     'stock' => 950,   'min' => 500,  'category' => 'Stiker & Label',             'supplier' => 'MIRE JAYA INDONESIA PT.',   'remarks' => 'untuk digunakan di Incoming Material B1 Dan B2'],
            ['code' => 'MAT-009', 'name' => 'Stiker FIFO 5',                               'spec' => '-',               'unit' => 'ea',   'price' => 17,     'stock' => 420,   'min' => 500,  'category' => 'Stiker & Label',             'supplier' => 'MIRE JAYA INDONESIA PT.',   'remarks' => 'untuk digunakan di Incoming Material B1 Dan B2'],
            ['code' => 'MAT-010', 'name' => 'Stiker FIFO 6',                               'spec' => '-',               'unit' => 'ea',   'price' => 17,     'stock' => 780,   'min' => 500,  'category' => 'Stiker & Label',             'supplier' => 'MIRE JAYA INDONESIA PT.',   'remarks' => 'untuk digunakan di Incoming Material B1 Dan B2'],
            ['code' => 'MAT-011', 'name' => 'Swatch Book FMCA adidas',                     'spec' => '2 Page',          'unit' => 'ea',   'price' => 2550,   'stock' => 35,    'min' => 20,   'category' => 'Buku & Dokumen',             'supplier' => 'SILKROAD INDONESIA PT.',    'remarks' => 'untuk dipakai di incoming material (membuat swatch book adidas)'],
            ['code' => 'MAT-012', 'name' => 'Lakban Lantai Biru/Blue Floor Tape',          'spec' => '-',               'unit' => 'ea',   'price' => 50608,  'stock' => 12,    'min' => 10,   'category' => 'Lakban Lantai / Floor Tape', 'supplier' => 'CHEONG MA TECH, PT.',       'remarks' => 'untuk digunakan di Incoming Material B1 Dan B2'],
            ['code' => 'MAT-013', 'name' => 'Lakban Lantai Hijau/Green Floor Tape',        'spec' => '-',               'unit' => 'ea',   'price' => 50608,  'stock' => 8,     'min' => 10,   'category' => 'Lakban Lantai / Floor Tape', 'supplier' => 'CHEONG MA TECH, PT.',       'remarks' => 'untuk digunakan di Incoming Material B1 Dan B2'],
            ['code' => 'MAT-014', 'name' => 'Lakban Lantai Kuning/Yellow Floor Tape',      'spec' => '-',               'unit' => 'ea',   'price' => 50608,  'stock' => 15,    'min' => 10,   'category' => 'Lakban Lantai / Floor Tape', 'supplier' => 'CHEONG MA TECH, PT.',       'remarks' => 'untuk digunakan di Incoming Material B1 Dan B2'],
            ['code' => 'MAT-015', 'name' => 'Lakban Lantai Merah/Red Floor Tape',          'spec' => '-',               'unit' => 'ea',   'price' => 50608,  'stock' => 5,     'min' => 10,   'category' => 'Lakban Lantai / Floor Tape', 'supplier' => 'CHEONG MA TECH, PT.',       'remarks' => 'untuk digunakan di Incoming Material B1 Dan B2'],
        ];

        $materialModels = [];
        foreach ($materials as $mat) {
            $category = Category::where('name', $mat['category'])->first();
            $supplier = Supplier::where('name', $mat['supplier'])->first();

            $materialModels[] = Material::firstOrCreate(
                ['material_code' => $mat['code']],
                [
                    'material_name' => $mat['name'],
                    'spec'          => $mat['spec'],
                    'category_id'   => $category?->id,
                    'supplier_id'   => $supplier?->id,
                    'unit'          => $mat['unit'],
                    'current_stock' => $mat['stock'],
                    'minimum_stock' => $mat['min'],
                    'unit_price'    => $mat['price'],
                    'remarks'       => $mat['remarks'],
                    'is_active'     => true,
                ]
            );
        }

        // =============================================
        // 5. System Settings
        // =============================================
        $settings = [
            ['key' => 'company_name',                   'value' => 'PT. Parkland World Indonesia',  'group' => 'company',      'description' => 'Nama perusahaan'],
            ['key' => 'low_stock_threshold_percent',     'value' => '30',                            'group' => 'notification', 'description' => 'Persentase threshold stok rendah'],
            ['key' => 'sma_default_period',              'value' => '3',                             'group' => 'prediction',   'description' => 'Periode default untuk metode SMA'],
            ['key' => 'po_auto_number_prefix',           'value' => 'PO',                            'group' => 'general',      'description' => 'Prefix auto-number untuk Purchase Order'],
            ['key' => 'transaction_auto_number_prefix',  'value' => 'PW-TX',                         'group' => 'general',      'description' => 'Prefix auto-number untuk Transaksi Stok'],
        ];

        foreach ($settings as $setting) {
            SystemSetting::firstOrCreate(['key' => $setting['key']], $setting);
        }

        // =============================================
        // 6. Stock Transactions (30 hari terakhir — data masuk & keluar)
        // =============================================
        $txCounter = 1;
        $today = Carbon::today();

        // Buat transaksi harian untuk 30 hari terakhir
        for ($dayOffset = 30; $dayOffset >= 0; $dayOffset--) {
            $date = $today->copy()->subDays($dayOffset);

            // Skip weekend
            if ($date->isWeekend()) {
                continue;
            }

            // Pilih 3-5 material acak untuk transaksi hari ini
            $selectedMaterials = collect($materialModels)->shuffle()->take(rand(3, 5));

            foreach ($selectedMaterials as $material) {
                // Transaksi KELUAR (50-70% chance per hari kerja)
                if (rand(1, 100) <= 65) {
                    $qty = $this->getRealisticOutQty($material);
                    if ($qty > 0) {
                        StockTransaction::firstOrCreate(
                            ['transaction_code' => sprintf('PW-TX-%04d', $txCounter)],
                            [
                                'material_id'    => $material->id,
                                'user_id'        => $gudang->id,
                                'type'           => 'out',
                                'quantity'        => $qty,
                                'unit_price'      => $material->unit_price,
                                'total_amount'    => $qty * $material->unit_price,
                                'batch_number'    => null,
                                'notes'           => 'Pengeluaran untuk produksi F' . rand(1, 4),
                                'transaction_date' => $date->toDateString(),
                            ]
                        );
                        $txCounter++;
                    }
                }

                // Transaksi MASUK (20-30% chance — lebih jarang, biasanya terima dari PO)
                if (rand(1, 100) <= 25) {
                    $qty = $this->getRealisticInQty($material);
                    StockTransaction::firstOrCreate(
                        ['transaction_code' => sprintf('PW-TX-%04d', $txCounter)],
                        [
                            'material_id'    => $material->id,
                            'user_id'        => $gudang->id,
                            'type'           => 'in',
                            'quantity'        => $qty,
                            'unit_price'      => $material->unit_price,
                            'total_amount'    => $qty * $material->unit_price,
                            'batch_number'    => 'BATCH-' . $date->format('Ymd') . '-' . rand(1, 9),
                            'notes'           => 'Penerimaan dari supplier',
                            'transaction_date' => $date->toDateString(),
                        ]
                    );
                    $txCounter++;
                }
            }
        }

        // =============================================
        // 7. Purchase Orders (campuran status)
        // =============================================
        $supplierModels = Supplier::all();

        $purchaseOrders = [
            // PO Approved — sudah lama
            [
                'po_number'    => 'PO-2026-0001',
                'supplier_idx' => 0,
                'status'       => 'approved',
                'order_date'   => $today->copy()->subDays(25)->toDateString(),
                'expected_date' => $today->copy()->subDays(18)->toDateString(),
                'received_date' => null,
                'approved_by'  => $manager->id,
                'notes'        => 'Pengadaan rutin stiker QC bulanan',
                'items'        => [
                    ['material_idx' => 2, 'qty' => 10000, 'remarks' => 'Stok arrow sticker untuk F1-F4'],
                    ['material_idx' => 3, 'qty' => 10000, 'remarks' => 'Stok round arrow sticker'],
                ],
            ],
            // PO Received — barang sudah diterima
            [
                'po_number'    => 'PO-2026-0002',
                'supplier_idx' => 4,
                'status'       => 'received',
                'order_date'   => $today->copy()->subDays(20)->toDateString(),
                'expected_date' => $today->copy()->subDays(13)->toDateString(),
                'received_date' => $today->copy()->subDays(12)->toDateString(),
                'approved_by'  => $manager->id,
                'notes'        => 'Pengadaan floor tape marking area produksi',
                'items'        => [
                    ['material_idx' => 11, 'qty' => 20, 'remarks' => 'Blue floor tape'],
                    ['material_idx' => 12, 'qty' => 15, 'remarks' => 'Green floor tape'],
                ],
            ],
            // PO Pending — menunggu approval manager
            [
                'po_number'    => 'PO-2026-0003',
                'supplier_idx' => 2,
                'status'       => 'pending',
                'order_date'   => $today->copy()->subDays(3)->toDateString(),
                'expected_date' => $today->copy()->addDays(7)->toDateString(),
                'received_date' => null,
                'approved_by'  => null,
                'notes'        => 'Permintaan pengadaan stiker R mendesak — stok di bawah minimum',
                'items'        => [
                    ['material_idx' => 5,  'qty' => 5000, 'remarks' => 'Stiker R diameter 12mm — stok kritis'],
                    ['material_idx' => 4,  'qty' => 3000, 'remarks' => 'Stiker LINE QC Checked'],
                ],
            ],
            // PO Pending — menunggu approval
            [
                'po_number'    => 'PO-2026-0004',
                'supplier_idx' => 1,
                'status'       => 'pending',
                'order_date'   => $today->copy()->subDays(1)->toDateString(),
                'expected_date' => $today->copy()->addDays(10)->toDateString(),
                'received_date' => null,
                'approved_by'  => null,
                'notes'        => 'Restok lakban bening bulanan',
                'items'        => [
                    ['material_idx' => 1,  'qty' => 500, 'remarks' => 'Lakban 48mm x 50m'],
                ],
            ],
            // PO Rejected — sudah ditolak
            [
                'po_number'    => 'PO-2026-0005',
                'supplier_idx' => 3,
                'status'       => 'rejected',
                'order_date'   => $today->copy()->subDays(15)->toDateString(),
                'expected_date' => $today->copy()->subDays(8)->toDateString(),
                'received_date' => null,
                'approved_by'  => $manager->id,
                'notes'        => 'Pengadaan swatch book tambahan',
                'rejection_reason' => 'Budget bulan ini sudah melebihi alokasi. Silakan ajukan di bulan berikutnya.',
                'items'        => [
                    ['material_idx' => 10, 'qty' => 50, 'remarks' => 'Swatch book FMCA adidas 2 page'],
                ],
            ],
            // PO Pending terbaru
            [
                'po_number'    => 'PO-2026-0006',
                'supplier_idx' => 2,
                'status'       => 'pending',
                'order_date'   => $today->toDateString(),
                'expected_date' => $today->copy()->addDays(7)->toDateString(),
                'received_date' => null,
                'approved_by'  => null,
                'notes'        => 'Pengadaan stiker FIFO — stok menipis',
                'items'        => [
                    ['material_idx' => 7,  'qty' => 2000, 'remarks' => 'Stiker FIFO 4'],
                    ['material_idx' => 8,  'qty' => 2000, 'remarks' => 'Stiker FIFO 5'],
                    ['material_idx' => 9,  'qty' => 2000, 'remarks' => 'Stiker FIFO 6'],
                ],
            ],
        ];

        foreach ($purchaseOrders as $poData) {
            $supplier = $supplierModels[$poData['supplier_idx']];

            // Hitung total amount dari items
            $totalAmount = 0;
            foreach ($poData['items'] as $item) {
                $mat = $materialModels[$item['material_idx']];
                $totalAmount += $item['qty'] * $mat->unit_price;
            }

            $po = PurchaseOrder::firstOrCreate(
                ['po_number' => $poData['po_number']],
                [
                    'supplier_id'      => $supplier->id,
                    'created_by'       => $logistik->id,
                    'approved_by'      => $poData['approved_by'],
                    'status'           => $poData['status'],
                    'order_date'       => $poData['order_date'],
                    'expected_date'    => $poData['expected_date'],
                    'received_date'    => $poData['received_date'],
                    'total_amount'     => $totalAmount,
                    'notes'            => $poData['notes'],
                    'rejection_reason' => $poData['rejection_reason'] ?? null,
                ]
            );

            // Buat PO items
            foreach ($poData['items'] as $item) {
                $mat = $materialModels[$item['material_idx']];
                PurchaseOrderItem::firstOrCreate(
                    ['purchase_order_id' => $po->id, 'material_id' => $mat->id],
                    [
                        'quantity'   => $item['qty'],
                        'unit_price' => $mat->unit_price,
                        'subtotal'   => $item['qty'] * $mat->unit_price,
                        'remarks'    => $item['remarks'],
                    ]
                );
            }
        }

        // =============================================
        // 8. Stock Alerts (barang yang stoknya di bawah minimum)
        // =============================================
        $lowStockMaterials = Material::whereColumn('current_stock', '<', 'minimum_stock')->get();

        foreach ($lowStockMaterials as $mat) {
            $alertType = ($mat->current_stock <= $mat->minimum_stock * 0.5) ? 'critical' : 'warning';

            StockAlert::firstOrCreate(
                ['material_id' => $mat->id, 'is_resolved' => false],
                [
                    'alert_type'    => $alertType,
                    'message'       => "Stok {$mat->material_name} tersisa {$mat->current_stock} {$mat->unit} — di bawah minimum {$mat->minimum_stock} {$mat->unit}",
                    'current_stock' => $mat->current_stock,
                    'minimum_stock' => $mat->minimum_stock,
                ]
            );
        }

        // Tambah beberapa alert yang sudah resolved (historis)
        $resolvedAlerts = [
            ['material_idx' => 2, 'message' => 'Stok Arrow sticker sempat kritis pada awal bulan', 'current' => 800, 'minimum' => 5000, 'type' => 'critical'],
            ['material_idx' => 1, 'message' => 'Stok Lakban Bening sempat mendekati minimum', 'current' => 180, 'minimum' => 200, 'type' => 'warning'],
        ];

        foreach ($resolvedAlerts as $alert) {
            $mat = $materialModels[$alert['material_idx']];
            StockAlert::firstOrCreate(
                ['material_id' => $mat->id, 'is_resolved' => true],
                [
                    'alert_type'    => $alert['type'],
                    'message'       => $alert['message'],
                    'current_stock' => $alert['current'],
                    'minimum_stock' => $alert['minimum'],
                    'is_resolved'   => true,
                    'resolved_at'   => $today->copy()->subDays(rand(5, 15)),
                    'resolved_by'   => $gudang->id,
                ]
            );
        }

        // =============================================
        // 9. Activity Logs (berbagai aksi dari semua role)
        // =============================================
        $activityLogs = [
            ['user' => $admin,    'action' => 'create', 'module' => 'users',        'desc' => 'Membuat akun user baru: Budi Santoso (staff_gudang)',            'days_ago' => 28],
            ['user' => $admin,    'action' => 'create', 'module' => 'users',        'desc' => 'Membuat akun user baru: Sari Dewi (staff_logistik)',             'days_ago' => 28],
            ['user' => $admin,    'action' => 'create', 'module' => 'materials',    'desc' => 'Menambahkan material baru: MAT-001 Tape cutter',                 'days_ago' => 27],
            ['user' => $admin,    'action' => 'create', 'module' => 'materials',    'desc' => 'Menambahkan 15 material data master',                             'days_ago' => 27],
            ['user' => $admin,    'action' => 'update', 'module' => 'settings',     'desc' => 'Mengubah low_stock_threshold_percent menjadi 30%',                'days_ago' => 27],
            ['user' => $gudang,   'action' => 'create', 'module' => 'stock_in',     'desc' => 'Input stok masuk: Lakban Bening Polos Besar 200 roll',            'days_ago' => 25],
            ['user' => $gudang,   'action' => 'create', 'module' => 'stock_in',     'desc' => 'Input stok masuk: Arrow sticker 10000 ea dari MIRE JAYA',         'days_ago' => 20],
            ['user' => $gudang,   'action' => 'create', 'module' => 'stock_out',    'desc' => 'Input stok keluar: Stiker LINE QC Checked 500 ea untuk F1',       'days_ago' => 18],
            ['user' => $logistik, 'action' => 'create', 'module' => 'purchase_orders', 'desc' => 'Membuat PO-2026-0001 ke MIRE JAYA INDONESIA PT.',             'days_ago' => 25],
            ['user' => $manager,  'action' => 'approve','module' => 'purchase_orders', 'desc' => 'Approve PO-2026-0001 — pengadaan stiker QC bulanan',           'days_ago' => 24],
            ['user' => $logistik, 'action' => 'create', 'module' => 'purchase_orders', 'desc' => 'Membuat PO-2026-0002 ke CHEONG MA TECH, PT.',                  'days_ago' => 20],
            ['user' => $manager,  'action' => 'approve','module' => 'purchase_orders', 'desc' => 'Approve PO-2026-0002 — floor tape marking area',               'days_ago' => 19],
            ['user' => $gudang,   'action' => 'create', 'module' => 'stock_in',     'desc' => 'Input stok masuk: Blue Floor Tape 20 ea dari PO-2026-0002',       'days_ago' => 12],
            ['user' => $logistik, 'action' => 'create', 'module' => 'purchase_orders', 'desc' => 'Membuat PO-2026-0005 ke SILKROAD INDONESIA PT.',               'days_ago' => 15],
            ['user' => $manager,  'action' => 'reject', 'module' => 'purchase_orders', 'desc' => 'Reject PO-2026-0005 — budget bulan ini melebihi alokasi',      'days_ago' => 14],
            ['user' => $gudang,   'action' => 'create', 'module' => 'stock_out',    'desc' => 'Input stok keluar: Stiker R 800 ea untuk AQL inspection F2',      'days_ago' => 10],
            ['user' => $logistik, 'action' => 'create', 'module' => 'purchase_orders', 'desc' => 'Membuat PO-2026-0003 ke MIRE JAYA — stiker R mendesak',        'days_ago' => 3],
            ['user' => $logistik, 'action' => 'create', 'module' => 'purchase_orders', 'desc' => 'Membuat PO-2026-0004 ke CV. DUTA ANGGARA — restok lakban',      'days_ago' => 1],
            ['user' => $gudang,   'action' => 'create', 'module' => 'stock_out',    'desc' => 'Input stok keluar: Lakban Lantai Merah 3 ea untuk marking F3',    'days_ago' => 1],
            ['user' => $logistik, 'action' => 'create', 'module' => 'purchase_orders', 'desc' => 'Membuat PO-2026-0006 ke MIRE JAYA — stiker FIFO menipis',      'days_ago' => 0],
        ];

        foreach ($activityLogs as $log) {
            ActivityLog::create([
                'user_id'     => $log['user']->id,
                'action'      => $log['action'],
                'module'      => $log['module'],
                'description' => $log['desc'],
                'ip_address'  => '192.168.1.' . rand(10, 99),
                'old_values'  => null,
                'new_values'  => null,
                'created_at'  => $today->copy()->subDays($log['days_ago'])->setTime(rand(7, 16), rand(0, 59)),
                'updated_at'  => $today->copy()->subDays($log['days_ago'])->setTime(rand(7, 16), rand(0, 59)),
            ]);
        }

        // =============================================
        // 10. Notifications (untuk manager & logistik)
        // =============================================
        $notifications = [
            ['user' => $manager,  'title' => 'PO Baru Menunggu Persetujuan',          'message' => 'PO-2026-0003 dari Sari Dewi menunggu approval Anda. Item: Stiker R & LINE QC Checked.',       'type' => 'warning', 'is_read' => false, 'days_ago' => 3],
            ['user' => $manager,  'title' => 'PO Baru Menunggu Persetujuan',          'message' => 'PO-2026-0004 dari Sari Dewi menunggu approval Anda. Item: Lakban Bening 500 roll.',            'type' => 'warning', 'is_read' => false, 'days_ago' => 1],
            ['user' => $manager,  'title' => 'PO Baru Menunggu Persetujuan',          'message' => 'PO-2026-0006 dari Sari Dewi menunggu approval Anda. Item: Stiker FIFO 4, 5, 6.',              'type' => 'warning', 'is_read' => false, 'days_ago' => 0],
            ['user' => $manager,  'title' => 'Alert: Stok Kritis',                   'message' => 'Stiker R (MAT-006) sudah di bawah 50% dari minimum stock. Sisa: 1200 ea, minimum: 3000 ea.', 'type' => 'error',   'is_read' => false, 'days_ago' => 2],
            ['user' => $logistik, 'title' => 'PO Ditolak oleh Manager',               'message' => 'PO-2026-0005 ditolak. Alasan: Budget bulan ini sudah melebihi alokasi.',                      'type' => 'error',   'is_read' => true,  'days_ago' => 14],
            ['user' => $logistik, 'title' => 'PO Disetujui',                          'message' => 'PO-2026-0001 sudah disetujui oleh Rudi Hartono.',                                             'type' => 'success', 'is_read' => true,  'days_ago' => 24],
            ['user' => $logistik, 'title' => 'PO Disetujui',                          'message' => 'PO-2026-0002 sudah disetujui oleh Rudi Hartono.',                                             'type' => 'success', 'is_read' => true,  'days_ago' => 19],
            ['user' => $logistik, 'title' => 'Alert: Stok Rendah Terdeteksi',         'message' => 'Lakban Lantai Merah tersisa 5 ea — di bawah minimum 10 ea. Segera buat PO.',                   'type' => 'warning', 'is_read' => false, 'days_ago' => 1],
            ['user' => $gudang,   'title' => 'Stok Berhasil Diperbarui',              'message' => 'Penerimaan Floor Tape dari PO-2026-0002 berhasil dicatat. 20 ea Blue Floor Tape.',             'type' => 'success', 'is_read' => true,  'days_ago' => 12],
            ['user' => $gudang,   'title' => 'Peringatan: Stok Menipis Setelah Keluar','message' => 'Stok Lakban Lantai Merah tinggal 5 ea setelah pengeluaran terakhir.',                         'type' => 'warning', 'is_read' => false, 'days_ago' => 1],
        ];

        foreach ($notifications as $notif) {
            Notification::create([
                'user_id'    => $notif['user']->id,
                'title'      => $notif['title'],
                'message'    => $notif['message'],
                'type'       => $notif['type'],
                'is_read'    => $notif['is_read'],
                'read_at'    => $notif['is_read'] ? $today->copy()->subDays($notif['days_ago']) : null,
                'created_at' => $today->copy()->subDays($notif['days_ago'])->setTime(rand(7, 16), rand(0, 59)),
                'updated_at' => $today->copy()->subDays($notif['days_ago'])->setTime(rand(7, 16), rand(0, 59)),
            ]);
        }

        // =============================================
        // 11. Stock Predictions (SMA-3 untuk 5 material teratas)
        // =============================================
        $predictMaterials = array_slice($materialModels, 0, 5);

        foreach ($predictMaterials as $mat) {
            // Simulasi prediksi SMA-3 selama 7 hari terakhir
            for ($day = 7; $day >= 1; $day--) {
                $predDate = $today->copy()->subDays($day);
                $predictedUsage = rand(50, 300);
                $actualUsage = $predictedUsage + rand(-30, 30); // deviasi +/- 30
                $accuracy = $actualUsage > 0 ? round(min(100, ($predictedUsage / $actualUsage) * 100), 2) : 100;

                StockPrediction::create([
                    'material_id'     => $mat->id,
                    'period'          => 3,
                    'method'          => 'SMA',
                    'predicted_value' => $predictedUsage,
                    'actual_value'    => $actualUsage,
                    'accuracy'        => min(100, $accuracy),
                    'prediction_date' => $predDate->toDateString(),
                ]);
            }
        }
    }

    /**
     * Generate jumlah pengeluaran realistis berdasarkan tipe material
     */
    private function getRealisticOutQty(Material $material): int
    {
        return match (true) {
            $material->unit === 'ea' && $material->unit_price <= 5     => rand(100, 500),   // stiker murah → banyak dipakai
            $material->unit === 'ea' && $material->unit_price <= 50    => rand(20, 100),     // stiker medium
            $material->unit === 'ea' && $material->unit_price > 50     => rand(1, 5),        // floor tape mahal
            $material->unit === 'roll'                                 => rand(5, 20),       // lakban roll
            $material->unit === 'pcs'                                  => rand(1, 3),        // tape cutter
            $material->unit === 'pack'                                 => rand(2, 10),       // stiker pack
            default                                                    => rand(1, 10),
        };
    }

    /**
     * Generate jumlah penerimaan realistis (biasanya lebih besar dari out)
     */
    private function getRealisticInQty(Material $material): int
    {
        return match (true) {
            $material->unit === 'ea' && $material->unit_price <= 5     => rand(2000, 5000),
            $material->unit === 'ea' && $material->unit_price <= 50    => rand(500, 2000),
            $material->unit === 'ea' && $material->unit_price > 50     => rand(5, 20),
            $material->unit === 'roll'                                 => rand(100, 300),
            $material->unit === 'pcs'                                  => rand(10, 30),
            $material->unit === 'pack'                                 => rand(20, 50),
            default                                                    => rand(10, 50),
        };
    }
}
