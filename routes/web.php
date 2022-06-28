<?php

use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // \Illuminate\Support\Facades\Mail::send(new \App\Mail\Email());
    \Illuminate\Support\Facades\Notification::send(\App\Models\User::all(), new \App\Notifications\emailsent());
    return view('welcome');
});

Route::get('sendbasicemail', [MailController::class, 'basic_email']);

// Route::get('send-mail', function () {
//     $details = [
//     'title' => 'Mail from ItSolutionStuff.com',
//     'body' => 'This is for testing email using smtp'
//     ];
//     Mail::to('rafaelfernandez677@gmail.com')->send(new \App\Mail\TestMail($details));
//     dd("Email is Sent.");
// });
