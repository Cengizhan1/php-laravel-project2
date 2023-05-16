<?php

namespace App\Http\Controllers\AdminApi\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Auth\LoginRequest;
use App\Http\Requests\AdminApi\Auth\TwoFAVerifyRequest;
use App\Http\Resources\AdminApi\AdminLoginResource;
use App\Http\Resources\AdminApi\AdminResource;
use App\Models\Admin;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $validated = $request->validated();
            $admin = Admin::whereEmail($validated['email'])->whereActive()->first();

            if(!$admin || !$admin->passwordValidate($validated['password']) || !$admin->status) {
                return $this->unauthorized();
            }
            return response()->success(
                data: new AdminLoginResource($admin)
            );
        });
    }

    public function twoFAVerify(TwoFAVerifyRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $validated = $request->validated();

            $auth = app('firebase.auth');
            $idTokenString = $validated['firebase_token'];
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
            $uid = $verifiedIdToken->claims()->get('sub');


            $phone = $verifiedIdToken->claims()->get('firebase')['identities']['phone'][0];
            $admin = Admin::wherePhone($phone)->whereActive()->first();

            if (!$admin) {
                return $this->unauthorized();
            }
            if($admin->firebase_uid === null) {
                $admin->firebase_uid = $uid;
            }
            $admin->last_activated_at = now();
            $admin->save();

            $tokenResult = $admin->createToken('Firebase', ['admin']);

            // Store the created token
            $token = $tokenResult->token;

            // Save the token to the user
            $token->save();
            return response()->success(
                data: [
                    'access_token' => $tokenResult->accessToken,
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString(),
                    'admin' => new AdminResource($admin),
                ]
            );
        });
    }

    public function logout(){
        return $this->withErrorHandling(function (){
            auth('admin')->user()->token()->revoke();
            return response()->success(data: [], message: null, status: 204);
        });
    }
}

