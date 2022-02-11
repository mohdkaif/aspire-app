<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\APIResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use APIResponse;

    public function register(Request $request)
    {
        try {
            $userData = $request->all();
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:55',
                    'email' => 'email|required|unique:users',
                    'password' => 'required|confirmed',
                ]
            );
            if ($validator->fails()) {
                return $this->error(false, $validator->errors());
            }

            $userData['password'] = bcrypt($request->password);
            if (\Request::segment(2) == 'admin') {
                $userData['role_type'] = 'admin';
            } else {
                $userData['role_type'] = 'customer';
            }
            $user = User::create($userData);
            $accessToken = $user->createToken('authToken')->accessToken;

            return $this->success([
                'user' => $user,
                'access_token' => $accessToken,
                'token_type' => 'Bearer',
            ], true, "Register successfully.");
        } catch (\Exception $e) {
            throw $e;
            return $this->failure(500, "Something went wrong!");
        }
    }

    public function login(Request $request)
    {
        try {
            $loginData = $request->all();
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'email|required',
                    'password' => 'required'
                ]
            );
            if ($validator->fails()) {
                 return $this->error(false, $validator->errors());
            }
            if (!auth()->attempt($loginData)) {
                return $this->error(false, 'Invalid Credentials');
            }
            $user = Auth::user();
            $accessToken = $user->createToken('authToken')->accessToken;
            return $this->success([
                'user' => $user,
                'access_token' => $accessToken,
                'token_type' => 'Bearer',
            ], true, "Login successfully.");
        } catch (\Exception $e) {
            throw $e;
            return $this->failure(500, "Something went wrong!");
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return $this->success('Logged out successfully.');
        } catch (\Throwable $th) {
            return $this->error('Error when logging out!', 500);
        }
    }
}
