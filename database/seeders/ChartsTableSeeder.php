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
                'created_at' => '2023-10-07 03:53:28',
                'field' => 'display_name',
                'id' => 1,
                'model' => 'TCG\\Voyager\\Models\\User',
                'order' => 2,
                'parent_id' => NULL,
                'relation_name' => 'role',
                'report_type' => 'group_by_relationship',
                'size' => '4',
                'title' => 'User',
                'type' => 'pie',
                'updated_at' => '2023-10-10 03:25:16',
            ),
            1 => 
            array (
                'created_at' => '2023-10-07 04:08:09',
                'field' => 'status',
                'id' => 2,
                'model' => 'TCG\\Voyager\\Models\\Post',
                'order' => 1,
                'parent_id' => NULL,
                'relation_name' => NULL,
                'report_type' => 'group_by_string',
                'size' => '4',
                'title' => 'Post',
                'type' => 'pie',
                'updated_at' => '2023-10-10 03:23:30',
            ),
            2 => 
            array (
                'created_at' => '2023-10-10 03:31:23',
                'field' => 'display_name',
                'id' => 3,
                'model' => 'TCG\\Voyager\\Models\\User',
                'order' => 2,
                'parent_id' => NULL,
                'relation_name' => 'role',
                'report_type' => 'group_by_relationship',
                'size' => '4',
                'title' => 'User (clone)',
                'type' => 'pie',
                'updated_at' => '2023-10-10 03:31:43',
            ),
        ));
        
        
    }
}