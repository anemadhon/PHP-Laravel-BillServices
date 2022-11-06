<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthenticationServices;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request, AuthenticationServices $authentication)
    {
        try {
            $userAuthenticated = $authentication->validate($request->validated());

            return response()->json(['data' => [
                'user' => [
                    'id' => $userAuthenticated['id'],
                    'name' => $userAuthenticated['name']
                ],
                'token' => [
                    'id' => $userAuthenticated['token'],
                    'status' => 'authenticated'
                ]
            ]]);
        } catch (\Throwable $th) {
            $message = (int) $th->getCode() === 0 ? $th->getMessage() : 'Internal Error';
            $code = (int) $th->getCode() === 0 ? 401 : 500;

            return response()->json(['error' => $message], $code);
        }
    }

    public function logout(string $id, AuthenticationServices $authentication)
    {
        try {
            $authentication->logout($id);

            return response()->json(status: 204);
        } catch (\Throwable $th) {
            $message = (int) $th->getCode() === 0 ? $th->getMessage() : 'Internal Error';
            $code = (int) $th->getCode() === 0 ? 401 : 500;

            return response()->json(['error' => $message], $code);
        }
    }
}
