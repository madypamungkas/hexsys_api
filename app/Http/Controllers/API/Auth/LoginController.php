<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Traits\ResponseAPI;
use DB;
use Auth;
use App\User;

class LoginController extends Controller
{
  use ResponseAPI;

  public function login(Request $request){
    if(Auth::attempt([
      'email' => request('email'),
      'password' => request('password'),
    ]))
    {
        $user = Auth::user();
        $user->roles = $user->getRoleNames();
        $user->token =  $user->createToken('MyApp')->accessToken;
        return $this->success("Login berhasil.", $user);
    }
    else{
        return $this->error('Password atau email yang anda masukkan tidak sesuai!', 401);
    }
  }
    
}
