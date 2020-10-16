<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ResponseAPI;
use App\Patient;
use Auth;
use DB;

class PatientController extends Controller
{
    use ResponseAPI;

    public function getAllPatient(){
        try {
            $data = Patient::get();

            if(!$data) return $this->error("Pasien tidak ditemukan.", 404);

            return $this->success("List Pasien.", $data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), $th->getStatusCode());
        }
    }

    public function createPatient(Request $request){

        $this->validate(request(),
        [
            'nomor_rumah_sakit' => 'required|max:30',
            'rumah_sakit' => 'required|max:30',
            'nama_pasien' => 'required|max:30',
            'tanggal_lahir' => 'required|date',
        ]
        );

        DB::beginTransaction();
        $data = new Patient();  
        $data->user_id = Auth::id();
        $data->no_rm = $request->nomor_rumah_sakit;
        $data->rs_name = $request->rumah_sakit;
        $data->nama_pasien = $request->nama_pasien;
        $data->birth_date = $request->tanggal_lahir;
        $data->created_by = Auth::id();
        $data->save();
        DB::commit();
        return $this->success("Sukses Menambah Pasien.", $data);
    }

    public function getDetailPatient($id){
        try {
            $data = Patient::find($id);

            if(!$data) return $this->error("Pasien tidak ditemukan.", 404);

            return $this->success("List Pasien.", $data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), $th->getStatusCode());
        }
    }

    public function updatePatient(Request $request,$id){
        $this->validate(request(),
        [
            'nomor_rumah_sakit' => 'required|max:30',
            'rumah_sakit' => 'required|max:30',
            'nama_pasien' => 'required|max:30',
            'tanggal_lahir' => 'required|date',
        ]
        );

        DB::beginTransaction();
        $data = Patient::find($id);
        $data->no_rm = $request->nomor_rumah_sakit;
        $data->rs_name = $request->rumah_sakit;
        $data->nama_pasien = $request->nama_pasien;
        $data->birth_date = $request->tanggal_lahir;
        $data->updated_by = Auth::id();
        $data->save();
        DB::commit();
        return $this->success("Sukses Mengubah Data Pasien.", $data);
    }

    public function deletePatient($id){
        $data = Patient::where('patient_id',$id)->first();
        $data->delete();
        return response()->json(['status' => 'success', 'data'=>'success delete data']);
    }
}
