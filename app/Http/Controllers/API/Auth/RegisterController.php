<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Traits\ResponseAPI;
use DB;
use Auth;
use App\User;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use ResponseAPI;
    protected function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|unique:users|max:50',
            'password' => 'required|string|max:191',
            'nomor_telepon' => 'required|digits_between:10,14',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->all(), 200);
        } else {
            DB::beginTransaction();
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->nomor_telepon = $request->nomor_telepon;
            $user->save();

            $user->token =  $user->createToken('MyApp')->accessToken;
            $user->assignRole('User');

            DB::commit();
            return $this->success("Registrasi berhasil.", $user);
        }
    }
}
