<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Buat Purchase Order</h2>
                <p class="text-xs text-slate-500 font-medium">Pengajuan pengadaan material</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-error-container text-on-error-container px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Pending PO</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-tertiary">{{ $pendingCount }}</span>
                        <span class="text-[11px] font-bold text-tertiary/60">PO</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="pending_actions">pending_actions</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-tertiary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="schedule">schedule</span>
                    MENUNGGU APPROVAL
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Approved PO</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-green-600">{{ $approvedCount }}</span>
                        <span class="text-[11px] font-bold text-green-600/60">PO</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="check_circle">check_circle</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-green-600 font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="verified">verified</span>
                    DISETUJUI
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Rejected PO</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-error">{{ $rejectedCount }}</span>
                        <span class="text-[11px] font-bold text-error/60">PO</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="cancel">cancel</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-error font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="cancel">cancel</span>
                    DITOLAK
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Form Section -->
            <div class="col-span-12 lg:col-span-8 bg-surface-container-lowest rounded-2xl p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-primary/10 rounded-lg text-primary">
                        <span class="material-symbols-outlined" data-icon="shopping_cart">shopping_cart</span>
                    </div>
                    <h2 class="font-headline text-lg font-extrabold text-on-surface">Formulir Purchase Order</h2>
                </div>
                <form action="{{ route('logistik.po.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-[10px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500">Supplier</label>
                        <div class="relative">
                            <select name="supplier_id" required class="w-full appearance-none bg-surface-container-low border border-outline-variant rounded-lg px-4 py-3 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                                <option value="">Pilih Supplier...</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('supplier_id') <p class="text-xs text-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <label class="text-[10px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500">Item</label>
                            <button type="button" id="add-item-btn" class="text-xs text-primary font-bold hover:underline flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">add</span> Tambah Item
                            </button>
                        </div>
                        
                        <div id="items-container" class="space-y-4">
                            <!-- Dynamic items will be added here -->
                        </div>
                        
                        @error('items') <p class="text-xs text-error">{{ $message }}</p> @enderror
                        @error('items.*.material_id') <p class="text-xs text-error">{{ $message }}</p> @enderror
                        @error('items.*.quantity') <p class="text-xs text-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500">Estimated Delivery</label>
                            <input name="delivery_date" type="date" required min="{{ date('Y-m-d') }}" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-3 text-sm focus:ring-0 focus:border-primary">
                            @error('delivery_date') <p class="text-xs text-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500">Priority</label>
                            <div class="relative">
                                <select name="priority" class="w-full appearance-none bg-surface-container-low border border-outline-variant rounded-lg px-4 py-3 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                                    <option value="low">Low</option>
                                    <option value="normal" selected>Normal</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500">Keterangan / Catatan</label>
                        <textarea name="notes" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-3 text-sm focus:ring-0 focus:border-primary resize-none" placeholder="Catatan tambahan untuk PO ini..." rows="3"></textarea>
                    </div>

                    <button class="w-full bg-primary text-white py-3 rounded-lg text-sm font-bold uppercase tracking-widest hover:bg-primary/90 transition-all flex items-center justify-center gap-2 mt-4" type="submit">
                        <span class="material-symbols-outlined text-sm">save</span>
                        Simpan Purchase Order
                    </button>
                </form>
            </div>

            <!-- Sidebar - Low Stock Items -->
            <div class="col-span-12 lg:col-span-4 space-y-6">
                <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                    <div class="flex flex-col">
                        <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Live Inventory Alert</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-headline font-black text-error">{{ \App\Models\Material::whereColumn('current_stock', '<', 'minimum_stock')->where('is_active', true)->count() }}</span>
                            <span class="text-[11px] font-bold text-error/60">ITEMS</span>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <span class="material-symbols-outlined text-8xl" data-icon="warning">warning</span>
                    </div>
                    <div class="mt-4 flex items-center text-[10px] text-error font-bold">
                        <span class="material-symbols-outlined text-xs mr-1" data-icon="error">error</span>
                        NEEDS RESTOCK
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-surface-container-low">
                        <h4 class="text-[11px] font-bold uppercase tracking-widest text-slate-500">Recent PO Activity</h4>
                    </div>
                    <div class="divide-y divide-surface-container-low">
                        @forelse($recentPO as $po)
                            <div class="p-4 hover:bg-surface-container-low transition-colors">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-[10px] font-bold {{ $po->status == 'approved' ? 'text-green-600' : ($po->status == 'rejected' ? 'text-error' : 'text-tertiary') }} uppercase">{{ $po->status }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $po->created_at->format('d M') }}</span>
                                </div>
                                <p class="text-xs font-bold text-on-surface">{{ $po->po_number }}</p>
                                <p class="text-[10px] text-slate-400">Rp {{ number_format($po->total_amount, 0, ',', '.') }}</p>
                            </div>
                        @empty
                            <div class="p-4 text-center text-slate-400 text-sm">No recent PO</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- PO List -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Daftar Purchase Order</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low/50">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">No. PO</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Supplier</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em] text-right">Total</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Tanggal</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Priority</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        @forelse($purchaseOrders as $po)
                            <tr class="hover:bg-surface-bright transition-colors group">
                                <td class="px-8 py-5 text-sm font-bold text-primary">{{ $po->po_number }}</td>
                                <td class="px-8 py-5 text-sm text-on-surface">{{ $po->supplier->name ?? '-' }}</td>
                                <td class="px-8 py-5 text-sm font-medium text-right">Rp {{ number_format($po->total_amount, 0, ',', '.') }}</td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant">{{ $po->order_date->format('d M Y') }}</td>
                                <td class="px-8 py-5">
                                    <span class="text-[10px] font-bold px-2 py-1 rounded uppercase
                                        {{ $po->priority == 'urgent' ? 'text-error' : 
                                           ($po->priority == 'high' ? 'text-tertiary' : 
                                           ($po->priority == 'low' ? 'text-slate-200' : 'text-primary')) }}">
                                        {{ $po->priority }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-[10px] font-bold px-2 py-1 rounded uppercase
                                        {{ $po->status == 'approved' ? 'text-green-700' : 
                                           ($po->status == 'rejected' ? 'text-error' : 'text-tertiary') }}">
                                        {{ $po->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-12 text-center text-slate-400 text-sm">
                                    No purchase orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($purchaseOrders->hasPages())
                <div class="px-8 py-4 bg-surface-container-low/30">
                    {{ $purchaseOrders->links() }}
                </div>
            @endif
        </section>
    </div>

    <script>
        var materials = <?php echo json_encode($materials); ?>;
        
        function createItemRow(index) {
            var options = '<option value="">Pilih Material...</option>';
            materials.forEach(function(m) {
                options += '<option value="' + m.id + '" data-unit="' + m.unit + '" data-price="' + m.unit_price + '">' + m.material_code + ' - ' + m.material_name + '</option>';
            });
            
            return '<div class="item-row bg-surface-container-low p-4 rounded-lg">' +
                '<div class="flex justify-between items-start mb-3">' +
                '<span class="text-[10px] font-bold text-slate-500 uppercase">Item #' + (index + 1) + '</span>' +
                '<button type="button" onclick="this.closest(\'.item-row\').remove()" class="text-error hover:text-error/80">' +
                '<span class="material-symbols-outlined text-sm">close</span>' +
                '</button>' +
                '</div>' +
                '<div class="grid grid-cols-1 md:grid-cols-3 gap-3">' +
                '<select name="items[' + index + '][material_id]" required class="material-select bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary">' +
                options +
                '</select>' +
                '<input type="number" name="items[' + index + '][quantity]" required min="1" placeholder="Qty" class="bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary">' +
                '<input type="number" name="items[' + index + '][unit_price]" required min="0" step="0.01" placeholder="Unit Price (Rp)" class="bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary">' +
                '</div>' +
                '</div>';
        }

        document.addEventListener('DOMContentLoaded', function() {
            var container = document.getElementById('items-container');
            var addBtn = document.getElementById('add-item-btn');
            var itemCount = 0;

            container.innerHTML = createItemRow(itemCount);
            itemCount++;

            addBtn.addEventListener('click', function() {
                container.insertAdjacentHTML('beforeend', createItemRow(itemCount));
                itemCount++;
            });
        });
    </script>
</x-dashboard-layout>
