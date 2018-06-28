<?php

namespace App\Helpers;

use App\Models\Settings as SettingsModel;

class Settings
{
    /**
     * Get the the setting
     * @param string $key
     * @param int $locale_id
     * @return string
     */
    public static function get($key, $locale_id = NULL)
    {
        $result = SettingsModel::where('name', '=', $key)->where('locale_id', '=', $locale_id)->get()->first();
        return $result? $result->value : NULL;
    }
    
    /**
     * Set the selected setting
     * @param string $key
     * @param string $value
     */
    public static function set($key, $value)
    {
        if(SettingsModel::where('name', $key)->get()->first()) {
             $settings = SettingsModel::where('name', $key)->get()->first();
        } else {
            $settings = new SettingsModel;
            $settings->name = $key;
        }
        $settings->value = $value;
        $settings->save();
    }
}
