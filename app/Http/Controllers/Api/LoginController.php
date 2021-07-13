<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiLoginRequest;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * 取得API TOKEN
     * @param ApiLoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(ApiLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }
        $token = $user->createToken('my-app-token')->plainTextToken;
        $response = [
            'token' => $token
        ];
        return response($response, 201);
    }
}
