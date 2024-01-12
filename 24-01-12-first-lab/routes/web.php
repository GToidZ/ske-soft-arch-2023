<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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
    return "Hello!";
});

Route::get('/userform', function () {
    return view('userform');
});

Route::post('/userform', function () {

    // Create a validator for every input from request.
    $validator = Validator::make(request()->all(), array(
        'email' => 'required|email|different:username',
        'username' => 'required|min:6',
        'password' => 'required|same:password_confirm|min:8'
    ));

    if ($validator->fails()) {
        return redirect('userform')
            ->withErrors($validator)
            ->withInput();
    }

    return redirect('userresults')
        ->withInput();

});

Route::get('userresults', function () {
    return dd(request()->old());
});

// TODO: File uploader