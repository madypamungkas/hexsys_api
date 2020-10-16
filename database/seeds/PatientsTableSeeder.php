<?php

use Illuminate\Database\Seeder;

class PatientsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('patients')->delete();
        
        \DB::table('patients')->insert(array (
            0 => 
            array (
                'patient_id' => '64917582-ddd2-4351-998c-10c2a61cf4cc',
                'user_id' => 'abf0f672-2008-415a-8c7e-f6913e55799d',
                'no_rm' => '1',
                'rs_name' => 'tes',
                'nama_pasien' => 'pasien2',
                'birth_date' => '2020-10-11',
                'created_by' => 'abf0f672-2008-415a-8c7e-f6913e55799d',
                'updated_by' => 'abf0f672-2008-415a-8c7e-f6913e55799d',
                'created_at' => '2020-10-16 17:38:30',
                'updated_at' => '2020-10-16 17:41:11',
            ),
        ));
        
        
    }
}