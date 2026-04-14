<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Dashboard Logistik</h2>
                <p class="text-xs text-slate-500 font-medium">Monitoring supply chain dan inventory</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('logistik.po') }}" class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant px-4 py-2 rounded-lg text-primary text-xs font-bold uppercase tracking-widest hover:bg-surface-container-low transition-all">
                    <span class="material-symbols-outlined text-sm" data-icon="add_box">add_box</span>
                    Buat PO
                </a>
                <a href="{{ route('logistik.prediction') }}" class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined text-sm" data-icon="insights">insights</span>
                    Lihat Prediksi
                </a>
            </div>
        </div>

        <!-- Summary Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Peringatan Stok Rendah Aktif</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-error">{{ $activeAlerts }}</span>
                        <span class="text-[11px] font-bold text-error/60">Alert</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="warning">warning</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] {{ $activeAlerts > 0 ? 'text-error font-bold' : 'text-green-600 font-bold' }}">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="{{ $activeAlerts > 0 ? 'error' : 'check_circle' }}">{{ $activeAlerts > 0 ? 'error' : 'check_circle' }}</span>
                    {{ $activeAlerts > 0 ? 'PERLU PERHATIAN' : 'STOK AMAN' }}
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">PO Menunggu Persetujuan</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-primary">{{ $pendingPO }}</span>
                        <span class="text-[11px] font-bold text-primary/60">PO</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="pending_actions">pending_actions</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="schedule">schedule</span>
                    TOTAL VALUE: Rp {{ number_format($totalPOValue, 0, ',', '.') }}
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Items Stok Rendah</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-tertiary">{{ $lowStockItems }}</span>
                        <span class="text-[11px] font-bold text-tertiary/60">Items</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="inventory_2">inventory_2</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-tertiary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="trending_down">trending_down</span>
                    DI BAWAH MINIMUM
                </div>
            </div>
        </section>

        <!-- Table Section - Critical Stock Forecast -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Prakiraan Minggu Depan</h2>
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
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Kode Material</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Stok Saat Ini</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Prakiraan Permintaan</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Perkiraan Habis</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Status</th>
                            <th class="px-8 py-4 text-right text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        @forelse($recentPO as $po)
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-on-surface">{{ $po->po_number }}</span>
                                    <span class="text-xs text-slate-400">{{ $po->supplier->name ?? 'No Supplier' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-sm font-medium">{{ number_format($po->total_amount) }}</td>
                            <td class="px-8 py-5">
                                <span class="text-xs text-slate-500">{{ $po->order_date->format('d M Y') }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                                    {{ $po->status == 'approved' ? 'text-green-700' : 
                                       ($po->status == 'rejected' ? 'text-error' : 
                                       ($po->status == 'pending' ? 'text-yellow-700' : ' text-slate-700')) }}">
                                    {{ $po->status }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <a href="{{ route('logistik.po.show', $po->id) }}" class="text-primary hover:underline text-xs uppercase">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-8 text-center text-slate-400">Belum ada Purchase Order.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Top 10 Barang Paling Banyak Keluar & Aktivitas Terakhir -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Top 10 Barang Paling Banyak Keluar -->
            <div class="lg:col-span-8 bg-surface-container-lowest p-8 rounded-2xl shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h4 class="text-xl font-headline font-bold text-on-surface">Top 10 Barang Paling Banyak Keluar</h4>
                        <p class="text-sm text-slate-400">Distribusi volume pengeluaran berdasarkan SKU</p>
                    </div>
                </div>
                <div class="space-y-4">
                    @forelse($topOutgoingItems as $index => $item)
                    @php 
                        $maxValue = $topOutgoingItems->max('total_outgoing');
                        $percentage = $maxValue > 0 ? ($item->total_outgoing / $maxValue) * 100 : 0;
                    @endphp
                    <div class="relative">
                        <div class="flex justify-between text-[10px] font-bold text-slate-500 mb-1">
                            <span>{{ $item->material_name }}</span>
                            <span>{{ number_format($item->total_outgoing) }} {{ $item->unit }}</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container-high rounded-full overflow-hidden">
                            <div class="h-full bg-error rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 py-8">Tidak ada data</p>
                    @endforelse
                </div>
            </div>

            <!-- Aktivitas Terakhir -->
            <div class="lg:col-span-4 bg-surface-container-low p-8 rounded-2xl">
                <h4 class="text-xl font-headline font-bold text-on-surface mb-6">Aktivitas Terakhir</h4>
                <div class="space-y-6">
                    @forelse($recentActivity as $activity)
                    <div class="flex gap-4">
                        <div class="w-2 h-10 bg-primary rounded-full"></div>
                        <div>
                            <p class="text-xs font-medium text-on-surface">{{ $activity->description }}</p>
                            <p class="text-[10px] text-slate-400">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 text-sm">Tidak ada aktivitas terbaru</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Key Stock Trends (Mini Charts) -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Key Stock Trends (7D)</h2>
                <a href="{{ route('logistik.prediction') }}" class="text-primary text-xs font-bold hover:underline">Full Analytics</a>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Chart 1 -->
                <div class="bg-surface-container-low p-5 rounded-xl border border-outline-variant/5">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="text-sm font-bold text-on-surface">EVA-FOAM-402</h4>
                            <p class="text-[10px] text-slate-400">Rolling Average: 4.2k</p>
                        </div>
                        <span class="text-xs font-bold text-error">-12%</span>
                    </div>
                    <div class="h-16 flex items-end gap-1.5">
                        <div class="flex-1 bg-surface-container-highest rounded-t h-[80%]"></div>
                        <div class="flex-1 bg-surface-container-highest rounded-t h-[70%]"></div>
                        <div class="flex-1 bg-surface-container-highest rounded-t h-[60%]"></div>
                        <div class="flex-1 bg-surface-container-highest rounded-t h-[40%]"></div>
                        <div class="flex-1 bg-primary/20 rounded-t h-[30%] border-t-2 border-primary"></div>
                        <div class="flex-1 bg-error/20 rounded-t h-[20%] border-t-2 border-error"></div>
                        <div class="flex-1 bg-error/40 rounded-t h-[15%] border-t-2 border-error"></div>
                    </div>
                </div>
                <!-- Chart 2 -->
                <div class="bg-surface-container-low p-5 rounded-xl border border-outline-variant/5">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="text-sm font-bold text-on-surface">MESH-TIGER-BLK</h4>
                            <p class="text-[10px] text-slate-400">Rolling Average: 1.8k</p>
                        </div>
                        <span class="text-xs font-bold text-primary">+8%</span>
                    </div>
                    <div class="h-16 flex items-end gap-1.5">
                        <div class="flex-1 bg-surface-container-highest rounded-t h-[40%]"></div>
                        <div class="flex-1 bg-surface-container-highest rounded-t h-[45%]"></div>
                        <div class="flex-1 bg-surface-container-highest rounded-t h-[55%]"></div>
                        <div class="flex-1 bg-surface-container-highest rounded-t h-[65%]"></div>
                        <div class="flex-1 bg-primary/20 rounded-t h-[75%] border-t-2 border-primary"></div>
                        <div class="flex-1 bg-primary/40 rounded-t h-[80%] border-t-2 border-primary"></div>
                        <div class="flex-1 bg-primary/60 rounded-t h-[90%] border-t-2 border-primary"></div>
                    </div>
                </div>
                <!-- Chart 3 -->
                <div class="bg-surface-container-low p-5 rounded-xl border border-outline-variant/5">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="text-sm font-bold text-on-surface">GLUE-IND-77</h4>
                            <p class="text-[10px] text-slate-400">Rolling Average: 55L</p>
                        </div>
                        <span class="text-xs font-bold text-slate-400">Stable</span>
                    </div>
                    <div class="h-16 flex items-end gap-1.5">
                        <div class="flex-1 bg-surface-container-highest rounded-t h-[50%]"></div>
                        <div class="flex-1 bg-surface-container-highest rounded-t h-[52%]"></div>
                        <div class="flex-1 bg-surface-container-highest rounded-t h-[48%]"></div>
                        <div class="flex-1 bg-surface-container-highest rounded-t h-[51%]"></div>
                        <div class="flex-1 bg-secondary/20 rounded-t h-[50%] border-t-2 border-secondary"></div>
                        <div class="flex-1 bg-secondary/30 rounded-t h-[53%] border-t-2 border-secondary"></div>
                        <div class="flex-1 bg-secondary/40 rounded-t h-[50%] border-t-2 border-secondary"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-dashboard-layout>