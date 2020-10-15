<?php

use Illuminate\Database\Seeder;

class ComponentTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('component')->delete();
        
        \DB::table('component')->insert(array (
            0 => 
            array (
                'com_cd' => 'STATUS_AMBULAN_1',
                'code_nm' => 'Aktif',
                'code_group' => 'STATUS_AMBULAN',
                'code_value' => NULL,
                'keterangan' => NULL,
                'keterangan_2' => NULL,
                'created_by' => '73b7314d-59ee-42bf-ac18-32e61e295180',
                'updated_by' => NULL,
                'created_at' => '2020-09-23 14:40:01',
                'updated_at' => '2020-09-23 14:40:01',
            ),
            1 => 
            array (
                'com_cd' => 'STATUS_AMBULAN_2',
                'code_nm' => 'Tidak Aktif',
                'code_group' => 'STATUS_AMBULAN',
                'code_value' => NULL,
                'keterangan' => NULL,
                'keterangan_2' => NULL,
                'created_by' => '73b7314d-59ee-42bf-ac18-32e61e295180',
                'updated_by' => NULL,
                'created_at' => '2020-09-23 14:40:11',
                'updated_at' => '2020-09-23 14:40:11',
            ),
            2 => 
            array (
                'com_cd' => 'STATUS_INSTANSI_1',
                'code_nm' => 'Aktif',
                'code_group' => 'STATUS_INSTANSI',
                'code_value' => NULL,
                'keterangan' => NULL,
                'keterangan_2' => NULL,
                'created_by' => '73b7314d-59ee-42bf-ac18-32e61e295180',
                'updated_by' => NULL,
                'created_at' => '2020-09-23 13:52:11',
                'updated_at' => '2020-09-23 13:52:11',
            ),
            3 => 
            array (
                'com_cd' => 'STATUS_INSTANSI_2',
                'code_nm' => 'Tidak Aktif',
                'code_group' => 'STATUS_INSTANSI',
                'code_value' => NULL,
                'keterangan' => NULL,
                'keterangan_2' => NULL,
                'created_by' => '73b7314d-59ee-42bf-ac18-32e61e295180',
                'updated_by' => NULL,
                'created_at' => '2020-09-23 13:52:30',
                'updated_at' => '2020-09-23 13:52:30',
            ),
        ));
        
        
    }
}