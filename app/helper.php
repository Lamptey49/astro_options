<?php

use App\Models\Settings;

if (! function_exists('settings')) {
    function settings(string $key, $default = null)
    {
        return Settings::get($key, $default);
    }
}
