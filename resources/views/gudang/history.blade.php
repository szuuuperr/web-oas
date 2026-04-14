<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Riwayat Transaksi Gudang</h2>
                <p class="text-xs text-slate-500 font-medium">Histori pergerakan stok masuk dan keluar</p>
            </div>
        </div>

        <!-- Summary Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total
                        Transaksi</span>
                    <div class="flex items-baseline gap-2">
                        <span
                            class="text-4xl font-headline font-black text-primary">{{ number_format($totalTransactions) }}</span>
                        <span class="text-[11px] font-bold text-primary/60">Transaksi</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="receipt_long">receipt_long</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total
                        Barang Masuk</span>
                    <div class="flex items-baseline gap-2">
                        <span
                            class="text-4xl font-headline font-black text-primary">{{ number_format($totalIn) }}</span>
                        <span class="text-[11px] font-bold text-primary/60">Unit</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="arrow_downward">arrow_downward</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="check_circle">check_circle</span>
                    INBOUND FLOW
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total
                        Barang Keluar</span>
                    <div class="flex items-baseline gap-2">
                        <span
                            class="text-4xl font-headline font-black text-on-surface">{{ number_format($totalOut) }}</span>
                        <span class="text-[11px] font-bold text-slate-400">Unit</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="arrow_upward">arrow_upward</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="schedule">schedule</span>
                    OUTBOUND FLOW
                </div>
            </div>
        </section>

        <!-- Advanced Filter Section -->
        <form method="GET" action="{{ route('gudang.history') }}">
            <section class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="md:col-span-2 p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Date Range</label>
                    <div class="flex items-center gap-3">
                        <div
                            class="flex-1 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-sm"
                                data-icon="calendar_today">calendar_today</span>
                            <input name="date_from" class="bg-transparent border-none p-0 text-sm focus:ring-0 w-full"
                                type="date" value="{{ request('date_from') }}" />
                        </div>
                        <span class="text-slate-400 text-xs font-bold">TO</span>
                        <div
                            class="flex-1 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-sm"
                                data-icon="calendar_today">calendar_today</span>
                            <input name="date_to" class="bg-transparent border-none p-0 text-sm focus:ring-0 w-full"
                                type="date" value="{{ request('date_to') }}" />
                        </div>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Tipe Transaksi</label>
                    <div class="relative">
                        <select name="type"
                            class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="">Semua Tipe</option>
                            <option value="in" {{ request('type') === 'in' ? 'selected' : '' }}>Barang Masuk</option>
                            <option value="out" {{ request('type') === 'out' ? 'selected' : '' }}>Barang Keluar</option>
                        </select>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Material</label>
                    <div class="relative">
                        <select name="material_id"
                            class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="">Semua Material</option>
                            @foreach($materials as $mat)
                                <option value="{{ $mat->id }}" {{ request('material_id') == $mat->id ? 'selected' : '' }}>
                                    {{ $mat->material_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3 justify-end">
                    <button type="submit"
                        class="bg-primary text-white px-6 py-1 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all flex items-center gap-2 justify-center">
                        <span class="material-symbols-outlined text-sm">filter_list</span>
                        Filter
                    </button>
                    <a href="{{ route('gudang.history') }}"
                        class="bg-error text-white px-6 py-[5px] rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-error/90 transition-all flex items-center gap-2 justify-center">
                        Clear
                    </a>
                </div>
            </section>
        </form>
        <!-- Table Section -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Riwayat Transaksi Gudang</h2>
                <p class="text-xs text-slate-400">Menampilkan
                    {{ $transactions->firstItem() ?? 0 }}–{{ $transactions->lastItem() ?? 0 }} dari
                    {{ number_format($transactions->total()) }} data
                </p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low/50">
                        <tr>
                            <th
                                class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">
                                ID Transaksi</th>
                            <th
                                class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">
                                Tanggal</th>
                            <th
                                class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">
                                Tipe</th>
                            <th
                                class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">
                                Nama Material</th>
                            <th
                                class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">
                                Jumlah</th>
                            <th
                                class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">
                                Keterangan</th>
                            <th
                                class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">
                                Operator</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        @forelse($transactions as $tx)
                            <tr class="hover:bg-surface-bright transition-colors group">
                                <td class="px-8 py-5 text-xs font-headline font-bold text-primary">
                                    #{{ $tx->transaction_code }}</td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-xs font-bold text-on-surface">{{ $tx->transaction_date->format('M d, Y') }}</span>
                                        <span
                                            class="text-[11px] text-slate-400 font-medium">{{ $tx->created_at->format('H:i') }}
                                            WIB</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    @if($tx->type === 'in')
                                        <span class="flex items-center text-[10px] font-bold text-primary uppercase">
                                            <span class="material-symbols-outlined text-xs"
                                                data-icon="arrow_downward">arrow_downward</span>
                                            Masuk
                                        </span>
                                    @else
                                        <span class="flex items-center text-[10px] font-bold text-error uppercase">
                                            <span class="material-symbols-outlined text-xs"
                                                data-icon="arrow_upward">arrow_upward</span>
                                            Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-xs font-bold text-on-surface">{{ $tx->material->material_name }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $tx->material->material_code }}
                                        {{ $tx->batch_number ? '• Batch ' . $tx->batch_number : '' }}
                                    </div>
                                </td>
                                <td
                                    class="px-8 py-5 text-xs font-bold {{ $tx->type === 'in' ? 'text-primary' : 'text-error' }}">
                                    {{ $tx->type === 'in' ? '+' : '-' }}{{ number_format($tx->quantity) }}
                                    {{ ucfirst($tx->material->unit) }}
                                </td>
                                <td class="px-8 py-5 text-xs text-on-surface-variant">{{ $tx->notes ?? '-' }}</td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center">
                                            <span
                                                class="text-[9px] font-bold text-primary">{{ substr($tx->user->name, 0, 1) }}</span>
                                        </div>
                                        <span class="text-xs font-semibold text-on-surface">{{ $tx->user->name }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-8 py-12 text-center text-slate-400 text-sm">
                                    Tidak ada transaksi ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            @if($transactions->hasPages())
                <div class="px-6 py-4 bg-surface-container-low/20">
                    {{ $transactions->links() }}
                </div>
            @endif
        </section>
    </div>
</x-dashboard-layout>