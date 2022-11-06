<?php 

namespace App\Services;

use App\Models\User;
use App\Models\UserLogin;
use Exception;
use Illuminate\Support\Str;

class AuthenticationServices
{
    public function validate(array $payload)
    {
        $user = User::where('username', $payload['username'])->first();

        if (!$user) {
            abort(401, 'Unauthorized');
        }

        if (!password_verify($payload['password'], $user->password)) {
            abort(401, 'Unauthorized');
        }

        if ($this->isUserLoggedIn($user->id)) {
            abort(401, 'Unauthorized, Please Logout to Continue');
        }

        $token = $this->storeToLoginLog($user->id);

        return [
            'id' => $user->id,
            'name' => $user->name,
            'token' => $token
        ];
    }

    private function isUserLoggedIn(string $userId)
    {
        return UserLogin::where('user_id', $userId)->orderBy('created_at', 'desc')->first()?->is_login;
    }

    private function storeToLoginLog(string $id)
    {
        $loginLog = UserLogin::create([
            'id' => 'log' . Str::random(7),
            'user_id' => $id,
            'is_login' => true
        ]);

        if (!$loginLog) {
            throw new Exception('Internal Error');
        }

        return $loginLog->id;
    }

    public function logout(string $id)
    {
        $user = UserLogin::find($id);

        if (!$user) {
            abort(401, 'Unauthorized');
        }
        
        if (!$user->is_login) {
            abort(401, 'Unauthorized');
        }

        $user->update([
            'is_login' => false,
            'updated_at' => now()
        ]);
    }
}
