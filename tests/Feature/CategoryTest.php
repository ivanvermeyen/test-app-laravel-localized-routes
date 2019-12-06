<?php

namespace Tests\Feature;

use App\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function you_can_only_access_a_localized_route_in_the_right_language()
    {
        $category = Category::create([
            'name' => ['en' => 'Category English', 'nl' => 'Category Dutch'],
            'slug' => ['en' => 'category-english', 'nl' => 'category-dutch'],
        ]);

        $response = $this->get('/en/categories/category-english');
        $response->assertOk();
        $response->assertSee($category->getTranslation('name', 'en'));
        $this->assertTrue($response->viewData('category')->is($category));

        $response = $this->get('/nl/categories/category-english');
        $response->assertNotFound();

        $response = $this->get('/nl/categories/category-dutch');
        $response->assertOk();
        $response->assertSee($category->getTranslation('name', 'nl'));
        $this->assertTrue($response->viewData('category')->is($category));

        $response = $this->get('/en/categories/category-dutch');
        $response->assertNotFound();
    }

    /** @test */
    public function you_can_generate_a_localized_route_url()
    {
        $category = Category::create([
            'name' => ['en' => 'Category English', 'nl' => 'Category Dutch'],
            'slug' => ['en' => 'category-english', 'nl' => 'category-dutch'],
        ]);

        App::setLocale('nl');

        $this->assertEquals('/nl/categories/category-dutch', route('categories.show', [$category], false));
        $this->assertEquals('/en/categories/category-english', route('categories.show', [$category], false, 'en'));
        $this->assertEquals('/nl/categories/category-dutch', route('categories.show', [$category], false, 'nl'));
    }

    /** @test */
    public function you_can_generate_alternate_localized_urls_for_the_current_route()
    {
        $host = Config::get('app.url');

        App::setLocale('en');

        Category::create([
            'name' => ['en' => 'Category English', 'nl' => 'Category Dutch'],
            'slug' => ['en' => 'category-english', 'nl' => 'category-dutch'],
        ]);

        $response = $this->get('/en/categories/category-english');

        $this->assertEquals([
            'current' => $host.'/en/categories/category-english',
            'en' => $host.'/en/categories/category-english',
            'nl' => $host.'/nl/categories/category-dutch',
        ], $response->viewData('urls'));
    }
}
