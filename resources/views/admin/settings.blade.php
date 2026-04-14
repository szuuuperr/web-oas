<x-dashboard-layout>
    @php
        $settingsByKey = [];
        foreach ($settings as $s) {
            $settingsByKey[$s->key] = $s->value;
        }
    @endphp
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Konfigurasi Sistem</h2>
                <p class="text-xs text-slate-500 font-medium">Pengaturan dan konfigurasi aplikasi PWI Industrial OS</p>
            </div>
            <button type="submit" form="settingsForm" class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-sm" data-icon="save">save</span>
                Simpan Perubahan
            </button>
        </div>

        <!-- Summary Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Settings</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-primary">{{ $settings->count() }}</span>
                        <span class="text-[11px] font-bold text-primary/60">Items</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="tune">tune</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-primary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="check_circle">check_circle</span>
                    CONFIGURED
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Key Groups</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-on-surface">4</span>
                        <span class="text-[11px] font-bold text-slate-400">Groups</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="folder">folder</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="verified">verified</span>
                    ALL GROUPS
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Last Updated</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-on-surface">-</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="schedule">schedule</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-400 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="update">update</span>
                    RECENT
                </div>
            </div>
        </section>

        <!-- Settings Section -->
        <form method="POST" action="{{ route('admin.settings.update') }}" id="settingsForm" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @csrf
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Company Settings -->
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-surface-container-low">
                        <h3 class="font-headline text-sm font-bold text-on-surface uppercase tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary" data-icon="business">business</span>
                            Pengaturan Perusahaan
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Nama Perusahaan</label>
                            <input name="company_name" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary" type="text" value="{{ $settingsByKey['company_name'] ?? 'PT. Parkland World Indonesia' }}"/>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Alamat</label>
                            <textarea name="company_address" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary" rows="2">{{ $settingsByKey['company_address'] ?? '' }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Telepon</label>
                                <input name="company_phone" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary" type="text" value="{{ $settingsByKey['company_phone'] ?? '' }}"/>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Email</label>
                                <input name="company_email" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary" type="email" value="{{ $settingsByKey['company_email'] ?? '' }}"/>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory Alerts Settings -->
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-surface-container-low">
                        <h3 class="font-headline text-sm font-bold text-on-surface uppercase tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-error" data-icon="warning">warning</span>
                            Pengaturan Alert Stok
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Low Stock Threshold (%)</label>
                            <input name="default_minimum_stock_threshold" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary" type="number" value="{{ $settingsByKey['default_minimum_stock_threshold'] ?? '30' }}"/>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Notifikasi Email</label>
                            <div class="flex items-center gap-3">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input name="email_notifications_enabled" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary" type="checkbox" value="true" {{ ($settingsByKey['email_notifications_enabled'] ?? 'false') === 'true' ? 'checked' : '' }}/>
                                    <span class="text-sm text-on-surface">Aktifkan notifikasi email</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Numbering Format -->
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-surface-container-low">
                        <h3 class="font-headline text-sm font-bold text-on-surface uppercase tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary" data-icon="tag">tag</span>
                            Format Penomoran
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Prefix PO</label>
                                <input name="po_auto_number_prefix" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary" type="text" value="{{ $settingsByKey['po_auto_number_prefix'] ?? 'PO-2026' }}"/>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Prefix Transaksi</label>
                                <input name="transaction_auto_number_prefix" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary" type="text" value="{{ $settingsByKey['transaction_auto_number_prefix'] ?? 'PW-TX' }}"/>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prediction Settings -->
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-surface-container-low">
                        <h3 class="font-headline text-sm font-bold text-on-surface uppercase tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-tertiary" data-icon="trending_up">trending_up</span>
                            Pengaturan Prediksi
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Default SMA Period</label>
                                <select name="default_sma_period" class="w-full appearance-none bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                                    <option value="3" {{ ($settingsByKey['default_sma_period'] ?? '') == '3' ? 'selected' : '' }}>3 Hari</option>
                                    <option value="5" {{ ($settingsByKey['default_sma_period'] ?? '') == '5' ? 'selected' : '' }}>5 Hari</option>
                                    <option value="7" {{ ($settingsByKey['default_sma_period'] ?? '') == '7' ? 'selected' : '' }}>7 Hari</option>
                                    <option value="14" {{ ($settingsByKey['default_sma_period'] ?? '') == '14' ? 'selected' : '' }}>14 Hari</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Metode Prediksi</label>
                                <select name="prediction_method" class="w-full appearance-none bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary">
                                    <option value="SMA" {{ ($settingsByKey['prediction_method'] ?? 'SMA') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="WMA" {{ ($settingsByKey['prediction_method'] ?? 'SMA') == 'WMA' ? 'selected' : '' }}>WMA</option>
                                    <option value="EMA" {{ ($settingsByKey['prediction_method'] ?? 'SMA') == 'EMA' ? 'selected' : '' }}>EMA</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-slate-500 mb-2">Forecast Horizon</label>
                            <input name="forecast_horizon" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 text-sm focus:ring-0 focus:border-primary" type="number" value="{{ $settingsByKey['forecast_horizon'] ?? 30 }}"/>
                        </div>
                    </div>
                </div>

                <!-- Auto Assignment Settings -->
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-surface-container-low">
                        <h3 class="font-headline text-sm font-bold text-on-surface uppercase tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary" data-icon="assignment">assignment</span>
                            Pengaturan Otomatis
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="auto_assign_po_manager" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary" type="checkbox" value="true" {{ ($settingsByKey['auto_assign_po_manager'] ?? 'true') === 'true' ? 'checked' : '' }}/>
                                <span class="text-sm text-on-surface">Auto-assign PO ke Manager</span>
                            </label>
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="low_stock_alert_enabled" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary" type="checkbox" value="true" {{ ($settingsByKey['low_stock_alert_enabled'] ?? 'true') === 'true' ? 'checked' : '' }}/>
                                <span class="text-sm text-on-surface">Aktifkan alert stok rendah</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-dashboard-layout>