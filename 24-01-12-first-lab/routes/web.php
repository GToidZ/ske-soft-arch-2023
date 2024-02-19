<?php

use App\Libraries\Captcha;
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

// I'm not doing localized strings.
// See here, if you need: https://laravel.com/docs/10.x/localization

Route::get('/', function () {
    return "Hello!";
});

Route::get('/userform', function () {
    return view('userform');
});

Route::post('/userform', function () {

    // Create a validator for every input from request.
    $validator = Validator::make(
        request()->all(),
        array(
            // Validation rules
            'email' => 'required|email|different:username',
            'username' => 'required|min:6',
            'password' => 'required|same:password_confirm|min:8',
            'no_email' => 'prohibited' // Instead of creating your own honey_pot, use existing implementation.
        ),
        array(
            // Messages when error
            'min' => 'The :attribute is way too short! It must be at least :min character(s) in length.',
            'username.required' => 'Please specify your username.',
            'prohibited' => 'Nothing should be in this field.'
        )
    );

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

Route::get('/autocomplete', function () {
    return view('autocomplete');
});

Route::get('/getdata', function () {
    $term = strtolower(request()->input('term'));
    $data = array(
        'R' => 'Red',
        'O' => 'Orange',
        'Y' => 'Yellow',
        'G' => 'Green',
        'B' => 'Blue',
        'P' => 'Purple'
    );

    $return_arr = array();
    foreach ($data as $k => $v) {
        if (strpos(strtolower($v), $term) !== FALSE) {
            $return_arr[] = array('value' => $v, 'id' => $k);
        }
    }

    return response()->json($return_arr);
});

Route::get('/captcha', function () {
    $captcha = new Captcha;
    $capt = $captcha->make();
    return view('captcha')->with('capt', $capt);
});

Route::post('/captcha', function () {
    if (session()->get('answer') !== request()->input('captcha')) {
        return redirect('/captcha')
            ->with('captcha_result', 'Not match!');
    }
    return redirect('/captcha')
            ->with('captcha_result', 'Match!');
});