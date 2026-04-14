<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Notifikasi Stok Rendah</h2>
                <p class="text-xs text-slate-500 font-medium">Peringatan stok di bawah threshold</p>
            </div>
            <a href="#" class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant px-4 py-2 rounded-lg text-primary text-xs font-bold uppercase tracking-widest hover:bg-surface-container-low transition-all">
                <span class="material-symbols-outlined text-sm" data-icon="settings">settings</span>
                Threshold Setting
            </a>
        </div>

        <!-- Summary Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Stok Habis</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-error">{{ $criticalCount }}</span>
                        <span class="text-[11px] font-bold text-error/60">Item</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="error">error</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-error font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="warning">warning</span>
                    CRITICAL ALERT
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Stok Rendah</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-tertiary">{{ $warningCount }}</span>
                        <span class="text-[11px] font-bold text-tertiary/60">Item</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="trending_down">trending_down</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="warning">warning</span>
                    NEEDS ATTENTION
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Alert</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-on-surface">{{ $activeCount }}</span>
                        <span class="text-[11px] font-bold text-slate-400">Item</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="notifications">notifications</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="schedule">schedule</span>
                    {{ $activeCount > 0 ? 'ACTIVE ALERTS' : 'ALL CLEAR' }}
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <form method="GET" action="{{ route('logistik.alerts') }}">
            <section class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Status Alert</label>
                    <div class="relative">
                        <select name="status" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="">Semua Alert</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>                        
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Tipe Alert</label>
                    <div class="relative">
                        <select name="type" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="">Semua Tipe</option>
                            <option value="critical" {{ request('type') === 'critical' ? 'selected' : '' }}>Stok Habis</option>
                            <option value="warning" {{ request('type') === 'warning' ? 'selected' : '' }}>Stok Rendah</option>
                        </select>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Material</label>
                    <div class="relative">
                        <select name="material_id" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="">Semua Material</option>
                            @foreach($lowStockMaterials as $mat)
                                <option value="{{ $mat->id }}" {{ request('material_id') == $mat->id ? 'selected' : '' }}>{{ $mat->material_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-2 justify-end">
                    <button type="submit" class="bg-primary text-white px-6 py-1 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all flex items-center gap-2 justify-center w-full">
                        <span class="material-symbols-outlined text-sm">filter_list</span>
                        Filter
                    </button>
                    <a href="{{ route('logistik.alerts') }}" class="bg-error text-white px-6 py-[6px] rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-error/90 transition-all flex items-center gap-2 justify-center w-full">
                        Clear
                    </a>
                </div>
            </section>
        </form>

        <!-- Table Section -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Daftar Alert Stok</h2>
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
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Nama Material</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Stok Saat Ini</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Stok Minimum</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Selisih</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Status</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        @forelse($alerts as $alert)
                        @php
                            $mat = $alert->material;
                            $difference = $mat->current_stock - $mat->minimum_stock;
                            $status = $alert->alert_type;
                        @endphp
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-on-surface">{{ $mat->material_name }}</span>
                                    <span class="text-xs text-slate-400">{{ $mat->material_code }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-medium {{ $status === 'critical' ? 'text-error' : 'text-tertiary' }}">{{ number_format($mat->current_stock) }}</span>
                                <span class="text-xs text-slate-400 ml-1">{{ $mat->unit }}</span>
                            </td>
                            <td class="px-8 py-5 text-sm text-on-surface">{{ number_format($mat->minimum_stock) }} {{ $mat->unit }}</td>
                            <td class="px-8 py-5 text-sm font-medium {{ $status === 'critical' ? 'text-error' : 'text-tertiary' }}">{{ $difference > 0 ? '+' : '' }}{{ number_format($difference) }}</td>
                            <td class="px-8 py-5">
                                @if($status === 'critical')
                                <span class="text-[10px] font-bold text-error uppercase tracking-tighter">Stok Habis</span>
                                @else
                                <span class="text-[10px] font-bold text-tertiary uppercase tracking-tighter">Stok Rendah</span>
                                @endif
                            </td>
                            <td class="px-8 py-5">
                                @if(!$alert->is_resolved)
                                <form action="{{ route('logistik.alerts.resolve', $alert->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs font-bold text-primary hover:underline uppercase">Tandai Selesai</button>
                                </form>
                                @else
                                <span class="text-xs font-bold text-green-600 uppercase">Resolved</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-12 text-center text-slate-400 text-sm">Tidak ada alert stok</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($alerts->hasPages())
            <div class="px-6 py-4 flex items-center justify-between bg-surface-container-low/20">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-widest">Menampilkan {{ $alerts->firstItem() ?? 0 }}-{{ $alerts->lastItem() ?? 0 }} dari {{ $alerts->total() }} entries</p>
                <div class="flex items-center gap-1">
                    {{ $alerts->links() }}
                </div>
            </div>
            @endif
        </section>
    </div>
</x-dashboard-layout>
