<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Settings extends Model
{
    protected $fillable = ['key', 'value'];

    public function translations()
    {
        return $this->hasMany(SettingTranslation::class, 'setting_id');
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', config('app.fallback_locale'));
    }

    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();

        if (! $setting) {
            return $default;
        }

        return $setting->value ?? $default;
    }
}
