<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories(Category $category)
    {
        return Inertia::render('Posts/Categories', [
            'posts' => $category->posts,
            'category' => $category->name,
            'image_url' =>  asset('/storage/'),
        ]);
    }
}
