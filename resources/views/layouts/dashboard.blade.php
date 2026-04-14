<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Dashboard | PWI Industrial OS</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "secondary-container": "#dfe0e0",
                        "secondary-fixed-dim": "#c6c6c7",
                        "on-secondary": "#ffffff",
                        "on-primary-fixed-variant": "#004a76",
                        "error-container": "#ffdad6",
                        "on-secondary-container": "#616363",
                        "on-primary-fixed": "#001d33",
                        "on-primary-container": "#f6f9ff",
                        "tertiary-fixed-dim": "#f8bc5c",
                        "surface-container-high": "#e5e8ee",
                        "on-tertiary-container": "#fff8f2",
                        "inverse-surface": "#2d3135",
                        "on-tertiary-fixed-variant": "#614000",
                        "on-secondary-fixed": "#1a1c1c",
                        "surface-variant": "#dfe3e8",
                        "on-surface-variant": "#41474f",
                        "primary": "#3477ac",
                        "on-surface": "#181c20",
                        "tertiary-fixed": "#ffddaf",
                        "surface-container-lowest": "#ffffff",
                        "surface-bright": "#f7f9ff",
                        "background": "#f7f9ff",
                        "secondary-fixed": "#e2e2e2",
                        "inverse-primary": "#96cbff",
                        "surface": "#f7f9ff",
                        "on-tertiary-fixed": "#281800",
                        "on-primary": "#ffffff",
                        "surface-container-low": "#f1f4fa",
                        "on-error": "#ffffff",
                        "secondary": "#5d5f5f",
                        "on-background": "#181c20",
                        "error": "#ba1a1a",
                        "surface-tint": "#176396",
                        "outline-variant": "#c1c7d0",
                        "outline": "#717880",
                        "on-error-container": "#93000a",
                        "inverse-on-surface": "#eef1f7",
                        "tertiary": "#7a5200",
                        "primary-container": "#3477ac",
                        "tertiary-container": "#99690a",
                        "surface-container-highest": "#dfe3e8",
                        "surface-dim": "#d7dae0",
                        "on-secondary-fixed-variant": "#454747",
                        "primary-fixed": "#cee5ff",
                        "surface-container": "#ebeef4",
                        "primary-fixed-dim": "#96cbff",
                        "on-tertiary": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="flex min-h-screen bg-surface">
    <!-- Sidebar Fixed -->
    <aside
        class="hidden md:flex flex-col w-64 bg-[#f1f4fa] border-r border-outline-variant/20 py-6 fixed top-0 left-0 h-screen overflow-y-auto">
        <div class="px-6 mb-8">
            <div class="flex justify-center">
                <img src="{{('/images/logo-parkland.svg')}}" alt="Parkland" class="w-16 mb-2" style="max-width: 140px;">
            </div>
            <div class="text-[12px] flex justify-center text-slate-800 font-medium capitalize">PT. Parkland World Indonesia</div>
            <div class="w-full h-[0.4px] opacity-10 bg-black mt-4"></div>
        </div>

        <nav class="flex-1 space-y-1">
            <!-- Dynamic Menu Based on Role -->
            @php
                $menuItems = [];

                if (Auth::user()->role === 'admin') {
                    $menuItems = [
                        ['icon' => 'dashboard', 'label' => 'Dashboard Admin', 'route' => 'admin.dashboard'],
                        ['icon' => 'manage_accounts', 'label' => 'Manajemen User', 'route' => 'admin.users'],
                        ['icon' => 'inventory_2', 'label' => 'Master Data Barang', 'route' => 'admin.items'],
                        ['icon' => 'history_edu', 'label' => 'Log Aktivitas', 'route' => 'admin.logs'],
                        ['icon' => 'settings', 'label' => 'Konfigurasi Sistem', 'route' => 'admin.settings'],
                    ];
                } elseif (Auth::user()->role === 'manager') {
                    $menuItems = [
                        ['icon' => 'dashboard', 'label' => 'Dashboard Eksekutif', 'route' => 'manager.dashboard'],
                        ['icon' => 'trending_up', 'label' => 'Prediksi Stok (SMA)', 'route' => 'manager.prediction'],
                        ['icon' => 'approval', 'label' => 'Persetujuan PO', 'route' => 'manager.approvals'],
                        ['icon' => 'file_download', 'label' => 'Ekspor Data Laporan', 'route' => 'manager.export'],
                    ];
                } elseif (Auth::user()->role === 'staff_gudang') {
                    $menuItems = [
                        ['icon' => 'dashboard', 'label' => 'Dashboard Gudang', 'route' => 'gudang.dashboard'],
                        ['icon' => 'arrow_downward', 'label' => 'Input Stok Masuk', 'route' => 'gudang.stock-in'],
                        ['icon' => 'arrow_upward', 'label' => 'Input Stok Keluar', 'route' => 'gudang.stock-out'],
                        ['icon' => 'inventory_2', 'label' => 'Data Barang', 'route' => 'gudang.items'],
                        ['icon' => 'history_edu', 'label' => 'Riwayat Transaksi', 'route' => 'gudang.history'],
                    ];
                } elseif (Auth::user()->role === 'staff_logistik') {
                    $menuItems = [
                        ['icon' => 'dashboard', 'label' => 'Dashboard Logistik', 'route' => 'logistik.dashboard'],
                        ['icon' => 'trending_up', 'label' => 'Prediksi Stok (SMA)', 'route' => 'logistik.prediction'],
                        ['icon' => 'notifications', 'label' => 'Notifikasi Stok Rendah', 'route' => 'logistik.alerts'],
                        ['icon' => 'shopping_cart', 'label' => 'Buat Purchase Order', 'route' => 'logistik.po'],
                    ];
                }
            @endphp

            @foreach($menuItems as $item)
                @php
                    $isActive = request()->routeIs($item['route']);
                @endphp
                <a class="flex items-center px-6 py-3 {{ $isActive ? 'text-[#0d5e92] font-bold bg-[#ffffff] rounded-r-full' : 'text-slate-600 font-medium hover:text-[#0d5e92]' }} transition-all group"
                    href="{{ route($item['route']) }}">
                    <span class="material-symbols-outlined mr-3 text-lg"
                        data-icon="{{ $item['icon'] }}">{{ $item['icon'] }}</span>
                    <span class="font-headline tracking-widest text-[11px] uppercase">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="px-6 mt-auto pt-8 space-y-1 border-t border-slate-200/50">
            <a class="flex items-center py-2 text-slate-500 hover:text-primary text-[11px] font-headline uppercase tracking-widest"
                href="#">
                <span class="material-symbols-outlined mr-3 text-lg" data-icon="help">help</span>
                Support
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center py-2 text-slate-500 hover:text-primary text-[11px] font-headline uppercase tracking-widest w-full">
                    <span class="material-symbols-outlined mr-3 text-lg" data-icon="logout">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 ml-64">
        <!-- Top Navbar Fixed -->
        <header
            class="w-full top-0 sticky bg-surface flex justify-between items-center px-6 py-3 z-30 border-b border-outline-variant/10">
            <div class="flex items-center gap-6">
                <div class="hidden lg:flex items-center bg-surface-container-high px-4 py-1.5 rounded-full">
                    <span class="material-symbols-outlined text-outline text-sm mr-2" data-icon="search">search</span>
                    <input class="bg-transparent border-none text-xs focus:ring-0 w-64 text-on-surface"
                        placeholder="Search..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="p-2 rounded-full hover:bg-slate-200/50 transition-colors relative">
                    <span class="material-symbols-outlined text-slate-600"
                        data-icon="notifications">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
                </button>
                <button class="p-2 rounded-full hover:bg-slate-200/50 transition-colors">
                    <span class="material-symbols-outlined text-slate-600" data-icon="settings">settings</span>
                </button>
                <div class="flex items-center gap-3 ml-2 pl-4 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold text-on-surface">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-slate-500 capitalize">
                            {{ str_replace('_', ' ', Auth::user()->role) }}</div>
                    </div>
                    <img alt="User profile" class="w-8 h-8 rounded-full object-cover bg-slate-300"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3477ac&color=fff" />
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
            {{ $slot }}
        </main>
    </div>

    <!-- Mobile Bottom Nav -->
    <nav
        class="md:hidden fixed bottom-0 left-0 right-0 bg-surface flex justify-around items-center py-3 border-t border-slate-200 z-50">
        @if(Auth::user()->role === 'admin')
            <a class="flex flex-col items-center text-slate-400" href="#">
                <span class="material-symbols-outlined text-xl" data-icon="dashboard">dashboard</span>
                <span class="text-[9px] font-bold mt-1">ADMIN</span>
            </a>
        @elseif(Auth::user()->role === 'manager')
            <a class="flex flex-col items-center text-slate-400" href="#">
                <span class="material-symbols-outlined text-xl" data-icon="dashboard">dashboard</span>
                <span class="text-[9px] font-bold mt-1">REPORT</span>
            </a>
        @elseif(Auth::user()->role === 'staff_gudang')
            <a class="flex flex-col items-center text-slate-400" href="#">
                <span class="material-symbols-outlined text-xl" data-icon="inventory_2">inventory_2</span>
                <span class="text-[9px] font-bold mt-1">STOK</span>
            </a>
        @elseif(Auth::user()->role === 'staff_logistik')
            <a class="flex flex-col items-center text-slate-400" href="#">
                <span class="material-symbols-outlined text-xl" data-icon="local_shipping">local_shipping</span>
                <span class="text-[9px] font-bold mt-1">PO</span>
            </a>
        @endif
        <a class="flex flex-col items-center text-slate-400" href="#">
            <span class="material-symbols-outlined text-xl" data-icon="notifications">notifications</span>
            <span class="text-[9px] font-bold mt-1">ALERTS</span>
        </a>
        <a class="flex flex-col items-center text-slate-400" href="#">
            <span class="material-symbols-outlined text-xl" data-icon="person">person</span>
            <span class="text-[9px] font-bold mt-1">USER</span>
        </a>
    </nav>

    @stack('scripts')
</body>

</html>