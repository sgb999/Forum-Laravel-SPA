<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TempoarayFile;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return inertia('categories', compact(['categories']));
    }
}
