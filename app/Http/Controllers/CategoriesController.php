<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Facades\Route;

class CategoriesController extends Controller
{
    public function show(Category $category)
    {
        return view('categories.show', [
            'category' => $category,
            'urls' => [
                'current' => Route::currentUrl(),
                'en' => Route::currentUrl('en'),
                'nl' => Route::currentUrl('nl'),
            ],
        ]);
    }
}
