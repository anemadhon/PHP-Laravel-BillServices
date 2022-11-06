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
                'id' => $userAuthenticated['id'],
                'name' => $userAuthenticated['name'],
                'status' => 'authenticated'
            ]]);
        } catch (\Throwable $th) {
            $message = (int) $th->getCode() === 401 ? 401 : ($th->getCode() > 500 || $th->getCode() < 200 ? 'Internal Error' : $th->getMessage());
            $code = (int) $th->getCode() === 401 ? 401 : ((int) $th->getCode() > 500 || (int) $th->getCode() < 200 ? 500 : (int) $th->getCode());

            return response()->json(['error' => $message], $code);
        }
    }

    public function logout(string $id, AuthenticationServices $authentication)
    {
        try {
            $authentication->logout($id);

            return response()->json(status: 204);
        } catch (\Throwable $th) {
            $message = (int) $th->getCode() === 401 ? 401 : ($th->getCode() > 500 || $th->getCode() < 200 ? 'Internal Error' : $th->getMessage());
            $code = (int) $th->getCode() === 401 ? 401 : ((int) $th->getCode() > 500 || (int) $th->getCode() < 200 ? 500 : (int) $th->getCode());

            return response()->json(['error' => $message], $code);
        }
    }
}
