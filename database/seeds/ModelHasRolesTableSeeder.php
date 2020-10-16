<?php

use Illuminate\Database\Seeder;

class ModelHasRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('model_has_roles')->delete();
        
        \DB::table('model_has_roles')->insert(array (
            0 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\User',
                'model_id' => 'fbf13592-2192-48de-9aeb-3cc582130b8a',
            ),
            1 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\User',
                'model_id' => 'abf0f672-2008-415a-8c7e-f6913e55799d',
            ),
        ));
        
        
    }
}