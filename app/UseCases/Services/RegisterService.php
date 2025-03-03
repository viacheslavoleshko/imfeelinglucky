<?php

namespace App\UseCases\Services;


use App\Models\User;

use App\Models\Result;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RegisterRequest;

class RegisterService
{
    public function register(RegisterRequest $request): User
    {
        $createdUser = DB::transaction(function () use ($request): User {
            $token = Result::generateUniqueToken();

            $user = User::create([
                'username' => $request->username, 
                'phonenumber' => $request->phonenumber, 
                'password' => $request->password, 
                'url_token' => $token['url_token'],
                'url_token_expires_at' => $token['url_token_expires_at'],
            ]);
            return $user;
        });

        return $createdUser;
    }
}
