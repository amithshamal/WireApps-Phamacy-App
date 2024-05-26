<?php

namespace App\Http\Controllers\Queue;

use App\Http\Controllers\Controller;
use App\Jobs\CustomerJob;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function setup()
    {
        echo 'php artisan make:job CustomerJob<br />';
        echo 'php artisan make:mail QueueMail<br />';
        echo 'php artisan queue:table<br />';
        echo 'php artisan migrate<br />';
        echo 'php artisan queue:work<br />';
    }

    public function dispatchJobs()
    {
        dispatch(new CustomerJob);
        // dispatch(new CustomerJob)->delay(now()->addMinute());

        dd("Queue send to db");
    }
}
