<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Input Stok Masuk</h2>
                <p class="text-xs text-slate-500 font-medium">Catat transaksi inbound material ke gudang</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Form Section -->
            <div class="col-span-12 lg:col-span-8 bg-surface-container-lowest rounded-2xl p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-primary/10 rounded-lg text-primary">
                        <span class="material-symbols-outlined" data-icon="add_box">add_box</span>
                    </div>
                    <h2 class="font-headline text-lg font-extrabold text-on-surface">Inbound Transaction</h2>
                </div>
                <form action="{{ route('gudang.stock-in.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label for="material_id" class="text-[10px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500">Material Name</label>
                        <div class="relative">
                            <select name="material_id" id="material_id" required class="w-full appearance-none bg-surface-container-low border border-outline-variant rounded-lg px-4 py-3 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                                <option value="">Pilih Material...</option>
                                @foreach($materials as $mat)
                                    <option value="{{ $mat->id }}" data-price="{{ $mat->unit_price }}" data-unit="{{ $mat->unit }}" data-stock="{{ $mat->current_stock }}" {{ old('material_id') == $mat->id ? 'selected' : '' }}>
                                        {{ $mat->material_code }} — {{ $mat->material_name }} (Stok: {{ number_format($mat->current_stock) }} {{ $mat->unit }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('material_id') <p class="text-xs text-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="quantity" class="text-[10px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500">Qty Order</label>
                            <input name="quantity" id="quantity" type="number" min="1" required class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-3 text-sm focus:ring-0 focus:border-primary font-bold text-primary" placeholder="0" value="{{ old('quantity') }}" />
                            @error('quantity') <p class="text-xs text-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label for="unit_price" class="text-[10px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500">Unit Price (Rp)</label>
                            <input name="unit_price" id="unit_price" type="number" min="0" step="0.01" required class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-3 text-sm focus:ring-0 focus:border-primary" placeholder="0" value="{{ old('unit_price') }}" />
                            @error('unit_price') <p class="text-xs text-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500">Total Amount (Rp)</label>
                        <input id="total_amount" class="w-full bg-surface-container-high border border-outline-variant rounded-lg px-4 py-3 text-sm text-on-surface" placeholder="0" type="text" readonly />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="transaction_date" class="text-[10px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500">Tanggal Masuk</label>
                            <input name="transaction_date" id="transaction_date" type="date" required class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-3 text-sm focus:ring-0 focus:border-primary" value="{{ old('transaction_date', date('Y-m-d')) }}" />
                            @error('transaction_date') <p class="text-xs text-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label for="batch_number" class="text-[10px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500">Batch Number</label>
                            <input name="batch_number" id="batch_number" type="text" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-3 text-sm focus:ring-0 focus:border-primary" placeholder="Opsional" value="{{ old('batch_number') }}" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="notes" class="text-[10px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500">Keterangan</label>
                        <input name="notes" id="notes" type="text" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-3 text-sm focus:ring-0 focus:border-primary" placeholder="Catatan tambahan (opsional)" value="{{ old('notes') }}" />
                    </div>

                    <button class="w-full bg-primary text-white py-3 rounded-lg text-sm font-bold uppercase tracking-widest hover:bg-primary/90 transition-all flex items-center justify-center gap-2 mt-4" type="submit">
                        <span class="material-symbols-outlined text-sm">save</span>
                        Simpan Transaksi
                    </button>
                </form>
            </div>

            <!-- Sidebar: Recent Activity -->
            <div class="col-span-12 lg:col-span-4 space-y-6">
                <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                    <div class="flex flex-col">
                        <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Statistik Hari Ini</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-headline font-black text-primary">{{ $recentIn->where('transaction_date', today())->sum('quantity') ?: 0 }}</span>
                            <span class="text-[11px] font-bold text-primary/60">Units</span>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <span class="material-symbols-outlined text-8xl" data-icon="arrow_downward">arrow_downward</span>
                    </div>
                    <div class="mt-4 flex items-center text-[10px] text-slate-500 font-medium">
                        <span class="material-symbols-outlined text-xs mr-1" data-icon="schedule">schedule</span>
                        {{ $recentIn->where('transaction_date', today())->count() }} TRANSAKSI HARI INI
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-surface-container-low">
                        <h4 class="text-[11px] font-bold uppercase tracking-widest text-slate-500">Recent Material Flow</h4>
                    </div>
                    <div class="divide-y divide-surface-container-low">
                        @foreach($recentIn as $tx)
                            <div class="p-4 hover:bg-surface-container-low transition-colors">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-[10px] font-bold text-primary uppercase">Inbound</span>
                                    <span class="text-[10px] text-slate-400">{{ $tx->transaction_date->format('d M') }}</span>
                                </div>
                                <p class="text-xs font-bold text-on-surface">{{ number_format($tx->quantity) }} {{ $tx->material->unit }} | {{ $tx->material->material_name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $tx->transaction_code }} &bull; {{ $tx->user->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const materialSelect = document.getElementById('material_id');
            const qtyInput = document.getElementById('quantity');
            const priceInput = document.getElementById('unit_price');
            const totalInput = document.getElementById('total_amount');

            function updateTotal() {
                const qty = parseFloat(qtyInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                totalInput.value = (qty * price).toLocaleString('id-ID');
            }

            materialSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                if (selected.value) {
                    priceInput.value = selected.dataset.price;
                    updateTotal();
                }
            });

            qtyInput.addEventListener('input', updateTotal);
            priceInput.addEventListener('input', updateTotal);
        });
    </script>
    @endpush
</x-dashboard-layout>
