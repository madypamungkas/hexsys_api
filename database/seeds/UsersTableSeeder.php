<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 'abf0f672-2008-415a-8c7e-f6913e55799d',
                'name' => 'Layndo',
                'email' => 'layndoaqsa18@gmail.com',
                'nomor_telepon' => '088880088880',
                'email_verified_at' => NULL,
                'password' => bcrypt('12345678'),
                'remember_token' => NULL,
                'created_at' => '2020-10-09 13:32:02',
                'updated_at' => '2020-10-09 13:32:02',
            ),
            1 => 
            array (
                'id' => 'fbf13592-2192-48de-9aeb-3cc582130b8a',
                'name' => 'Developer',
                'email' => 'developer@dev.com',
                'nomor_telepon' => NULL,
                'email_verified_at' => NULL,
                'password' => bcrypt('12345678'),
                'remember_token' => NULL,
                'created_at' => '2020-09-27 18:22:29',
                'updated_at' => '2020-09-27 18:22:29',
            ),
        ));
        
        
    }
}