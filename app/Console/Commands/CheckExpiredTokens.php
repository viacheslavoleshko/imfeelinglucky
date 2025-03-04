<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Jobs\ProcessExpiredToken;

class CheckExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $expiredTokens = User::where('url_token_expires_at', '<', now())->get();

        foreach ($expiredTokens as $token) {
            ProcessExpiredToken::dispatch($token);
        }
    }
}
