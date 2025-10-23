<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function twoFactor(Request $request)
    {
        return view('security.2fa', ['user' => $request->user()]);
    }
}
