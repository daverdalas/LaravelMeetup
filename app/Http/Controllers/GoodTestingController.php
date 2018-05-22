<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class GoodTestingController extends Controller
{
    /**
     * @var Guard
     */
    private $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function index()
    {
        $user = $this->auth->user();

        return response()->json(['user_name' => $user->name]);
    }
}
