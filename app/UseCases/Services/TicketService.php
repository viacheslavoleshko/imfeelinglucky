<?php

namespace App\UseCases\Services;

use App\Models\User;
use App\Models\Result;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TicketService
{
    public function imfeelinglucky(string $token): Result
    {
        $result = DB::transaction(function () use ($token): Result {
            $user = User::where('url_token', $token)->first();
            $value = random_int(1, 1000);

            if ($value % 2 === 0) {
                $result = [       
                    'user_id' => $user->id,
                    'result' => true,
                    'value' => $value
                ];

                switch ($value)
                {
                    case $value > 900:
                        $result['amount'] = round($value * 0.9, 2);
                        break;
                    case $value > 600:
                        $result['amount'] = round($value * 0.5, 2);
                        break;
                    case $value > 300:
                        $result['amount'] = round($value * 0.3, 2);
                        break;
                    case $value <= 300:
                        $result['amount'] = round($value * 0.1, 2);
                        break;
                    default:
                        $result['amount'] = 0;
                }
                    
            } else {
                $result = [
                    'user_id' => $user->id,
                    'result' => false,
                    'value' => $value,
                    'amount' => 0
                ];
            }
            
            $result = Result::create($result);

            return $result;
        });

        return $result;
    }

    public function history(string $token): Collection
    {
        $lastResults = DB::transaction(function () use ($token) {
            $user = User::where('url_token', $token)->first();
            $results = $user->results()->latest()->limit(3)->get();

            return $results;
        });

        return $lastResults;
    }
}