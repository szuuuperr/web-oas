<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Dashboard Gudang</h2>
                <p class="text-xs text-slate-500 font-medium">Monitoring stok dan transaksi gudang</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('gudang.stock-in') }}" class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined text-sm" data-icon="add_box">add_box</span>
                    Stok Masuk
                </a>
                <a href="{{ route('gudang.stock-out') }}" class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant px-4 py-2 rounded-lg text-primary text-xs font-bold uppercase tracking-widest hover:bg-surface-container-low transition-all">
                    <span class="material-symbols-outlined text-sm" data-icon="outbox">outbox</span>
                    Stok Keluar
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <!-- Summary Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Stock In (Hari Ini)</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-primary">{{ number_format($todayIn) }}</span>
                        <span class="text-[11px] font-bold text-primary/60">UNIT</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="move_to_inbox">move_to_inbox</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-primary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="inventory_2">inventory_2</span>
                    {{ number_format($totalItems) }} MATERIAL AKTIF
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Stock Out (Hari Ini)</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-on-surface">{{ number_format($todayOut) }}</span>
                        <span class="text-[11px] font-bold text-slate-400">UNIT</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="outbox">outbox</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="warehouse">warehouse</span>
                    TOTAL STOK: {{ number_format($totalStock) }}
                </div>
            </div>
            <div class="bg-error-container/40 p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-error mb-2">Low Stock Alerts</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-error">{{ $alertCount }}</span>
                        <span class="text-[11px] font-bold text-error/60">{{ $alertCount > 0 ? 'URGENT' : 'AMAN' }}</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:opacity-20 transition-opacity text-error">
                    <span class="material-symbols-outlined text-8xl" data-icon="warning">warning</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-error font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="{{ $alertCount > 0 ? 'error' : 'check_circle' }}">{{ $alertCount > 0 ? 'error' : 'check_circle' }}</span>
                    {{ $alertCount > 0 ? 'REQUIRES IMMEDIATE ACTION' : 'SEMUA STOK AMAN' }}
                </div>
            </div>
        </section>

        <!-- Operational Flow: Shortcuts & Alerts -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Quick Entry Shortcuts -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-primary p-8 rounded-2xl text-white shadow-xl shadow-primary/20 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="z-10">
                        <h3 class="font-headline text-2xl font-bold leading-tight">Stock In<br/>Management</h3>
                        <p class="text-[11px] text-white/70 uppercase tracking-widest mt-2">Inventory Arrival Entry</p>
                    </div>
                    <a href="{{ route('gudang.stock-in') }}" class="z-10 bg-white/10 backdrop-blur-md border border-white/20 px-6 py-2 rounded-full self-start text-xs font-bold uppercase tracking-widest hover:bg-white hover:text-primary transition-all active:scale-95">
                        New Transaction
                    </a>
                    <span class="material-symbols-outlined absolute -right-8 top-1/2 -translate-y-1/2 text-[140px] opacity-10" data-icon="add_circle">add_circle</span>
                </div>
                <div class="bg-surface-container-lowest p-8 rounded-2xl border border-outline-variant/10 flex flex-col justify-between h-48 relative overflow-hidden group">
                    <div class="z-10">
                        <h3 class="font-headline text-2xl font-bold leading-tight text-on-surface">Stock Out<br/>Dispatch</h3>
                        <p class="text-[11px] text-slate-400 uppercase tracking-widest mt-2">Material Release Entry</p>
                    </div>
                    <a href="{{ route('gudang.stock-out') }}" class="z-10 bg-surface-container-low px-6 py-2 rounded-full self-start text-xs font-bold uppercase tracking-widest text-primary hover:bg-primary hover:text-white transition-all active:scale-95">
                        Dispatch Items
                    </a>
                    <span class="material-symbols-outlined absolute -right-8 top-1/2 -translate-y-1/2 text-[140px] opacity-5 group-hover:opacity-10 transition-opacity" data-icon="remove_circle">remove_circle</span>
                </div>
            </div>

            <!-- Low Stock Inventory Matrix -->
            <div class="lg:col-span-8 bg-surface-container-low rounded-2xl p-6">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="font-headline text-lg font-extrabold text-on-surface">Critical Inventory Matrix</h2>
                        <p class="text-xs text-slate-500 font-medium">Items currently below safety buffer threshold</p>
                    </div>
                    <span class="text-[11px] font-bold text-error bg-error-container px-3 py-1 rounded-full uppercase tracking-widest">Live Monitoring</span>
                </div>
                <div class="space-y-4">
                    @forelse($lowStockItems as $item)
                        @php
                            $ratio = $item->minimum_stock > 0 ? ($item->current_stock / $item->minimum_stock) : 1;
                            $isCritical = $ratio <= 0.5;
                        @endphp
                        <div class="flex items-center justify-between p-4 bg-surface-container-lowest rounded-xl hover:bg-surface-bright transition-colors group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center">
                                    <span class="material-symbols-outlined text-slate-400" data-icon="category">category</span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-on-surface group-hover:text-primary transition-colors">{{ $item->material_name }}</div>
                                    <div class="text-[10px] text-slate-400 font-headline uppercase tracking-widest">{{ $item->material_code }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-12">
                                <div class="text-right">
                                    <div class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">In Stock</div>
                                    <div class="text-sm font-bold text-error">{{ number_format($item->current_stock) }} {{ ucfirst($item->unit) }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Min Req</div>
                                    <div class="text-sm font-bold text-on-surface">{{ number_format($item->minimum_stock) }} {{ ucfirst($item->unit) }}</div>
                                </div>
                                <div class="hidden sm:block">
                                    @if($isCritical)
                                        <span class="text-[10px] font-bold text-error uppercase">Critical</span>
                                    @else
                                        <span class="text-[10px] font-bold text-tertiary uppercase">Replenish</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400">
                            <span class="material-symbols-outlined text-4xl mb-2">check_circle</span>
                            <p class="text-sm font-medium">Semua stok dalam kondisi aman</p>
                        </div>
                    @endforelse
                </div>
                @if($alertCount > 0)
                    <button class="w-full mt-6 py-3 border-2 border-dashed border-outline-variant/30 text-[11px] font-headline font-bold text-slate-400 uppercase tracking-widest hover:border-primary/30 hover:text-primary transition-all">
                        View All {{ $alertCount }} Stock Alerts
                    </button>
                @endif
            </div>
        </section>

        <!-- Recent Log Activity -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Recent Warehouse Transactions</h2>
                <a href="{{ route('gudang.history') }}" class="text-xs font-bold text-primary hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low/50">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Transaction ID</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Material Description</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Type</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Quantity</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Timestamp</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Operator</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        @forelse($recentTransactions as $tx)
                            <tr class="hover:bg-surface-bright transition-colors group">
                                <td class="px-8 py-5 text-xs font-headline font-bold text-primary">#{{ $tx->transaction_code }}</td>
                                <td class="px-8 py-5">
                                    <div class="text-xs font-bold text-on-surface">{{ $tx->material->material_name }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $tx->batch_number ?? $tx->material->material_code }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    @if($tx->type === 'in')
                                        <span class="flex items-center text-[10px] font-bold text-primary">
                                            <span class="material-symbols-outlined text-xs mr-1" data-icon="arrow_downward" style="font-variation-settings: 'FILL' 1;">arrow_downward</span>
                                            MASUK
                                        </span>
                                    @else
                                        <span class="flex items-center text-[10px] font-bold text-error">
                                            <span class="material-symbols-outlined text-xs mr-1" data-icon="arrow_upward" style="font-variation-settings: 'FILL' 1;">arrow_upward</span>
                                            KELUAR
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-xs font-bold text-on-surface">
                                    {{ $tx->type === 'in' ? '+' : '-' }}{{ number_format($tx->quantity) }} {{ ucfirst($tx->material->unit) }}
                                </td>
                                <td class="px-8 py-5 text-[10px] text-slate-500">{{ $tx->transaction_date->format('d M Y') }}</td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center">
                                            <span class="text-[9px] font-bold text-primary">{{ substr($tx->user->name, 0, 1) }}</span>
                                        </div>
                                        <span class="text-[10px] font-bold text-on-surface">{{ $tx->user->name }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-12 text-center text-slate-400 text-sm">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-8 py-4 bg-surface-container-low/30 text-center">
                <a class="text-[11px] font-black text-primary uppercase tracking-[0.2em] hover:underline transition-all" href="{{ route('gudang.history') }}">Expand Full Transaction History</a>
            </div>
        </section>
    </div>
</x-dashboard-layout>