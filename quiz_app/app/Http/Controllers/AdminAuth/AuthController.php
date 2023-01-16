<?php

namespace App\Http\Controllers\AdminAuth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AdminResource;
use App\Http\Requests\NewAdminRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AdminLoginRequest;

class AuthController extends Controller
{
   use ResponseTrait;

    public function adminRegister(NewAdminRequest $request)
    {
        $admin = Admin::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => strtoupper($request->firstname[0]) . $request->lastname
        ]);

        return $this->okResponse('Admin Registered Successfully', new AdminResource($admin));
    }

    public function adminLogin(AdminLoginRequest $request)
    {
        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return $this->badRequestResponse('Invalid Credentials');
        }
        if(auth()->guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            $token = $admin->createToken('Plain Token')->plainTextToken;
            return $this->okResponse('Logged In', [new AdminResource($admin), $token]);
        }
    }

    public function adminSignout()
    {
        if(Auth::guard('admin')){
            auth()->guard('admin')->logout();
            Session::flush();
        };
        
        return $this->okResponse('Logged Out');
    }
}
