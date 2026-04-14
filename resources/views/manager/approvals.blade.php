<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Page Header -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Persetujuan Purchase Order</h2>
                <p class="text-xs text-slate-500 font-medium">Review dan approve pengajuan pengadaan material</p>
            </div>
            <div class="flex items-center gap-3">
                <span
                    class="text-[10px] font-bold bg-error/20 text-error px-3 py-1.5 rounded-full uppercase tracking-wider">{{ $pendingCount }}
                    Pending</span>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div
                class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div
                class="bg-error-container text-on-error-container px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
                <span class="material-symbols-outlined">error</span>
                {{ session('error') }}
            </div>
        @endif
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Pending
                        Approvals</span>
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
                    NEEDS ATTENTION
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Approved</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-primary">{{ $approvedCount }}</span>
                        <span class="text-[11px] font-bold text-primary/60">PO</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="check_circle">check_circle</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-green-600 font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="trending_up">trending_up</span>
                    THIS MONTH
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Rejected</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-error">{{ $rejectedCount }}</span>
                        <span class="text-[11px] font-bold text-error/60">PO</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="cancel">cancel</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="remove_circle">remove_circle</span>
                    THIS MONTH
                </div>
            </div>
        </section>

        <!-- Filters -->
        <form method="GET" action="{{ route('manager.approvals') }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Cari PO</label>
                    <div class="flex items-center gap-3">
                        <div class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-sm" data-icon="search">search</span>
                            <input name="search" value="{{ request('search') }}" class="bg-transparent border-none p-0 text-sm focus:ring-0 w-full" placeholder="Cari No. PO..." type="text" />
                        </div>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Status</label>
                    <div class="relative">
                        <select name="status" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-2 justify-end">
                    <button type="submit" class="bg-primary text-white px-6 py-1 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all flex items-center gap-2 justify-center w-full">
                        <span class="material-symbols-outlined text-sm">filter_list</span>
                        Filter
                    </button>
                    <a href="{{ route('manager.approvals') }}" class="bg-error text-white px-6 py-[6px] rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-error/90 transition-all flex items-center gap-2 justify-center w-full">
                        Clear
                    </a>
                </div>
            </div>
        </form>

        <!-- PO List Table -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Daftar Purchase Order</h2>
                <div class="flex gap-2">
                    <button
                        class="p-1.5 rounded-lg bg-surface-container-low text-slate-500 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-sm" data-icon="filter_list">filter_list</span>
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">
                                No. PO</th>
                            <th
                                class="px-6 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">
                                Supplier</th>
                            <th
                                class="px-6 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">
                                Item</th>
                            <th
                                class="px-6 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em] text-right">
                                Qty</th>
                            <th
                                class="px-6 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em] text-right">
                                Total</th>
                            <th
                                class="px-6 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">
                                Request Date</th>
                            <th
                                class="px-6 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">
                                Status</th>
                            <th
                                class="px-6 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em] text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        @forelse($purchaseOrders as $po)
                                            <tr class="hover:bg-surface-bright transition-colors group">
                                                <td class="px-6 py-4">
                                                    <span class="text-sm font-bold text-primary">{{ $po->po_number }}</span>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-on-surface">{{ $po->supplier->name ?? '-' }}</td>
                                                <td class="px-6 py-4 text-sm text-on-surface">
                                                    {{ $po->purchaseOrderItems->first()->material->material_name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-right">
                                                    {{ number_format($po->purchaseOrderItems->sum('quantity')) }} unit
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-on-surface text-right">
                                                    Rp {{ number_format($po->total_amount, 0, ',', '.') }}
                                                </td>
<td class="px-6 py-4 text-sm text-on-surface-variant">
                                                    {{ $po->order_date->format('d M Y') }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="text-[10px] font-bold uppercase
                                                                                                {{ $po->status == 'approved' ? 'text-green-700' :
                            ($po->status == 'rejected' ? 'text-error' : 'text-tertiary') }}">
                                                        {{ $po->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <div class="flex items-center justify-center gap-2">
                                                        @if($po->status == 'pending')
                                                            <form action="{{ route('manager.approvals.approve', $po) }}" method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-lg transition-colors flex items-center gap-1"
                                                                    title="Approve">
                                                                    <span class="material-symbols-outlined text-sm">check</span>
                                                                    Approve
                                                                </button>
                                                            </form>
                                                            <button type="button"
                                                                onclick="showRejectModal('{{ $po->id }}', '{{ $po->po_number }}')"
                                                                class="px-3 py-1.5 bg-error hover:bg-error/90 text-white text-xs font-bold rounded-lg transition-colors flex items-center gap-1"
                                                                title="Reject">
                                                                <span class="material-symbols-outlined text-sm">close</span>
                                                                Reject
                                                            </button>
                                                        @else
                                                        <span class="text-[10px] font-bold uppercase {{ $po->status == 'approved' ? 'text-green-600' : 'text-error' }}">
                                                            {{ $po->status }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-8 py-8 text-center text-slate-500">
                                    No purchase orders found.
                                </td>
                            </tr>
                        @endforelse
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-8 py-6 bg-surface-container-low flex justify-between items-center">
                <span class="text-xs text-outline">Menampilkan
                    {{ $purchaseOrders->firstItem() }}-{{ $purchaseOrders->lastItem() }} dari
                    {{ $purchaseOrders->total() }} PO</span>
                {{ $purchaseOrders->links() }}
            </div>
        </section>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-bold mb-4">Tolak Purchase Order</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Alasan Penolakan</label>
                    <textarea name="rejection_reason" required class="w-full border rounded-lg px-3 py-2" rows="3"
                        placeholder="Masukkan alasan penolakan..."></textarea>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 bg-gray-200 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-error text-white rounded-lg">Tolak PO</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showRejectModal(poId, poNumber) {
            document.getElementById('rejectForm').action = '/manager/approvals/' + poId + '/reject';
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-dashboard-layout>