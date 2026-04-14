<x-dashboard-layout>
    @php
        $activeNow = \App\Models\User::where('is_active', true)->count();
    @endphp
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Manajemen User</h2>
                <p class="text-xs text-slate-500 font-medium">Kelola seluruh pengguna sistem</p>
            </div>
            <button onclick="document.getElementById('userModal').showModal()" class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-sm" data-icon="person_add">person_add</span>
                Tambah User
            </button>
        </div>

        <!-- Summary Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Pengguna</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-primary">{{ $users->total() }}</span>
                        <span class="text-[11px] font-bold text-primary/60">User</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="people">people</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-primary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="trending_up">trending_up</span>
                    ALL TIME
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">User Aktif</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-green-600">{{ $totalActive }}</span>
                        <span class="text-[11px] font-bold text-green-600/60">User</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="check_circle">check_circle</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-green-600 font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="verified">verified</span>
                    {{ $users->total() > 0 ? round($totalActive / $users->total() * 100) : 0 }}% ACTIVE
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">User Terdaftar</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-on-surface">{{ $totalActive }}</span>
                        <span class="text-[11px] font-bold text-slate-400">User</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="login">login</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="devices">devices</span>
                    ALL REGISTERED
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <form method="GET" action="{{ route('admin.users') }}">
            <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Cari</label>
                    <input type="text" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}" class="bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary">
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-3">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Role</label>
                    <div class="relative">
                        <select name="role" class="w-full appearance-none bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:ring-0 focus:border-primary cursor-pointer pr-10">
                            <option value="all">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="staff_gudang" {{ request('role') == 'staff_gudang' ? 'selected' : '' }}>Staff Gudang</option>
                            <option value="staff_logistik" {{ request('role') == 'staff_logistik' ? 'selected' : '' }}>Staff Logistik</option>
                        </select>
                    </div>
                </div>
                <div class="p-5 bg-surface-container-low rounded-2xl flex flex-col gap-2 justify-end">
                    <button type="submit" class="bg-primary text-white px-6 py-1 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all flex items-center gap-2 justify-center w-full">
                        <span class="material-symbols-outlined text-sm">filter_list</span>
                        Filter
                    </button>
                    <a href="{{ route('admin.users') }}" class="bg-error text-white px-6 py-[6px] rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-error/90 transition-all flex items-center gap-2 justify-center w-full">
                        Clear
                    </a>                    
                </div>
            </section>
        </form>

        <!-- Table Section -->
        <section class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
            <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center">
                <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Daftar Pengguna</h2>
                <div class="flex gap-2">
                    <span class="text-xs text-slate-500">{{ $users->total() }} user</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low/50">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Nama & Email</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Role</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Status Aktif</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Terakhir Login</th>
                            <th class="px-8 py-4 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-low">
                        @forelse($users as $user)
                        <tr class="hover:bg-surface-bright transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                    <div>
                                        <div class="text-xs font-bold text-on-surface">{{ $user->name }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                @php
                                    $roleColors = [
                                        'admin' => 'text-primary',
                                        'manager' => 'text-tertiary',
                                        'staff_gudang' => 'text-secondary',
                                        'staff_logistik' => 'text-blue-500'
                                    ];
                                    $roleLabels = [
                                        'admin' => 'Admin',
                                        'manager' => 'Manager',
                                        'staff_gudang' => 'Staff Gudang',
                                        'staff_logistik' => 'Staff Logistik'
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $roleColors[$user->role] ?? 'bg-slate-500' }}  uppercase tracking-tighter">{{ $roleLabels[$user->role] ?? $user->role }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="flex items-center gap-1 text-[10px] font-bold {{ $user->is_active ? 'text-green-600' : 'text-error' }}">
                                    <span class="w-2 h-2 rounded-full {{ $user->is_active ? 'bg-green-600' : 'bg-error' }}"></span>
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-xs text-on-surface-variant">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : '-' }}
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="document.getElementById('editUser{{ $user->id }}').showModal()" class="p-2 rounded-lg bg-surface-container-high hover:bg-primary/10 text-slate-500 hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-sm" data-icon="edit">edit</span>
                                    </button>
                                    @if($user->id !== auth()->id())
                                    <button onclick="document.getElementById('deleteUser{{ $user->id }}').showModal()" class="p-2 rounded-lg bg-surface-container-high hover:bg-error/10 text-slate-500 hover:text-error transition-colors">
                                        <span class="material-symbols-outlined text-sm" data-icon="delete">delete</span>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-slate-400">Tidak ada data user.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
            <div class="px-8 py-4 flex items-center justify-between bg-surface-container-low/30">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-widest">Showing {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }} entries</p>
                <div class="flex items-center gap-1">
                    {{ $users->links() }}
                </div>
            </div>
            @endif
        </section>
    </div>

    <!-- Create User Modal -->
    <dialog id="userModal" class="modal p-6 rounded-xl backdrop:bg-black/50 w-full max-w-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-headline text-lg font-bold text-on-surface">Tambah User Baru</h3>
            <button onclick="document.getElementById('userModal').close()" class="p-1 hover:bg-surface-container-low rounded-lg">
                <span class="material-symbols-outlined text-slate-500" data-icon="close">close</span>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Email</label>
                <input type="email" name="email" required class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Password</label>
                <input type="password" name="password" required minlength="8" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required minlength="8" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Role</label>
                <select name="role" required class="w-full appearance-none bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="staff_gudang">Staff Gudang</option>
                    <option value="staff_logistik">Staff Logistik</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" checked class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                <label for="is_active" class="text-sm text-on-surface">Aktifkan user</label>
            </div>
            <div class="flex gap-2 pt-4">
                <button type="button" onclick="document.getElementById('userModal').close()" class="flex-1 px-4 py-2 bg-surface-container-low text-on-surface rounded-lg text-sm font-medium hover:bg-surface-container-high transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-primary/90 transition-colors">Simpan</button>
            </div>
        </form>
    </dialog>

    <!-- Edit & Delete Modals for each user -->
    @foreach($users as $user)
    <dialog id="editUser{{ $user->id }}" class="modal p-6 rounded-xl backdrop:bg-black/50 w-full max-w-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-headline text-lg font-bold text-on-surface">Edit User</h3>
            <button onclick="document.getElementById('editUser{{ $user->id }}').close()" class="p-1 hover:bg-surface-container-low rounded-lg">
                <span class="material-symbols-outlined text-slate-500" data-icon="close">close</span>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ $user->name }}" required class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Email</label>
                <input type="email" value="{{ $user->email }}" disabled class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm text-slate-400">
                <input type="hidden" name="email" value="{{ $user->email }}">
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Password (kosongkan jika tidak ubah)</label>
                <input type="password" name="password" minlength="8" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Role</label>
                <select name="role" required class="w-full appearance-none bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="staff_gudang" {{ $user->role == 'staff_gudang' ? 'selected' : '' }}>Staff Gudang</option>
                    <option value="staff_logistik" {{ $user->role == 'staff_logistik' ? 'selected' : '' }}>Staff Logistik</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active{{ $user->id }}" {{ $user->is_active ? 'checked' : '' }} class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary">
                <label for="is_active{{ $user->id }}" class="text-sm text-on-surface">Aktifkan user</label>
            </div>
            <div class="flex gap-2 pt-4">
                <button type="button" onclick="document.getElementById('editUser{{ $user->id }}').close()" class="flex-1 px-4 py-2 bg-surface-container-low text-on-surface rounded-lg text-sm font-medium hover:bg-surface-container-high transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-primary/90 transition-colors">Simpan</button>
            </div>
        </form>
    </dialog>

    <dialog id="deleteUser{{ $user->id }}" class="modal p-6 rounded-xl backdrop:bg-black/50 w-full max-w-sm">
        <div class="text-center">
            <span class="material-symbols-outlined text-error text-5xl mb-4" data-icon="warning">warning</span>
            <h3 class="font-headline text-lg font-bold text-on-surface mb-2">Hapus User?</h3>
            <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus user <strong>{{ $user->name }}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('deleteUser{{ $user->id }}').close()" class="flex-1 px-4 py-2 bg-surface-container-low text-on-surface rounded-lg text-sm font-medium hover:bg-surface-container-high transition-colors">Batal</button>
                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-error text-white rounded-lg text-sm font-bold hover:bg-error/90 transition-colors">Hapus</button>
                </form>
            </div>
        </div>
    </dialog>
    @endforeach
</x-dashboard-layout>