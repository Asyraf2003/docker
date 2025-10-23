<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:other']);
    }

    public function index()
    {
        return view('other.dashboard');
    }
}
