<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'created_at' => '2020-09-27 18:22:29',
                'updated_at' => '2020-09-27 18:22:29',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Admin Instansi',
                'guard_name' => 'web',
                'created_at' => '2020-09-27 18:22:29',
                'updated_at' => '2020-09-27 18:22:29',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'User',
                'guard_name' => 'web',
                'created_at' => '2020-09-27 18:22:29',
                'updated_at' => '2020-09-27 18:22:29',
            ),
        ));
        
        
    }
}