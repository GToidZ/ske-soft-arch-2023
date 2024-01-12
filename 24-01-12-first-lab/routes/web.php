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

Route::get('/userresults', function () {
    return dd(request()->old());
});

// TODO: File uploader
Route::get('/fileform', function () {
    return view('fileform');
});

Route::post('/fileform', function () {

    $validator = Validator::make(request()->all(), array(
        'myfile' => 'mimes:jpg,bmp,png'
    ));

    if ($validator->fails()) {
        return redirect('fileform')
            ->withErrors($validator)
            ->withInput();
    }

    /* Request#file() returns Symfony's UploadedFile.
    Request ref: https://laravel.com/api/10.x/Illuminate/Support/Facades/Request.html
    File#guessExtension() ref: https://github.com/symfony/symfony/blob/7.0/src/Symfony/Component/HttpFoundation/File/File.php#L53
    */
    $file = request()->file('myfile');
    $ext = $file->guessExtension();

    // File#move() ref: https://github.com/symfony/symfony/blob/7.0/src/Symfony/Component/HttpFoundation/File/File.php#L85
    if ($file->move('files', $file->getClientOriginalName() . '.' . uniqid() . '.' . $ext)) {
        return 'Success';
    }
    return 'Error';

});