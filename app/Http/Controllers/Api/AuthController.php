<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Register new User.
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);

            if ($user) {
                return ResponseHelper::success(message: "Register user successfully", data: $user, statusCode: 201);
            }
            return ResponseHelper::error(message: "Unable to register user", statusCode: 400);
        } catch (Exception $e) {
            Log::debug("Unable to register user : " . $e->getMessage() . " Line number : " . $e->getLine());
            return ResponseHelper::error(message: "Unable to register user, " . $e->getMessage(), statusCode: 500);
        }
    }

    /**
     * Login user.
     */
    public function login(LoginRequest $request)
    {
        try {
            $authenticated = Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ]);
            if (!$authenticated) {
                return ResponseHelper::error(message: "invalid credentials", statusCode: 400);
            }

            //create token
            $token = Auth::user()->createToken('My API Token')->plainTextToken;

            $responseData = [
                'token' => $token,
            ];

            return ResponseHelper::success(message: "Login user successfully", data: $responseData, statusCode: 200);
        } catch (Exception $e) {
            Log::debug("Unable to login user : " . $e->getMessage() . " Line number : " . $e->getLine());
            return ResponseHelper::error(message: "Unable to login user, " . $e->getMessage(), statusCode: 500);
        }
    }

    /**
     * Login user.
     */
    public function userProfile()
    {
        try {
            $user = Auth::user();

            $responseData = [
                'user' => $user,
            ];

            if ($user) {
                return ResponseHelper::success(message: "Get user profile successfully", data: $responseData, statusCode: 200);
            }
            return ResponseHelper::error(message: "Unable to get user profile", statusCode: 400);
        } catch (Exception $e) {
            Log::debug("Unable to get user profile : " . $e->getMessage() . " Line number : " . $e->getLine());
            return ResponseHelper::error(message: "Unable to get user profile, " . $e->getMessage(), statusCode: 500);
        }
    }

    /**
     * Logout user.
     */
    public function userLogout()
    {
        try {
            $user = Auth::user();

            if ($user) {
                $user->currentAccessToken()->delete();
                return ResponseHelper::success(message: "Logout successfully", statusCode: 200);
            }
            return ResponseHelper::error(message: "Unable to logout", statusCode: 400);
        } catch (Exception $e) {
            Log::debug("Unable to logoute : " . $e->getMessage() . " Line number : " . $e->getLine());
            return ResponseHelper::error(message: "Unable to logoute, " . $e->getMessage(), statusCode: 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegisterRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
