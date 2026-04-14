<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header Section -->
        <header class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Dashboard Prediksi</h2>
                <p class="text-xs text-slate-500 font-medium">Simple Moving Average (SMA) untuk Optimasi Stok</p>
            </div>
            <div class="flex gap-3">
                <div
                    class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant px-4 py-2 rounded-lg text-primary text-xs font-bold uppercase tracking-widest hover:bg-surface-container-low transition-all">
                    <span
                        class="text-xs font-bold text-on-surface-variant uppercase tracking-widest font-label">Status:</span>
                    <span class="flex items-center gap-1.5 text-primary text-sm font-bold">
                        <span class="w-2 h-2 rounded-full bg-primary"></span> Data Langsung
                    </span>
                </div>
            </div>
        </header>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $safeCount = $materialsWithPredictions->where('stock_status', 3)->count();
                $warningCount = $materialsWithPredictions->where('stock_status', 2)->count();
                $lowStockCount = $materialsWithPredictions->where('stock_status', 1)->count();
                $criticalCount = $materialsWithPredictions->where('stock_status', 0)->count();
            @endphp
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Items
                        Aman</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-green-600">{{ $safeCount }}</span>
                        <span class="text-[11px] font-bold text-green-600/60">Items</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="check_circle">check_circle</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-green-600 font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="check_circle">check_circle</span>
                    STOK AMAN
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Peringatan</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-tertiary">{{ $warningCount }}</span>
                        <span class="text-[11px] font-bold text-tertiary/60">Items</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="warning">warning</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-tertiary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="warning">warning</span>
                    PERLU PERHATIAN
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Stok
                        Rendah</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-orange-500">{{ $lowStockCount }}</span>
                        <span class="text-[11px] font-bold text-orange-500/60">Items</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="error">error</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-orange-500 font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="error">error</span>
                    STOK RENDAH
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Stok
                        Habis</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-error">{{ $criticalCount }}</span>
                        <span class="text-[11px] font-bold text-error/60">Items</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="dangerous">dangerous</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-error font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="dangerous">dangerous</span>
                    KRITIS
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">SMA Period</label>
                <div class="flex gap-2">
                    <button type="submit" name="period" value="3" class="flex-1 py-2 text-xs font-bold border-2 {{ $period == 3 ? 'border-primary bg-primary text-white' : 'border-outline-variant text-on-surface-variant hover:border-primary' }} rounded-lg transition-colors">3D</button>
                    <button type="submit" name="period" value="5" class="flex-1 py-2 text-xs font-bold border-2 {{ $period == 5 ? 'border-primary bg-primary text-white' : 'border-outline-variant text-on-surface-variant hover:border-primary' }} rounded-lg transition-colors">5D</button>
                    <button type="submit" name="period" value="7" class="flex-1 py-2 text-xs font-bold border-2 {{ $period == 7 ? 'border-primary bg-primary text-white' : 'border-outline-variant text-on-surface-variant hover:border-primary' }} rounded-lg transition-colors">7D</button>
                </div>
            </div>
            <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Periode Prediksi</label>
                <div class="relative">
                    <select name="horizon" onchange="this.form.submit()" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                        <option value="7" {{ $horizon == 7 ? 'selected' : '' }}>7 Hari ke Depan</option>
                        <option value="14" {{ $horizon == 14 ? 'selected' : '' }}>14 Hari ke Depan</option>
                        <option value="30" {{ $horizon == 30 ? 'selected' : '' }}>30 Hari ke Depan</option>
                    </select>
                </div>
            </div>
            <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Status</label>
                <div class="relative">
                    <select name="status" onchange="this.form.submit()" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                        <option value="">Semua Status</option>
                        <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Aman</option>
                        <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Peringatan</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Stok Rendah</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Stok Habis</option>
                    </select>
                </div>
            </div>
            <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-2 justify-end">
                <button type="submit" class="bg-primary text-white px-6 py-1 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all flex items-center gap-2 justify-center w-full">
                    <span class="material-symbols-outlined text-sm">filter_list</span>
                    Filter
                </button>
                <a href="{{ route('logistik.prediction') }}" class="bg-error text-white px-6 py-[6px] rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-error/90 transition-all flex items-center gap-2 justify-center w-full">
                    Bersihkan
                </a>
            </div>
        </form>

        <!-- Prediction Table -->
        <section
            class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/15 overflow-hidden">
            <div class="p-6 border-b border-outline-variant/10 flex justify-between items-center">
                <h3 class="font-headline text-lg font-bold text-on-surface tracking-tight">
                    Analisis Prediksi Stok
                </h3>
            </div>
            <table class="w-full text-left">
                <thead
                    class="bg-surface-container-low text-[10px] font-black text-on-surface-variant uppercase tracking-widest font-label">
                    <tr>
                        <th class="px-6 py-4">Material</th>
                        <th class="px-6 py-4 text-right">Stok Saat Ini</th>
                        <th class="px-6 py-4 text-right">Stok Minimum</th>
                        <th class="px-6 py-4 text-right">SMA-{{ $period }}</th>
                        <th class="px-6 py-4">Hari Tersisa</th>
                        <th class="px-6 py-4">Perkiraan Habis</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10 text-sm">
                    @forelse($materialsWithPredictions as $material)
                        <tr
                            class="hover:bg-surface-container-low transition-colors {{ $material->stock_status == 0 || $material->stock_status == 1 ? 'bg-error/5' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-on-surface">{{ $material->material_code }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $material->material_name }}</span>
                                </div>
                            </td>
                            <td
                                class="px-6 py-4 text-right font-medium {{ $material->current_stock < $material->minimum_stock ? 'text-error' : '' }}">
                                {{ number_format($material->current_stock) }} {{ $material->unit }}
                            </td>
                            <td class="px-6 py-4 text-right text-slate-500">
                                {{ number_format($material->minimum_stock) }}
                            </td>
                            <td class="px-6 py-4 text-right font-medium">
                                {{ number_format($material->predicted_daily_usage, 1) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($material->days_remaining !== null)
                                    <span
                                        class="font-bold {{ $material->days_remaining <= 7 ? 'text-error' : ($material->days_remaining <= 14 ? 'text-tertiary' : 'text-primary') }}">
                                        {{ $material->days_remaining }} Hari
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($material->estimated_runout_date)
                                    <span class="text-xs">
                                        {{ $material->estimated_runout_date->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($material->stock_status == 0)
                                    <span class="text-error text-[10px] px-2 py-1 rounded font-bold uppercase">Stok Habis</span>
                                @elseif($material->stock_status == 1)
                                    <span class="text-error text-[10px] px-2 py-1 rounded font-bold uppercase">Stok Rendah</span>
                                @elseif($material->stock_status == 2)
                                    <span class="text-tertiary text-[10px] px-2 py-1 rounded font-bold uppercase">Peringatan</span>
                                @else
                                    <span class="text-primary text-[10px] px-2 py-1 rounded font-bold uppercase">Aman</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($material->stock_status <= 1)
                                    <a href="{{ route('logistik.po') }}?material_id={{ $material->id }}"
                                        class="text-xs text-primary font-bold hover:underline">Buat PO</a>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-slate-500">
                                Tidak ada material ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
</x-dashboard-layout>