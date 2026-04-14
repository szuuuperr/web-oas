<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Log Aktivitas Sistem</h2>
                <p class="text-xs text-slate-500 font-medium">Tracking every automated movement across PT. Parkland World Indonesia</p>
            </div>
        </div>

        <!-- Summary Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Logs</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-primary">{{ number_format($totalLogs) }}</span>
                        <span class="text-[11px] font-bold text-primary/60">Entries</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="history">history</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-primary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="trending_up">trending_up</span>
                    ALL TIME
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Active Users Today</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-on-surface">{{ $todayUsers }}</span>
                        <span class="text-[11px] font-bold text-slate-400">Users</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="people">people</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="check_circle">check_circle</span>
                    TODAY
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Modules Active</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-on-surface">{{ $modules->count() }}</span>
                        <span class="text-[11px] font-bold text-slate-400">Modules</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="event">event</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="schedule">schedule</span>
                    ALL TIME
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <form method="GET" action="{{ route('admin.logs') }}">
            <section class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="md:col-span-2 p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Date Range</label>
                    <div class="flex items-center gap-2">
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 flex items-center gap-2 flex-1 min-w-0">
                            <span class="material-symbols-outlined text-slate-400 text-sm shrink-0">calendar_today</span>
                            <input name="date_from" value="{{ request('date_from') }}" class="bg-transparent border-none p-0 text-sm focus:ring-0 w-full min-w-0" type="date">
                        </div>
                        <span class="text-slate-400 text-xs shrink-0">to</span>
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 flex items-center gap-2 flex-1 min-w-0">
                            <span class="material-symbols-outlined text-slate-400 text-sm shrink-0">calendar_today</span>
                            <input name="date_to" value="{{ request('date_to') }}" class="bg-transparent border-none p-0 text-sm focus:ring-0 w-full min-w-0" type="date">
                        </div>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">User</label>
                    <div class="relative">
                        <select name="user_id" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Module</label>
                    <div class="relative">
                        <select name="module" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="all">All Modules</option>
                            @foreach($modules as $mod)
                            <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>{{ $mod }}</option>
                            @endforeach
                        </select>                    
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-2 justify-end">
                    <button type="submit" class="bg-primary text-white px-6 py-1 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all flex items-center gap-2 justify-center w-full">
                        <span class="material-symbols-outlined text-sm">filter_list</span>
                        Filter
                    </button>
                    <a href="{{ route('admin.logs') }}" class="bg-error text-white px-6 py-[6px] rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-error/90 transition-all flex items-center gap-2 justify-center w-full">
                        Clear
                    </a>
                </div>
            </section>
        </form>

        <!-- Table Section -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">System Audit Logs</h2>
                <span class="text-xs text-slate-500">{{ $logs->total() }} entries</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low/50">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Timestamp</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">User</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Action</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Module</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Detailed Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        @forelse($logs as $log)
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-on-surface">{{ $log->created_at->format('M d, Y') }}</span>
                                    <span class="text-[11px] text-slate-400 font-medium">{{ $log->created_at->format('H:i:s') }} WIB</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white text-xs font-bold">{{ $log->user ? strtoupper(substr($log->user->name, 0, 1)) : '?' }}</div>
                                    <span class="text-sm font-semibold text-on-surface">{{ $log->user->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                @php
                                    $actionColors = [
                                        'create' => 'text-primary',
                                        'update' => 'text-tertiary',
                                        'delete' => 'text-error',
                                        'approve' => 'text-green-700',
                                        'reject' => 'text-red-700',
                                    ];
                                    $actionLabels = [
                                        'create' => 'Menambah',
                                        'update' => 'Edit',
                                        'delete' => 'Hapus',
                                        'approve' => 'Approve',
                                        'reject' => 'Reject',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-tight {{ $actionColors[$log->action] ?? 'bg-slate-100 text-slate-700' }}">{{ $actionLabels[$log->action] ?? ucfirst($log->action) }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-medium text-slate-600">{{ ucfirst($log->module) }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-sm text-on-surface-variant leading-relaxed">
                                    {{ $log->description }}
                                </p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-slate-400">Tidak ada log aktivitas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
            <div class="px-6 py-4 flex items-center justify-between bg-surface-container-low/20">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-widest">Showing {{ $logs->firstItem() }}-{{ $logs->lastItem() }} of {{ $logs->total() }} entries</p>
                <div class="flex items-center gap-1">
                    {{ $logs->links() }}
                </div>
            </div>
            @endif
        </section>
    </div>
</x-dashboard-layout>