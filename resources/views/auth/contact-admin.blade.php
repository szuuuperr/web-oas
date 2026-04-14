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
        <div class="absolute inset-0 z-0 overflow-hidden opacity-10">
            <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface"></div>
        </div>
        <div class="relative z-30 w-full max-w-md">
            <div class="login-card rounded-xl border border-surface-container-highest overflow-hidden">
                <div class="bg-primary h-1.5 w-full"></div>
                <div class="p-8 md:p-12">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <div class="mb-10 text-center">
                        <h2 class="font-headline font-extrabold text-2xl text-on-surface mb-2">Akses Diblokir</h2>
                        <p class="text-on-surface-variant font-medium text-sm">Pendaftaran akun telah dinonaktifkan</p>
                    </div>

                    <div class="bg-surface-container-low rounded-lg p-4 mb-6">
                        <p class="text-sm text-on-surface text-center">
                            Silakan hubungi <span class="font-bold text-primary">administrator</span> untuk meminta akses akun.
                        </p>
                    </div>

                    <div class="text-center space-y-3">
                        <p class="text-xs text-on-surface-variant">atau gunakan akun yang sudah terdaftar</p>
                        <a class="inline-flex items-center gap-2 text-primary hover:underline font-medium text-sm"
                            href="{{ route('login') }}">
                            <span class="material-symbols-outlined text-[18px]" data-icon="login">login</span>
                            Login dengan Akun Eksisting
                        </a>
                    </div>

                    <div class="mt-8 pt-6 border-t border-surface-container-highest flex flex-col items-center gap-4">
                        <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-[0.1em]">Hubungi Admin: Plant Area 01</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
