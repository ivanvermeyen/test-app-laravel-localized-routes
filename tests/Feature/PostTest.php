<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_looks_up_the_id_and_redirects_if_the_slug_does_not_match_the_locale()
    {
        $post = Post::create([
            'title' => ['en' => 'Post in English', 'nl' => 'Post in Dutch'],
        ]);

        $this->get("/en/posts/{$post->id}")->assertRedirect("/en/posts/{$post->id}/post-in-english");
        $this->get("/en/posts/{$post->id}/post-in-dutch")->assertRedirect("/en/posts/{$post->id}/post-in-english");
        $this->get("/en/posts/{$post->id}/post-in-english")->assertOk();

        $this->get("/nl/posts/{$post->id}")->assertRedirect("/nl/posts/{$post->id}/post-in-dutch");
        $this->get("/nl/posts/{$post->id}/post-in-english")->assertRedirect("/nl/posts/{$post->id}/post-in-dutch");
        $this->get("/nl/posts/{$post->id}/post-in-dutch")->assertOk();
    }

    /** @test */
    public function you_can_generate_a_localized_route_url()
    {
        $post = Post::create([
            'title' => ['en' => 'Post in English', 'nl' => 'Post in Dutch'],
        ]);

        App::setLocale('nl');

        $this->assertEquals("/nl/posts/{$post->id}/post-in-dutch", route('posts.show', [$post, $post->slug], false));
        $this->assertEquals("/en/posts/{$post->id}/post-in-english", route('posts.show', [$post, $post->getSlug('en') ], false, 'en'));
        $this->assertEquals("/nl/posts/{$post->id}/post-in-dutch", route('posts.show', [$post, $post->getSlug('nl')], false, 'nl'));
    }

    /** @test */
    public function you_can_generate_alternate_localized_urls_for_the_current_route()
    {
        $host = Config::get('app.url');

        App::setLocale('en');

        $post = Post::create([
            'title' => ['en' => 'Post in English', 'nl' => 'Post in Dutch'],
        ]);

        $response = $this->get("/en/posts/{$post->id}/post-in-english");

        $this->assertEquals([
            'current' => "{$host}/en/posts/{$post->id}/post-in-english",
            'en' => "{$host}/en/posts/{$post->id}/post-in-english",
            'nl' => "{$host}/nl/posts/{$post->id}/post-in-dutch",
        ], $response->viewData('urls'));
    }
}
