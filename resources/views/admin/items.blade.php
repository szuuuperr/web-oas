<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Master Data Material</h2>
                <p class="text-xs text-slate-500 font-medium">Kelola seluruh data material inventaris</p>
            </div>
            <button onclick="document.getElementById('itemModal').showModal()" class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-sm" data-icon="add">add</span>
                Tambah Material
            </button>
        </div>

        <!-- Summary Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Material</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-primary">{{ $materials->total() }}</span>
                        <span class="text-[11px] font-bold text-primary/60">SKU</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="inventory_2">inventory_2</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-primary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="trending_up">trending_up</span>
                    ALL TIME
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Active Categories</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-on-surface">{{ $totalCategories }}</span>
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
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="error">error</span>
                    NEEDS ATTENTION
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <form method="GET" action="{{ route('admin.items') }}">
            <section class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Cari</label>
                    <input type="text" name="search" placeholder="Cari kode atau nama material..." value="{{ request('search') }}" class="bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Kategori</label>
                    <div class="relative">
                        <select name="category_id" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="all">Semua Kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Status</label>
                    <div class="relative">
                        <select name="status" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="all">Semua Status</option>
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
                    <a href="{{ route('admin.items') }}" class="bg-error text-white px-6 py-[6px] rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-error/90 transition-all flex items-center gap-2 justify-center w-full">
                        Clear
                    </a>
                </div>
            </section>
        </form>

        <!-- Table Section -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Material Inventory</h2>
                <div class="flex gap-2">
                    <span class="text-xs text-slate-500">{{ $materials->total() }} material</span>
                </div>
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
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Status</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        @forelse($materials as $material)
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5 text-xs font-headline font-bold text-primary">{{ $material->material_code }}</td>
                            <td class="px-8 py-5">
                                <div class="text-xs font-bold text-on-surface">{{ $material->material_name }}</div>
                                <div class="text-[10px] text-slate-400">{{ $material->spec ?? '-' }}</div>
                            </td>
                            <td class="px-8 py-5 text-xs text-on-surface-variant">{{ $material->category->name ?? '-' }}</td>
                            <td class="px-8 py-5 text-xs text-on-surface-variant">{{ $material->unit }}</td>
                            <td class="px-8 py-5 text-xs font-black {{ $material->current_stock < $material->minimum_stock ? 'text-error' : 'text-primary' }}">{{ number_format($material->current_stock) }}</td>
                            <td class="px-8 py-5 text-xs text-on-surface">{{ number_format($material->minimum_stock) }}</td>
                            <td class="px-8 py-5">
                                @php
                                    $stockRatio = $material->minimum_stock > 0 ? ($material->current_stock / $material->minimum_stock) * 100 : 0;
                                @endphp
                                @if($stockRatio < 30)
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold text-error uppercase tracking-tighter">Critical</span>
                                @elseif($stockRatio < 60)
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold text-tertiary uppercase tracking-tighter">Replenish</span>
                                @else
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold text-primary uppercase tracking-tighter">Healthy</span>
                                @endif
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="document.getElementById('editItem{{ $material->id }}').showModal()" class="p-2 rounded-lg bg-surface-container-high hover:bg-primary/10 text-slate-500 hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-sm" data-icon="edit">edit</span>
                                    </button>
                                    <button onclick="document.getElementById('deleteItem{{ $material->id }}').showModal()" class="p-2 rounded-lg bg-surface-container-high hover:bg-error/10 text-slate-500 hover:text-error transition-colors">
                                        <span class="material-symbols-outlined text-sm" data-icon="delete">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-8 py-12 text-center text-slate-400">Tidak ada data material.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($materials->hasPages())
            <div class="px-8 py-4 flex items-center justify-between bg-surface-container-low/30">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-widest">Showing {{ $materials->firstItem() }}-{{ $materials->lastItem() }} of {{ $materials->total() }} entries</p>
                <div class="flex items-center gap-1">
                    {{ $materials->links() }}
                </div>
            </div>
            @endif
        </section>
    </div>

    <!-- Create Item Modal -->
    <dialog id="itemModal" class="modal p-6 rounded-xl backdrop:bg-black/50 w-full max-w-2xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-headline text-lg font-bold text-on-surface">Tambah Material Baru</h3>
            <button onclick="document.getElementById('itemModal').close()" class="p-1 hover:bg-surface-container-low rounded-lg">
                <span class="material-symbols-outlined text-slate-500" data-icon="close">close</span>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.items.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Kode Material</label>
                    <input type="text" name="material_code" required placeholder="SKU-PW-XXXX" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Nama Material</label>
                    <input type="text" name="material_name" required class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Spesifikasi</label>
                <input type="text" name="spec" placeholder="Deskripsi spesifikasi material" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Kategori</label>
                    <select name="category_id" required class="w-full appearance-none bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Supplier</label>
                    <select name="supplier_id" required class="w-full appearance-none bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                        <option value="">Pilih Supplier</option>
                        @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Unit</label>
                    <input type="text" name="unit" required placeholder="pcs, kg, liter..." class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Harga per Unit</label>
                    <input type="number" name="unit_price" required min="0" step="0.01" placeholder="0" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Stok Saat Ini</label>
                    <input type="number" name="current_stock" required min="0" value="0" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Minimum Stok</label>
                    <input type="number" name="minimum_stock" required min="0" value="0" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Catatan</label>
                <textarea name="remarks" rows="2" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active_item" checked class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                <label for="is_active_item" class="text-sm text-on-surface">Aktifkan material</label>
            </div>
            <div class="flex gap-2 pt-4">
                <button type="button" onclick="document.getElementById('itemModal').close()" class="flex-1 px-4 py-2 bg-surface-container-low text-on-surface rounded-lg text-sm font-medium hover:bg-surface-container-high transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-primary/90 transition-colors">Simpan</button>
            </div>
        </form>
    </dialog>

    <!-- Edit & Delete Modals for each material -->
    @foreach($materials as $material)
    <dialog id="editItem{{ $material->id }}" class="modal p-6 rounded-xl backdrop:bg-black/50 w-full max-w-2xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-headline text-lg font-bold text-on-surface">Edit Material</h3>
            <button onclick="document.getElementById('editItem{{ $material->id }}').close()" class="p-1 hover:bg-surface-container-low rounded-lg">
                <span class="material-symbols-outlined text-slate-500" data-icon="close">close</span>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.items.update', $material->id) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Kode Material</label>
                    <input type="text" value="{{ $material->material_code }}" disabled class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm text-slate-400">
                    <input type="hidden" name="material_code" value="{{ $material->material_code }}">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Nama Material</label>
                    <input type="text" name="material_name" value="{{ $material->material_name }}" required class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Spesifikasi</label>
                <input type="text" name="spec" value="{{ $material->spec }}" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Kategori</label>
                    <select name="category_id" required class="w-full appearance-none bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $material->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Supplier</label>
                    <select name="supplier_id" required class="w-full appearance-none bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                        @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}" {{ $material->supplier_id == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Unit</label>
                    <input type="text" name="unit" value="{{ $material->unit }}" required class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Harga per Unit</label>
                    <input type="number" name="unit_price" value="{{ $material->unit_price }}" required min="0" step="0.01" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Stok Saat Ini</label>
                    <input type="number" name="current_stock" value="{{ $material->current_stock }}" required min="0" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Minimum Stok</label>
                    <input type="number" name="minimum_stock" value="{{ $material->minimum_stock }}" required min="0" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Catatan</label>
                <textarea name="remarks" rows="2" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">{{ $material->remarks }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active{{ $material->id }}" {{ $material->is_active ? 'checked' : '' }} class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                <label for="is_active{{ $material->id }}" class="text-sm text-on-surface">Aktifkan material</label>
            </div>
            <div class="flex gap-2 pt-4">
                <button type="button" onclick="document.getElementById('editItem{{ $material->id }}').close()" class="flex-1 px-4 py-2 bg-surface-container-low text-on-surface rounded-lg text-sm font-medium hover:bg-surface-container-high transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-primary/90 transition-colors">Simpan</button>
            </div>
        </form>
    </dialog>

    <dialog id="deleteItem{{ $material->id }}" class="modal p-6 rounded-xl backdrop:bg-black/50 w-full max-w-sm">
        <div class="text-center">
            <span class="material-symbols-outlined text-error text-5xl mb-4" data-icon="warning">warning</span>
            <h3 class="font-headline text-lg font-bold text-on-surface mb-2">Hapus Material?</h3>
            <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus material <strong>{{ $material->material_name }}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('deleteItem{{ $material->id }}').close()" class="flex-1 px-4 py-2 bg-surface-container-low text-on-surface rounded-lg text-sm font-medium hover:bg-surface-container-high transition-colors">Batal</button>
                <form method="POST" action="{{ route('admin.items.destroy', $material->id) }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-error text-white rounded-lg text-sm font-bold hover:bg-error/90 transition-colors">Hapus</button>
                </form>
            </div>
        </div>
    </dialog>
    @endforeach
</x-dashboard-layout>