<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'result',
        'value',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateUniqueToken($length = 40): array {
        do {
            $token = Str::random($length);
        } while (User::where('url_token', $token)->exists());
    
        return [
            'url_token' => $token,
            'url_token_expires_at' => now()->addMinutes(env('URL_TOKEN_EXPIRATION_TIME', 1440 * 7)),
        ];
    }
}