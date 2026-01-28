<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Settings;

class SettingTranslation extends Model
{
    protected $fillable = [
        'setting_id',
        'locale',
        'value',
    ];

    public function setting()
    {
        return $this->belongsTo(Settings::class);
    }
}
