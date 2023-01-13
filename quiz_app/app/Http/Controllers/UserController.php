<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccessUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function createNewUser(CreateUserRequest $request)
    {

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->save();


        return returnResponse('User Created Successfully', 201);
    }

    public function accessUserAccount(AccessUserRequest $request)
    {

        $userRequest = User::where('email', $request->email)->first();

        if (!$userRequest) return returnResponse('Invalid User Details', 400);

        if (!Hash::check($request->password, $userRequest->password)) return returnResponse('Invalid User Details', 400);

        $tokenResult = $userRequest->createToken('User Auth', ['rw:self, r:self']);

        $token = $tokenResult->accessToken;

        $token->expires_at = Carbon::now()->addDays(3);

        $token->save();

        return returnResponse('User Signed In Successfully', 200, [
            'access_token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->accessToken->expires_at
            )->toDateTimeString(),
            'user' => $userRequest
        ]);
    }
}
