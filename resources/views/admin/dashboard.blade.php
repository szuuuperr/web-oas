<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Dashboard Admin</h2>
                <p class="text-xs text-slate-500 font-medium">Kelola seluruh sistem</p>
            </div>
        </div>
        <!-- Summary Statistics: Bento Grid Style -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total
                        Users</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-primary">{{ $totalUsers }}</span>
                        <span class="text-[11px] font-bold text-primary/60">Users</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="people">people</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-primary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="check_circle">check_circle</span>
                    {{ $totalActive }} ACTIVE
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Users
                        by Role</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-on-surface">{{ $totalUsers }}</span>
                        <span class="text-[11px] font-bold text-slate-400">Total</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="group_work">group_work</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-500 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="person">person</span>
                    Admin, Manager, Staff
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span
                        class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Recent
                        Activity</span>
                    <div class="flex items-baseline gap-2">
                        <span
                            class="text-4xl font-headline font-black text-on-surface">{{ $recentActivity->count() }}</span>
                        <span class="text-[11px] font-bold text-slate-400">Logs</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="history">history</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-500 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="update">update</span>
                    TODAY'S ACTIVITY
                </div>
            </div>
        </section>
        <!-- Main Layout: Table and Widgets -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Recent System Activity Logs -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-xl font-bold font-headline tracking-tight text-on-surface">System Activity Logs</h3>
                    <a href="{{ route('admin.logs') }}" class="text-primary text-sm font-semibold hover:underline">View
                        All Logs</a>
                </div>
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                        <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Recent Activity</h2>
                        <div class="flex gap-2">
                            <span class="text-xs text-slate-500">{{ $recentActivity->count() }} activities</span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-surface-container-low/50">
                                <tr>
                                    <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Timestamp</th>
                                    <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Module</th>
                                    <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Action</th>
                                    <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em] text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-container-low">
                                @forelse($recentActivity as $activity)
                                    <tr class="hover:bg-surface-bright transition-colors group">
                                        <td class="px-8 py-5 font-mono text-xs text-on-surface-variant">{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td class="px-8 py-5"><span class="text-xs font-bold text-primary">{{ ucfirst($activity->module) }}</span></td>
                                        <td class="px-8 py-5 text-xs text-on-surface">{{ $activity->description }}</td>
                                        <td class="px-8 py-5 text-center">
                                            @php
                                                $actionColors = [
                                                    'create' => 'text-primary',
                                                    'update' => 'text-tertiary',
                                                    'delete' => 'text-error',
                                                    'approve' => 'text-green-600',
                                                    'reject' => 'text-red-600',
                                                ];
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $actionColors[$activity->action] ?? 'bg-slate-100 text-slate-700' }}">
                                                {{ $activity->action }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-12 text-center text-slate-400">Tidak ada aktivitas terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Shortcuts and Recently Added Users -->
            <aside class="space-y-8">
                <!-- Quick Shortcuts -->
                <div class="bg-surface-container-highest p-6 rounded-xl space-y-4">
                    <h3 class="text-sm font-bold font-headline uppercase tracking-widest text-on-surface-variant/80">
                        Quick Actions</h3>
                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('admin.users') }}"
                            class="flex items-center gap-3 w-full p-4 bg-primary text-white rounded-lg shadow-md hover:scale-[0.98] transition-transform">
                            <span class="material-symbols-outlined" data-icon="person_add">person_add</span>
                            <span class="font-semibold text-sm">User Management</span>
                        </a>
                        <a href="{{ route('admin.items') }}"
                            class="flex items-center gap-3 w-full p-4 bg-white text-primary border border-primary/20 rounded-lg shadow-sm hover:bg-primary/5 transition-colors">
                            <span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
                            <span class="font-semibold text-sm">Master Data Material</span>
                        </a>
                        <a href="{{ route('admin.logs') }}"
                            class="flex items-center gap-3 w-full p-4 bg-white text-secondary border border-outline-variant rounded-lg shadow-sm hover:bg-slate-50 transition-colors">
                            <span class="material-symbols-outlined" data-icon="history">history</span>
                            <span class="font-semibold text-sm">Activity Logs</span>
                        </a>
                    </div>
                </div>
                <!-- Users by Role -->
                <div class="bg-white p-6 rounded-xl border border-outline-variant/10 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold font-headline uppercase tracking-widest text-on-surface-variant/80">
                        Users by Role</h3>
                    <div class="space-y-3">
                        @foreach($usersByRole as $role => $count)
                            <div
                                class="flex items-center justify-between p-2 hover:bg-surface-container-low rounded-lg transition-colors">
                                <span
                                    class="text-sm font-medium text-on-surface capitalize">{{ str_replace('_', ' ', $role) }}</span>
                                <span class="text-sm font-bold text-primary">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-dashboard-layout>