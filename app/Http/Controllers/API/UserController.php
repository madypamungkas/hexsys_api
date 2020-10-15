<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Traits\ResponseAPI;
use DB;
use Auth;
use App\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ResponseAPI;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show(){
        $user = Auth::user();
        $user->roles = $user->getRoleNames();
        return $this->success("Detail profil.", $user);
    }

    public function update(Request $request){
        $user= Auth::user();
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:50|unique:users,email,'.$user->id.',id|',
            'nama' => 'required|string|max:50',
            'nomor_telepon' => 'required|digits_between:10,14',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->all(), 200);
        } else {
            DB::beginTransaction();
            $user->email = $request->email;
            $user->name = $request->nama;
            $user->nomor_telepon = $request->nomor_telepon;
            $user->save();
            DB::commit();
            return $this->success("Update data berhasil.", $user);
        }
    }

    public function updatePassword(Request $request)
    {
        $data= Auth::user();
        $validator = Validator::make($request->all(), [
        'password_lama' => 'required',
        'password' => 'required|string|min:8|confirmed|max:191',
        // 'password_confirmation' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->all(), 200);
        } else {
            if(Hash::check($request->password_lama,$data->password)){
                $data->password   = Hash::make($request->password);
                $data->save();
                return $this->success("Password berasil diubah.", $data);
            }
            else{
                return $this->error('Password lama tidak sesuai', 200);
            }
        }
  }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->success("Berhasil keluar.", 'success');
    }
}
