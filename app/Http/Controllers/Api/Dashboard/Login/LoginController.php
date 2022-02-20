<?php

namespace App\Http\Controllers\Api\Dashboard\Login;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use ApiTrait;
    public function login(Request $request)
    {

        $vaildate = Validator::make($request->all(),[
            'email'    => ['required','email'],
            'password' => ['required']
        ]);
        if ($vaildate->fails())
        {
            return $this->response($vaildate->errors(),'success',422);
        }

        config(['auth.guards.api-admin.driver'=>'session']);
        if(!$admin = Auth::guard('api-admin')->attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            return $this->response('email or password incorrect','success',200);
        }
        $token = Auth::guard('api-admin')->user()->createToken('admin')->accessToken;
        $data = [
            'admin'=>Auth::guard('api-admin')->user(),
            'token'=>$token
            ];
        return $this->response($data,'success',200);

    }
}
