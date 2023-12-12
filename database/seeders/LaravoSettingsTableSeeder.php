<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Setting;

class LaravoSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $setting = $this->findSetting('google-auth.google_client_id');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Google Client ID',
                'value'        => '',
                'details'      => '',
                'type'         => 'text',
                'order'        => 7,
                'group'        => 'Google Auth',
            ])->save();
        }

        $setting = $this->findSetting('google-auth.google_client_secret');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Google Client Secret',
                'value'        => '',
                'details'      => '',
                'type'         => 'text',
                'order'        => 8,
                'group'        => 'Google Auth',
            ])->save();
        }
        
        $setting = $this->findSetting('google-auth.google_redirect');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Google Redirect URI',
                'value'        => 'example.com/api/google/callback',
                'details'      => '',
                'type'         => 'text',
                'order'        => 9,
                'group'        => 'Google Auth',
            ])->save();
        }
    }

    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}