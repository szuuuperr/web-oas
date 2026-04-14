<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::all();

        $defaultSettings = [
            'company_name' => 'PT. Parkland World Indonesia',
            'company_address' => '',
            'company_phone' => '',
            'company_email' => '',
            'po_auto_number_prefix' => 'PO-2026',
            'transaction_auto_number_prefix' => 'PW-TX',
            'default_minimum_stock_threshold' => '30',
            'low_stock_alert_enabled' => 'true',
            'email_notifications_enabled' => 'false',
            'auto_assign_po_manager' => 'true',
            'default_sma_period' => '5',
            'prediction_method' => 'SMA',
            'forecast_horizon' => '30',
        ];

        return view('admin.settings', compact('settings', 'defaultSettings'));
    }

    public function update(Request $request)
    {
        $settingsData = $request->except(['_token', '_method']);

        foreach ($settingsData as $key => $value) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => $this->getSettingGroup($key),
                ]
            );
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'settings',
            'description' => 'Mengupdate konfigurasi sistem',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.settings')
            ->with('success', 'Konfigurasi sistem berhasil disimpan.');
    }

    private function getSettingGroup($key)
    {
        $groups = [
            'company_name' => 'general',
            'app_name' => 'general',
            'po_auto_number_prefix' => 'auto_numbers',
            'transaction_auto_number_prefix' => 'auto_numbers',
            'default_minimum_stock_threshold' => 'inventory',
            'low_stock_alert_enabled' => 'inventory',
            'email_notifications_enabled' => 'notifications',
            'auto_assign_po_manager' => 'notifications',
        ];

        return $groups[$key] ?? 'general';
    }
}
