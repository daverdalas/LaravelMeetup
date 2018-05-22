<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BadTestingController extends Controller
{
    public function index()
    {
        $user = \Auth::user();

        return response()->json(['user_name' => $user->name]);
    }
}
