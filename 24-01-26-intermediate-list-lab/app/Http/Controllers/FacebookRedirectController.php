<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookRedirectController extends Controller {
    
    protected function __construct() {
        $this->middleware('auth');
    }

    public function handleLogin(Request $req) {

    }
    
}