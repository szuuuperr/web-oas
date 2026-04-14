<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Ekspor Data Laporan</h2>
                <p class="text-xs text-slate-500 font-medium">Download dan export laporan operasional</p>
            </div>
            <div class="flex gap-3">
                <button class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant px-4 py-2 rounded-lg text-primary text-xs font-bold uppercase tracking-widest hover:bg-surface-container-low transition-all">
                    <span class="material-symbols-outlined text-sm" data-icon="history">history</span>
                    Riwayat
                </button>
            </div>
        </div>

        <!-- Quick Stats -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Ekspor Bulan Ini</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-primary">24</span>
                        <span class="text-[11px] font-bold text-primary/60">File</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="download">download</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-primary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="trending_up">trending_up</span>
                    +8% VS LAST MONTH
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Download Size</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-on-surface">8.4</span>
                        <span class="text-[11px] font-bold text-slate-400">MB</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="storage">storage</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="folder">folder</span>
                    ALL FORMATS
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Laporan Tersedia</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-tertiary">4</span>
                        <span class="text-[11px] font-bold text-tertiary/60">Jenis</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="description">description</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-tertiary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="inventory_2">inventory_2</span>
                    READY TO EXPORT
                </div>
            </div>
        </section>

        <!-- Filter Section -->
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
                <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Jenis Laporan</label>
                <div class="relative">
                    <select class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                        <option>Semua Laporan</option>
                        <option>Laporan Inventaris</option>
                        <option>Laporan Prediksi</option>
                        <option>Laporan PO</option>
                        <option>Summary Report</option>
                    </select>
                </div>
            </div>
            <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Format File</label>
                <div class="relative">
                    <select class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                        <option>PDF</option>
                        <option>Excel (.xlsx)</option>
                        <option>CSV</option>
                    </select>
                </div>
            </div>
        </section>

        <!-- Available Reports -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Laporan Tersedia</h2>
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
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Nama Laporan</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Deskripsi</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Periode</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Data Count</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Last Updated</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary" data-icon="inventory">inventory</span>
                                    </div>
                                    <span class="text-sm font-bold text-on-surface">Laporan Inventaris</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-sm text-on-surface-variant">Laporan pergerakan stok gudang</td>
                            <td class="px-8 py-5 text-sm font-medium">Apr 2026</td>
                            <td class="px-8 py-5 text-sm font-medium">150 SKU</td>
                            <td class="px-8 py-5 text-sm text-on-surface-variant">12 Apr 2026</td>
                            <td class="px-8 py-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('manager.export.download', ['type' => 'inventaris', 'format' => 'pdf']) }}" class="flex items-center gap-1 px-3 py-1.5 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary/90 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="download">download</span>
                                        PDF
                                    </a>
                                    <a href="{{ route('manager.export.download', ['type' => 'inventaris', 'format' => 'excel']) }}" class="flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="table">table</span>
                                        Excel
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-tertiary/10 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-tertiary" data-icon="trending_up">trending_up</span>
                                    </div>
                                    <span class="text-sm font-bold text-on-surface">Laporan Prediksi</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-sm text-on-surface-variant">Data forecasting SMA</td>
                            <td class="px-8 py-5 text-sm font-medium">14 Days</td>
                            <td class="px-8 py-5 text-sm font-medium">128 Items</td>
                            <td class="px-8 py-5 text-sm text-on-surface-variant">12 Apr 2026</td>
                            <td class="px-8 py-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('manager.export.download', ['type' => 'prediksi', 'format' => 'pdf']) }}" class="flex items-center gap-1 px-3 py-1.5 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary/90 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="download">download</span>
                                        PDF
                                    </a>
                                    <a href="{{ route('manager.export.download', ['type' => 'prediksi', 'format' => 'excel']) }}" class="flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="table">table</span>
                                        Excel
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-green-600" data-icon="shopping_cart">shopping_cart</span>
                                    </div>
                                    <span class="text-sm font-bold text-on-surface">Laporan Purchase Order</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-sm text-on-surface-variant">Purchase order approved/rejected</td>
                            <td class="px-8 py-5 text-sm font-medium">Apr 2026</td>
                            <td class="px-8 py-5 text-sm font-medium">145 PO</td>
                            <td class="px-8 py-5 text-sm text-on-surface-variant">12 Apr 2026</td>
                            <td class="px-8 py-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('manager.export.download', ['type' => 'po', 'format' => 'pdf']) }}" class="flex items-center gap-1 px-3 py-1.5 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary/90 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="download">download</span>
                                        PDF
                                    </a>
                                    <a href="{{ route('manager.export.download', ['type' => 'po', 'format' => 'excel']) }}" class="flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="table">table</span>
                                        Excel
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-secondary" data-icon="assessment">assessment</span>
                                    </div>
                                    <span class="text-sm font-bold text-on-surface">Summary Report</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-sm text-on-surface-variant">Ringkasan keseluruhan operasional</td>
                            <td class="px-8 py-5 text-sm font-medium">Q1 2026</td>
                            <td class="px-8 py-5 text-sm font-medium">-</td>
                            <td class="px-8 py-5 text-sm text-on-surface-variant">10 Apr 2026</td>
                            <td class="px-8 py-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('manager.export.download', ['type' => 'summary', 'format' => 'pdf']) }}" class="flex items-center gap-1 px-3 py-1.5 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary/90 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="download">download</span>
                                        PDF
                                    </a>
                                    <a href="{{ route('manager.export.download', ['type' => 'summary', 'format' => 'excel']) }}" class="flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="table">table</span>
                                        Excel
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-8 py-6 bg-surface-container-low flex justify-between items-center">
                <span class="text-xs text-outline">Menampilkan 4 dari 4 laporan</span>
            </div>
        </section>

        <!-- Recent Export History -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Riwayat Ekspor Terbaru</h2>
                <button class="text-primary text-xs font-bold hover:underline">Lihat Semua</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low/50">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Tanggal</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Nama File</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Jenis Laporan</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Format</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Ukuran</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-4 text-sm text-on-surface">12 Apr 2026, 14:30</td>
                            <td class="px-8 py-4">
                                <span class="text-sm font-medium text-on-surface">laporan_inventaris_apr2026.xlsx</span>
                            </td>
                            <td class="px-8 py-4 text-sm text-on-surface-variant">Laporan Inventaris</td>
                            <td class="px-8 py-4">
                                <span class="text-[10px] font-bold bg-green-500/20 text-green-700 px-2 py-1 rounded">Excel</span>
                            </td>
                            <td class="px-8 py-4 text-sm text-on-surface-variant">2.4 MB</td>
                            <td class="px-8 py-4 text-center">
                                <button class="p-2 hover:bg-surface-container-low rounded-lg transition-colors text-primary" title="Download Again">
                                    <span class="material-symbols-outlined text-sm" data-icon="download">download</span>
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-4 text-sm text-on-surface">11 Apr 2026, 10:15</td>
                            <td class="px-8 py-4">
                                <span class="text-sm font-medium text-on-surface">laporan_prediksi_apr2026.pdf</span>
                            </td>
                            <td class="px-8 py-4 text-sm text-on-surface-variant">Laporan Prediksi</td>
                            <td class="px-8 py-4">
                                <span class="text-[10px] font-bold bg-error/20 text-error px-2 py-1 rounded">PDF</span>
                            </td>
                            <td class="px-8 py-4 text-sm text-on-surface-variant">1.8 MB</td>
                            <td class="px-8 py-4 text-center">
                                <button class="p-2 hover:bg-surface-container-low rounded-lg transition-colors text-primary" title="Download Again">
                                    <span class="material-symbols-outlined text-sm" data-icon="download">download</span>
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-4 text-sm text-on-surface">10 Apr 2026, 09:00</td>
                            <td class="px-8 py-4">
                                <span class="text-sm font-medium text-on-surface">laporan_po_apr2026.xlsx</span>
                            </td>
                            <td class="px-8 py-4 text-sm text-on-surface-variant">Laporan PO</td>
                            <td class="px-8 py-4">
                                <span class="text-[10px] font-bold bg-green-500/20 text-green-700 px-2 py-1 rounded">Excel</span>
                            </td>
                            <td class="px-8 py-4 text-sm text-on-surface-variant">3.2 MB</td>
                            <td class="px-8 py-4 text-center">
                                <button class="p-2 hover:bg-surface-container-low rounded-lg transition-colors text-primary" title="Download Again">
                                    <span class="material-symbols-outlined text-sm" data-icon="download">download</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-8 py-6 bg-surface-container-low flex justify-between items-center">
                <span class="text-xs text-outline">Menampilkan 3 dari 24 entri</span>
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
