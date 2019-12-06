<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Route;

class PostsController extends Controller
{
    public function show(Post $post, $slug = '')
    {
        if ($slug !== $post->slug) {
            return redirect()->route('posts.show', [$post->id, $post->slug], 301);
        }

        return view('posts.show', [
            'post' => $post,
            'urls' => [
                'current' => Route::currentUrl(),
                'en' => Route::currentUrl('en', [$post, $post->getSlug('en')]),
                'nl' => Route::currentUrl('nl', [$post, $post->getSlug('nl')]),
            ],
        ]);
    }
}
