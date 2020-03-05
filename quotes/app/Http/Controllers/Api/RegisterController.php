<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class RegisterController extends Controller
{
  //
  public function action(Request $request){

    // validation
    $this->validate($request,[
      'name' => 'required|min:3',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:4',
    ]);
    // end validation
    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'api_token' => Str::random(80),
    ]);

    // return response()->json($user);
    return (new UserResource($user))->additional([
      'meta' => [
        'token' => $user->api_token,
      ]
    ]);
  }

}
