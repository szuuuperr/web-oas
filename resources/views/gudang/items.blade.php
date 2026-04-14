<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Data Barang Gudang</h2>
                <p class="text-xs text-slate-500 font-medium">Lihat data material inventaris gudang</p>
            </div>
        </div>

        @php
            $totalMaterials = $materials->total();
            $categoryCount = $materials->pluck('category_id')->unique()->count();
            $lowStockCount = $materials->filter(fn($m) => $m->current_stock < $m->minimum_stock)->count();
        @endphp

        <!-- Summary Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Material</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-primary">{{ number_format($totalMaterials) }}</span>
                        <span class="text-[11px] font-bold text-primary/60">SKU</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="inventory_2">inventory_2</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-primary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="check_circle">check_circle</span>
                    SEMUA MATERIAL AKTIF
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Active Categories</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-on-surface">{{ $categoryCount }}</span>
                        <span class="text-[11px] font-bold text-slate-400">Types</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="category">category</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="check_circle">check_circle</span>
                    ALL ACTIVE
                </div>
            </div>
            <div class="bg-error-container/40 p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-error mb-2">Low Stock Items</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-error">{{ $lowStockCount }}</span>
                        <span class="text-[11px] font-bold text-error/60">ITEMS</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:opacity-20 transition-opacity text-error">
                    <span class="material-symbols-outlined text-8xl" data-icon="warning">warning</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-error font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="{{ $lowStockCount > 0 ? 'error' : 'check_circle' }}">{{ $lowStockCount > 0 ? 'error' : 'check_circle' }}</span>
                    {{ $lowStockCount > 0 ? 'NEEDS ATTENTION' : 'ALL STOCK HEALTHY' }}
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <form method="GET" action="{{ route('gudang.items') }}">
            <section class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Kategori</label>
                    <div class="relative">
                        <select name="category_id" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Supplier</label>
                    <div class="relative">
                        <select name="supplier_id" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="">Semua Supplier</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}" {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Status</label>
                    <div class="relative">
                        <select name="status" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="">Semua Status</option>
                            <option value="healthy" {{ request('status') === 'healthy' ? 'selected' : '' }}>Healthy</option>
                            <option value="replenish" {{ request('status') === 'replenish' ? 'selected' : '' }}>Replenish</option>
                            <option value="critical" {{ request('status') === 'critical' ? 'selected' : '' }}>Critical</option>
                        </select>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-2 justify-end">
                    <button type="submit" class="bg-primary text-white px-6 py-1 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all flex items-center gap-2 justify-center w-full">
                        <span class="material-symbols-outlined text-sm">filter_list</span>
                        Filter
                    </button>
                    <a href="{{ route('gudang.items') }}" class="bg-error text-white px-6 py-[5px] rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-error/90 transition-all flex items-center gap-2 justify-center w-full">
                        Clear
                    </a>
                </div>
            </section>
        </form>

        <!-- Table Section -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Material Inventory</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low/50">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">SKU</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Material Name</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Category</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Unit</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Current Stock</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Min Stock</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Supplier</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        @forelse($materials as $mat)
                            @php
                                $isLow = $mat->current_stock < $mat->minimum_stock;
                                $isCritical = $mat->minimum_stock > 0 && ($mat->current_stock / $mat->minimum_stock) <= 0.5;
                            @endphp
                            <tr class="hover:bg-surface-bright transition-colors group">
                                <td class="px-8 py-5 text-xs font-headline font-bold text-primary">{{ $mat->material_code }}</td>
                                <td class="px-8 py-5">
                                    <div class="text-xs font-bold text-on-surface">{{ $mat->material_name }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $mat->spec }}</div>
                                </td>
                                <td class="px-8 py-5 text-xs text-on-surface-variant">{{ $mat->category->name ?? '-' }}</td>
                                <td class="px-8 py-5 text-xs text-on-surface-variant">{{ ucfirst($mat->unit) }}</td>
                                <td class="px-8 py-5 text-xs font-bold {{ $isLow ? 'text-error' : 'text-primary' }}">{{ number_format($mat->current_stock) }}</td>
                                <td class="px-8 py-5 text-xs text-on-surface">{{ number_format($mat->minimum_stock) }}</td>
                                <td class="px-8 py-5 text-xs text-on-surface-variant">{{ $mat->supplier->name ?? '-' }}</td>
                                <td class="px-8 py-5">
                                    @if($isCritical)
                                        <span class="text-[10px] font-bold text-error uppercase">Critical</span>
                                    @elseif($isLow)
                                        <span class="text-[10px] font-bold text-tertiary uppercase">Replenish</span>
                                    @else
                                        <span class="text-[10px] font-bold text-primary uppercase">Healthy</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-8 py-12 text-center text-slate-400 text-sm">Belum ada data material</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($materials->hasPages())
                <div class="px-8 py-4 bg-surface-container-low/30">
                    {{ $materials->links() }}
                </div>
            @endif
        </section>
    </div>
</x-dashboard-layout>