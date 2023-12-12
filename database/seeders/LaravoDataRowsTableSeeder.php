<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use Triptasoft\Laravo\Models\Chart;

class LaravoDataRowsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $chartDataType = DataType::where('slug', 'charts')->firstOrFail();

        $dataRow = $this->dataRow($chartDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Id',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($chartDataType, 'chart_title');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Chart Title',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 2,
            ])->save();
        }

        $dataRow = $this->dataRow($chartDataType, 'type');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'radio_btn',
                'display_name' => 'Type',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 3,
                'details'      => [
                    'default' => 'chart',
                    'options' => [
                        'chart'     => 'Chart',
                        'counter'      => 'Counter',
                    ],
                ],
            ])->save();
        }

        $dataRow = $this->dataRow($chartDataType, 'chart_type');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'radio_btn',
                'display_name' => 'Chart Type',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 3,
                'details'      => [
                    'default' => 'pie',
                    'options' => [
                        'line'     => 'Line',
                        'bar'      => 'Bar',
                        'pie'      => 'Pie',
                        'doughnut' => 'Doughnut',
                    ],
                ],
            ])->save();
        }

        $dataRow = $this->dataRow($chartDataType, 'report_type');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'radio_btn',
                'display_name' => 'Report Type',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 4,
                'details'      => [
                    'default' => 'group_by_string',
                    'options' => [
                        'group_by_date'        => 'Date',
                        'group_by_string'      => 'String',
                        'group_by_relationship' => 'Relation',
                    ],
                ],
            ])->save();
        }

        $dataRow = $this->dataRow($chartDataType, 'model');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Model',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 5
            ])->save();
        }

        $dataRow = $this->dataRow($chartDataType, 'group_by_field');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Group by Field',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 6
            ])->save();
        }

        $dataRow = $this->dataRow($chartDataType, 'size');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'Size',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 7
            ])->save();
        }

        $dataRow = $this->dataRow($chartDataType, 'relationship_name');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Relationship Name',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 8
            ])->save();
        }

        $dataRow = $this->dataRow($chartDataType, 'parent_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'hidden',
                'display_name' => 'Parent Id',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 9,
                'details'      => [
                    'browse_tree'            => true,
                    'browse_tree_push_right' => true,
                ],
            ])->save();
        }

        $dataRow = $this->dataRow($chartDataType, 'order');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'hidden',
                'display_name' => 'Order',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 10
            ])->save();
        }

        $dataRow = $this->dataRow($chartDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => 'Created At',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 11
            ])->save();
        }

        $dataRow = $this->dataRow($chartDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => 'Updated At',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 12
            ])->save();
        }

    }

    /**
     * [dataRow description].
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field'        => $field,
        ]);
    }
}
