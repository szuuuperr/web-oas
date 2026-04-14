<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-high": "#e5e8ee",
                        "surface-container-highest": "#dfe3e8",
                        "secondary": "#5d5f5f",
                        "surface-dim": "#d7dae0",
                        "on-secondary-fixed": "#1a1c1c",
                        "surface-variant": "#dfe3e8",
                        "on-primary-container": "#f6f9ff",
                        "surface-container": "#ebeef4",
                        "tertiary-container": "#99690a",
                        "primary-fixed-dim": "#96cbff",
                        "secondary-container": "#dfe0e0",
                        "on-tertiary-container": "#fff8f2",
                        "on-background": "#181c20",
                        "on-tertiary-fixed": "#281800",
                        "background": "#fefefe",
                        "surface": "#fefefe",
                        "secondary-fixed-dim": "#c6c6c7",
                        "on-error": "#ffffff",
                        "outline": "#717880",
                        "on-surface-variant": "#41474f",
                        "primary-container": "#3477ac",
                        "tertiary-fixed-dim": "#f8bc5c",
                        "outline-variant": "#c1c7d0",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#3477ac",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "tertiary-fixed": "#ffddaf",
                        "on-secondary": "#ffffff",
                        "inverse-on-surface": "#eef1f7",
                        "on-tertiary-fixed-variant": "#614000",
                        "surface-tint": "#3477ac",
                        "on-secondary-container": "#616363",
                        "inverse-surface": "#2d3135",
                        "inverse-primary": "#96cbff",
                        "on-tertiary": "#ffffff",
                        "surface-bright": "#fefefe",
                        "on-error-container": "#93000a",
                        "tertiary": "#7a5200",
                        "on-surface": "#181c20",
                        "surface-container-low": "#f1f4fa",
                        "on-primary": "#ffffff",
                        "on-primary-fixed-variant": "#004a76",
                        "on-primary-fixed": "#001d33",
                        "secondary-fixed": "#e2e2e2",
                        "primary-fixed": "#cee5ff",
                        "on-secondary-fixed-variant": "#454747"
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

        .login-card {
            background: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        }

        .blueprint-bg {
            background-image:
                linear-gradient(rgba(52, 119, 172, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(52, 119, 172, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
        }
    </style>
</head>

<body class="bg-surface font-body text-on-surface antialiased overflow-hidden blueprint-bg">
    <main class="relative min-h-screen w-full flex items-center justify-center p-6">
        <!-- Background Imagery (Prominent but Subtle) -->
        <div class="absolute inset-0 z-0 overflow-hidden opacity-10">
            <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface"></div>
        </div>
        <div class="relative  w-full max-w-md">
            <!-- Centered Login Card -->
            <div class="login-card rounded-xl border border-surface-container-highest overflow-hidden">
                <div class="bg-primary h-1.5 w-full"></div>
                <div class="p-8 md:p-12">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <div class="mb-10 flex flex-col text-center justify-center item-center">
                        <div class="flex justify-center pb-4">
                            <img alt="Logo Parkland" class="w-24 h-auto" src="{{ ('images/logo-parkland.svg') }}" />
                        </div>
                        <h2 class="font-headline font-extrabold text-2xl text-on-surface mb-2">Account Access</h2>
                        <p class="text-on-surface-variant font-medium text-sm">PT. Parkland World Indonesia </p>
                    </div>
                    <form class="space-y-6" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="space-y-1.5">
                            <label
                                class="block font-label font-bold text-[10px] uppercase tracking-[0.15em] text-on-surface-variant"
                                for="email">Operator ID / Email</label>
                            <div class="relative group @error('email') has-error @enderror">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-lg group-focus-within:text-primary transition-colors"
                                    data-icon="person">person</span>
                                <input
                                    class="w-full bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary/20 rounded px-10 py-3 font-body text-sm placeholder:text-outline-variant transition-all outline-none @error('email') border-error @enderror"
                                    id="email" placeholder="foreman@pwi.co.id" type="email" name="email"
                                    value="{{ old('email') }}" required autofocus autocomplete="username" />
                            </div>
                            @error('email')
                                <div class="text-error text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="space-y-1.5">
                            <label
                                class="block font-label font-bold text-[10px] uppercase tracking-[0.15em] text-on-surface-variant"
                                for="password">Password</label>
                            <div class="relative group @error('password') has-error @enderror">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-lg group-focus-within:text-primary transition-colors"
                                    data-icon="lock">lock</span>
                                <input
                                    class="w-full bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary/20 rounded px-10 py-3 font-body text-sm placeholder:text-outline-variant transition-all outline-none @error('password') border-error @enderror"
                                    id="password" placeholder="••••••••••••" type="password" name="password" required
                                    autocomplete="current-password" />
                                <button
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors"
                                    type="button" onclick="togglePassword()">
                                    <span class="material-symbols-outlined text-lg"
                                        data-icon="visibility">visibility</span>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-error text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between py-2">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input
                                    class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary cursor-pointer"
                                    type="checkbox" name="remember" id="remember_me" />
                                <span
                                    class="text-xs font-medium text-on-surface-variant group-hover:text-on-surface transition-colors">Trust
                                    device</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-primary hover:underline transition-all uppercase tracking-tight"
                                    href="{{ route('password.request') }}">Lost Access?</a>
                            @endif
                        </div>

                        <button
                            class="w-full h-12 bg-primary hover:bg-primary/90 text-white font-headline font-extrabold text-sm uppercase tracking-widest rounded transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/10"
                            type="submit">
                            Login
                            <span class="material-symbols-outlined text-[18px]" data-icon="login">login</span>
                        </button>
                    </form>

                    @if (Route::has('register'))
                        <div class="mt-6 text-center">
                            <span class="text-xs text-on-surface-variant">New operator?</span>
                            <a class="text-xs font-bold text-primary hover:underline transition-all uppercase tracking-tight ml-1"
                                href="{{ route('register') }}">Create Account</a>
                        </div>
                    @endif

                    <div class="mt-10 pt-8 border-t border-surface-container-highest flex flex-col items-center gap-4">
                        <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-[0.1em]">Active
                            Nodes: Plant Area 01</p>
                    </div>
                </div>
            </div>

            <!-- Footer Copyright -->
            <footer class="fixed bottom-6 left-0 right-0 text-center">
                <p class="text-[9px] uppercase tracking-[0.2em] text-on-surface-variant/40">
                    © 2024 PT. Parkland World Indonesia | Precision Division
                </p>
            </footer>
    </main>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('[data-icon="visibility"]');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</body>

</html>