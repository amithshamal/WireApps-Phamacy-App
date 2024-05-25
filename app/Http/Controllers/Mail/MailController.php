<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendTestEmail()
    {
        $details = [
            'title' => 'test mail title',
            'body' => 'This is for testing email using smtp'
        ];
    
        Mail::to('receiver_email@gmail.com')->send(new TestMail($details));
    
        dd("Email is Sent.");
    }
}
