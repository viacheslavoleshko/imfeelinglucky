<?php

namespace App\UseCases\Services;

use App\Models\User;
use App\Models\Result;
use Illuminate\Support\Facades\DB;

class TokenService
{
    public function regenerate(string $token): array
    {
        $newToken = DB::transaction(function () use ($token): array {
            $user = User::where('url_token', $token)->first();
            $newToken = Result::generateUniqueToken();

            $user->update([
                'url_token' => $newToken['url_token'],
                'url_token_expires_at' => $newToken['url_token_expires_at'],
            ]);
            return $newToken;
        });

        return $newToken;
    }

    public function delete(string $token): void
    {
        DB::transaction(function () use ($token): void {
            $user = User::where('url_token', $token)->first();
            $user->update([
                'url_token' => null,
                'url_token_expires_at' => null,
            ]);
        });
    }
}