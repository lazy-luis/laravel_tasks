<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AdminResource;
use App\Http\Requests\NewAdminRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AdminLoginRequest;

class AdminAuthController extends Controller
{
    use ResponseTrait;

    public function adminRegister(NewAdminRequest $request)
    {
        $admin = Admin::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'name' => $request->name,
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
            $tokenRes = $admin->createToken('Admin Token', ['subject-create']);
            $token = $tokenRes->accessToken;
            $token->expires_at = Carbon::now()->addDays(3);
            $token->save();
            return $this->okResponse('Logged In', [new AdminResource($admin), $tokenRes->plainTextToken]);
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
