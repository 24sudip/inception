<?php

namespace App\Http\Controllers\Api\Auth;

use App\Customs\Services\EmailVerificationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\ResendEmailVerificationLinkRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private EmailVerificationService $service)
    {
        // $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(LoginRequest $request) {
        $token = auth()->attempt($request->validated());
        if ($token) {
            return $this->respondWithToken($token, auth()->user());
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid Credentials'
            ], 401);
        }
    }

    // resend verification link
    public function resendEmailVerificationLink(ResendEmailVerificationLinkRequest $request) {
        return $this->service->resendLink($request->email);
    }

    // Verify user email
    public function verifyUserEmail(VerifyEmailRequest $request) {
        return $this->service->verifyEmail($request->email, $request->token);
    }

    public function register(RegistrationRequest $request) {
        $user = User::create($request->validated());
        if ($user) {
            $this->service->sendVerificationLink($user);
            $token = auth()->login($user);
            return $this->respondWithToken($token, $user);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occured while trying to create user',
                // 'error' => 'Unauthorized'
            ], 500);
        }
    }

    // Return JWT Access Token
    public function respondWithToken($token, $user)
    {
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout() {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'User has been logged out successfully',
        ]);
    }
}
