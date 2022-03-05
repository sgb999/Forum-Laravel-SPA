<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class Index extends Controller
{
    public static function index()
    {
        $page_title = "Assassins Creed Forum - Home";
        return inertia('home');
    }
}
