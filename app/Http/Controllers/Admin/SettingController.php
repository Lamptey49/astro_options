<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;

class SettingController extends Controller
{
    // List of valid settings keys to prevent arbitrary data storage
    protected $validSettings = [
        'site_name',
        'site_email',
        'contact_phone',
        'btc_address',
        'usdt_trc20',
        'eth_address',
        'logo',
        'favicon',
    ];

    public function index()
    {
        return view('admin.settings.index', [
            'settings' => Settings::pluck('value', 'key')
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'btc_address' => 'nullable|string|max:255',
            'usdt_trc20' => 'nullable|string|max:255',
            'eth_address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:1024',
        ]);

        // Process only valid settings
        foreach ($validated as $key => $value) {
            if ($request->hasFile($key)) {
                $value = $request->file($key)->store('settings', 'public');
            }

            if ($value !== null) {
                Settings::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }

        return back()->with('success', 'Settings updated successfully!');
    }
}

