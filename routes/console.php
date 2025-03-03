<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Schedule::command('queue:work --timeout=900 --memory=512 --tries=5 --stop-when-empty')->runInBackground()->everyMinute();
Schedule::command('tokens:check-expired')->daily();