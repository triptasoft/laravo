<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;

class LaravoDataTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $dataType = $this->dataType('slug', 'charts');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'charts',
                'display_name_singular' => 'Chart',
                'display_name_plural'   => 'Charts',
                'icon'                  => 'voyager-pie-chart',
                'model_name'            => 'Triptasoft\\Laravo\\Models\\Chart',
                'policy_name'           => '',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"extra_details":{},"scope":null}',
            ])->save();
        }
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
}
