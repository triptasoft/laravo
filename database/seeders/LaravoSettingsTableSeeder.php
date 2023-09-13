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

        $setting = $this->findSetting('integration.google_client_id');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Google Client ID',
                'value'        => '',
                'details'      => '',
                'type'         => 'text',
                'order'        => 7,
                'group'        => 'Integration',
            ])->save();
        }

        $setting = $this->findSetting('integration.google_client_secret');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Google Client Secret',
                'value'        => '',
                'details'      => '',
                'type'         => 'text',
                'order'        => 8,
                'group'        => 'Integration',
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