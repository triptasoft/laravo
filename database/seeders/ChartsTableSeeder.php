<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChartsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('charts')->delete();
        
        \DB::table('charts')->insert(array (
            0 => 
            array (
                'chart_type' => 'pie',
                'created_at' => '2023-10-07 03:53:28',
                'group_by_field' => 'display_name',
                'id' => 1,
                'model' => 'TCG\\Voyager\\Models\\User',
                'order' => 5,
                'parent_id' => NULL,
                'relationship_name' => 'role',
                'report_type' => 'group_by_relationship',
                'group_by_period' => 'day',
                'size' => '4',
                'chart_title' => 'User',
                'type' => 'chart',
                'updated_at' => '2023-10-12 03:06:08',
            ),
            1 => 
            array (
                'chart_type' => 'line',
                'created_at' => '2023-10-07 04:08:09',
                'group_by_field' => 'created_at',
                'id' => 2,
                'model' => 'TCG\\Voyager\\Models\\Post',
                'order' => 6,
                'parent_id' => NULL,
                'relationship_name' => NULL,
                'report_type' => 'group_by_date',
                'group_by_period' => 'day',
                'size' => '4',
                'chart_title' => 'Post',
                'type' => 'chart',
                'updated_at' => '2023-10-12 03:06:08',
            ),
            2 => 
            array (
                'chart_type' => 'bar',
                'created_at' => '2023-10-10 03:31:23',
                'group_by_field' => 'display_name',
                'id' => 3,
                'model' => 'TCG\\Voyager\\Models\\User',
                'order' => 7,
                'parent_id' => NULL,
                'relationship_name' => 'role',
                'report_type' => 'group_by_relationship',
                'group_by_period' => 'day',
                'size' => '4',
                'chart_title' => 'Page',
                'type' => 'chart',
                'updated_at' => '2023-10-12 03:06:08',
            ),
            3 => 
            array (
                'chart_type' => 'pie',
                'created_at' => '2023-10-12 02:48:31',
                'group_by_field' => 'name',
                'id' => 6,
                'model' => 'TCG\\Voyager\\Models\\User',
                'order' => 1,
                'parent_id' => NULL,
                'relationship_name' => NULL,
                'report_type' => 'group_by_string',
                'group_by_period' => 'day',
                'size' => NULL,
                'chart_title' => 'User',
                'type' => 'counter',
                'updated_at' => '2023-10-12 03:03:56',
            ),
            4 => 
            array (
                'chart_type' => 'pie',
                'created_at' => '2023-10-12 03:03:40',
                'group_by_field' => 'name',
                'id' => 7,
                'model' => 'TCG\\Voyager\\Models\\Post',
                'order' => 2,
                'parent_id' => NULL,
                'relationship_name' => NULL,
                'report_type' => 'group_by_string',
                'group_by_period' => 'day',
                'size' => NULL,
                'chart_title' => 'Post',
                'type' => 'counter',
                'updated_at' => '2023-10-12 03:03:56',
            ),
            5 => 
            array (
                'chart_type' => 'pie',
                'created_at' => '2023-10-12 03:04:46',
                'group_by_field' => 'name',
                'id' => 8,
                'model' => 'TCG\\Voyager\\Models\\Page',
                'order' => 3,
                'parent_id' => NULL,
                'relationship_name' => NULL,
                'report_type' => 'group_by_string',
                'group_by_period' => 'day',
                'size' => NULL,
                'chart_title' => 'Page',
                'type' => 'counter',
                'updated_at' => '2023-10-12 03:05:15',
            ),
            6 => 
            array (
                'chart_type' => 'pie',
                'created_at' => '2023-10-12 03:06:02',
                'group_by_field' => 'name',
                'id' => 9,
                'model' => 'TCG\\Voyager\\Models\\Category',
                'order' => 4,
                'parent_id' => NULL,
                'relationship_name' => NULL,
                'report_type' => 'group_by_string',
                'group_by_period' => 'day',
                'size' => NULL,
                'chart_title' => 'Category',
                'type' => 'counter',
                'updated_at' => '2023-10-12 03:06:08',
            ),
        ));
        
        
    }
}