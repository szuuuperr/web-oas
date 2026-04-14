<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Laporan Inventaris</h2>
                <p class="text-xs text-slate-500 font-medium">Analisis pergerakan stok real-time dan performa gudang</p>
            </div>
            <div class="flex gap-3">
                <button class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant px-4 py-2 rounded-lg text-primary text-xs font-bold uppercase tracking-widest hover:bg-surface-container-low transition-all">
                    <span class="material-symbols-outlined text-sm" data-icon="description">description</span>
                    Excel
                </button>
                <button class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined text-sm" data-icon="picture_as_pdf">picture_as_pdf</span>
                    Export PDF
                </button>
            </div>
        </div>

        <!-- Summary Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Masuk</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-primary">42,850</span>
                        <span class="text-[11px] font-bold text-primary/60">Unit</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="south_east">south_east</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-primary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="trending_up">trending_up</span>
                    +12.4% VS LAST MONTH
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Keluar</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-error">38,120</span>
                        <span class="text-[11px] font-bold text-error/60">Unit</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="north_east">north_east</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-error font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="trending_down">trending_down</span>
                    -2.1% VS LAST MONTH
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Stok Akhir</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-on-surface">125,490</span>
                        <span class="text-[11px] font-bold text-slate-400">Unit</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="inventory">inventory</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="check_circle">check_circle</span>
                    STABLE
                </div>
            </div>
        </section>

        <!-- Advanced Filter Section -->
        <section class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2 p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Rentang Tanggal</label>
                <div class="flex items-center gap-3">
                    <div class="flex-1 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-slate-400 text-sm" data-icon="calendar_today">calendar_today</span>
                        <input class="bg-transparent border-none p-0 text-sm focus:ring-0 w-full" type="date" value="2026-04-01"/>
                    </div>
                    <span class="text-slate-400 text-xs font-bold">TO</span>
                    <div class="flex-1 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-slate-400 text-sm" data-icon="calendar_today">calendar_today</span>
                        <input class="bg-transparent border-none p-0 text-sm focus:ring-0 w-full" type="date" value="2026-04-12"/>
                    </div>
                </div>
            </div>
            <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Kategori Barang</label>
                <div class="relative">
                    <select class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                        <option>Semua Kategori</option>
                        <option>Bahan Baku</option>
                        <option>Suku Cadang Mesin</option>
                        <option>Alat Pelindung Diri (APD)</option>
                    </select>
                </div>
            </div>
            <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Jenis Laporan</label>
                <div class="flex p-1 bg-surface-container-lowest rounded-lg">
                    <button class="flex-1 py-1.5 text-xs font-bold bg-white text-primary rounded shadow-sm">Rekap</button>
                    <button class="flex-1 py-1.5 text-xs font-medium text-outline hover:bg-white/50 rounded">Masuk</button>
                    <button class="flex-1 py-1.5 text-xs font-medium text-outline hover:bg-white/50 rounded">Keluar</button>
                </div>
            </div>
        </section>

        <!-- Analytics Bento Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Top 10 Barang Paling Banyak Keluar -->
            <div class="lg:col-span-8 bg-surface-container-lowest p-8 rounded-2xl shadow-sm">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h4 class="text-xl font-headline font-bold text-on-background">Top 10 Barang Paling Banyak Keluar</h4>
                        <p class="text-sm text-outline">Distribusi volume pengeluaran berdasarkan SKU</p>
                    </div>
                    <button class="p-2 hover:bg-surface-container-low rounded transition-all">
                        <span class="material-symbols-outlined text-slate-400">more_vert</span>
                    </button>
                </div>
                <div class="space-y-5">
                    <div class="relative">
                        <div class="flex justify-between text-[10px] font-bold text-outline mb-1">
                            <span>RUBBER COMPOUND A-102</span>
                            <span>8,400 Unit</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container-high rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full" style="width: 95%"></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="flex justify-between text-[10px] font-bold text-outline mb-1">
                            <span>SYNTHETIC LEATHER WHITE</span>
                            <span>6,200 Unit</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container-high rounded-full overflow-hidden">
                            <div class="h-full bg-primary-container rounded-full" style="width: 78%"></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="flex justify-between text-[10px] font-bold text-outline mb-1">
                            <span>EVA FOAM MIDSOLE L4</span>
                            <span>5,900 Unit</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container-high rounded-full overflow-hidden">
                            <div class="h-full bg-primary-container rounded-full" style="width: 72%"></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="flex justify-between text-[10px] font-bold text-outline mb-1">
                            <span>INDUSTRIAL ADHESIVE V3</span>
                            <span>4,100 Unit</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container-high rounded-full overflow-hidden">
                            <div class="h-full bg-primary-container rounded-full" style="width: 55%"></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="flex justify-between text-[10px] font-bold text-outline mb-1">
                            <span>NYLON THREAD 40/2 BLUE</span>
                            <span>3,850 Unit</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container-high rounded-full overflow-hidden">
                            <div class="h-full bg-primary-container rounded-full" style="width: 50%"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-8 pt-6 border-t border-slate-100 flex justify-center">
                    <button class="text-primary text-xs font-bold hover:underline">Lihat Semua Data Grafik</button>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="lg:col-span-4 bg-surface-container-low p-8 rounded-2xl">
                <h4 class="text-xl font-headline font-bold text-on-background mb-6">Aktivitas Terakhir</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-2 h-10 bg-primary rounded-full"></div>
                        <div>
                            <p class="text-xs font-bold text-on-background">Penerimaan Barang #PO-992</p>
                            <p class="text-[10px] text-outline">12 Menit yang lalu</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-2 h-10 bg-error rounded-full"></div>
                        <div>
                            <p class="text-xs font-bold text-on-background">Pengeluaran Produksi Line 4</p>
                            <p class="text-[10px] text-outline">45 Menit yang lalu</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-2 h-10 bg-tertiary rounded-full"></div>
                        <div>
                            <p class="text-xs font-bold text-on-background">Koreksi Stok (Audit)</p>
                            <p class="text-[10px] text-outline">2 Jam yang lalu</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-2 h-10 bg-primary rounded-full"></div>
                        <div>
                            <p class="text-xs font-bold text-on-background">Penerimaan Barang #PO-991</p>
                            <p class="text-[10px] text-outline">4 Jam yang lalu</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 p-4 bg-surface-container-highest rounded-lg border border-outline-variant/20">
                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider mb-2">Pemberitahuan Sistem</p>
                    <p class="text-xs italic text-on-surface-variant">"Forecasting untuk minggu depan menunjukkan potensi kekurangan bahan Rubber A-102."</p>
                </div>
            </div>
        </div>

        <!-- Detail Table -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Detail Pergerakan Barang</h2>
                <div class="flex gap-2">
                    <button class="p-1.5 rounded-lg bg-surface-container-low text-slate-500 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-sm" data-icon="filter_list">filter_list</span>
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low/50">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Kode SKU</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Nama Barang</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Stok Awal</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Masuk (+)</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Keluar (-)</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Stok Akhir</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em] text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5 text-sm font-bold text-primary">SKU-RC-102</td>
                            <td class="px-8 py-5 text-sm text-on-surface">Rubber Compound A-102</td>
                            <td class="px-8 py-5 text-sm font-medium">1,200</td>
                            <td class="px-8 py-5 text-sm font-medium text-primary">8,400</td>
                            <td class="px-8 py-5 text-sm font-medium text-error">7,200</td>
                            <td class="px-8 py-5 text-sm font-bold">2,400</td>
                            <td class="px-8 py-5 text-center">
                                <span class="bg-primary-fixed text-[10px] font-bold px-2 py-1 rounded text-on-primary-fixed">OPTIMAL</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5 text-sm font-bold text-primary">SKU-LE-WHT</td>
                            <td class="px-8 py-5 text-sm text-on-surface">Synthetic Leather White</td>
                            <td class="px-8 py-5 text-sm font-medium">850</td>
                            <td class="px-8 py-5 text-sm font-medium text-primary">6,200</td>
                            <td class="px-8 py-5 text-sm font-medium text-error">6,500</td>
                            <td class="px-8 py-5 text-sm font-bold text-error">550</td>
                            <td class="px-8 py-5 text-center">
                                <span class="bg-error-container text-[10px] font-bold px-2 py-1 rounded text-on-error-container">LOW STOCK</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5 text-sm font-bold text-primary">SKU-EV-MS4</td>
                            <td class="px-8 py-5 text-sm text-on-surface">EVA Foam Midsole L4</td>
                            <td class="px-8 py-5 text-sm font-medium">4,500</td>
                            <td class="px-8 py-5 text-sm font-medium text-primary">1,200</td>
                            <td class="px-8 py-5 text-sm font-medium text-error">800</td>
                            <td class="px-8 py-5 text-sm font-bold">4,900</td>
                            <td class="px-8 py-5 text-center">
                                <span class="bg-primary-fixed text-[10px] font-bold px-2 py-1 rounded text-on-primary-fixed">OPTIMAL</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5 text-sm font-bold text-primary">SKU-AD-V03</td>
                            <td class="px-8 py-5 text-sm text-on-surface">Industrial Adhesive V3</td>
                            <td class="px-8 py-5 text-sm font-medium">3,100</td>
                            <td class="px-8 py-5 text-sm font-medium text-primary">2,500</td>
                            <td class="px-8 py-5 text-sm font-medium text-error">4,100</td>
                            <td class="px-8 py-5 text-sm font-bold">1,500</td>
                            <td class="px-8 py-5 text-center">
                                <span class="bg-tertiary-fixed text-[10px] font-bold px-2 py-1 rounded text-on-tertiary-fixed">WARNING</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-8 py-6 bg-surface-container-low flex justify-between items-center">
                <span class="text-xs text-outline">Menampilkan 4 dari 150 SKU</span>
                <div class="flex gap-1">
                    <button class="w-8 h-8 flex items-center justify-center rounded border border-outline-variant bg-white shadow-sm">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-surface-container-high">2</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-surface-container-high">3</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-surface-container-high">
                        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
                    </button>
                </div>
            </div>
        </section>
    </div>
</x-dashboard-layout>