<?php

use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\Queue\QueueController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('send-mail', [MailController::class, 'sendTestEmail']);

//Queue
Route::prefix('queues')->group(function () {
    Route::get('queue-jobs', [QueueController::class, 'dispatchJobs']);
    Route::get('setup', [QueueController::class, 'setup']);
});
