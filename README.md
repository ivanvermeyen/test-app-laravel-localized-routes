# Test App for Laravel Localized Routes

This is a basic Laravel 6 implementation of the [`codezero/laravel-localized-routes`](https://github.com/codezero-be/laravel-localized-routes) repo
in combination with the popular [`spatie/laravel-translatable`](https://github.com/spatie/laravel-translatable) package.

[![ko-fi](https://www.ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/R6R3UQ8V)

## ⚙️ Getting Started

```bash
git clone git@github.com:ivanvermeyen/test-app-laravel-localized-routes.git
cd test-app-laravel-localized-routes
cp .env.example .env
cp phpunit.xml.dist phpunit.xml
composer install
php artisan key:generate
```

## 🧨 Run Tests

In this repo there are some demo routes, controllers and models.
I have written tests to ensure that those are functioning as intended.

```bash
composer test
```

Before running tests, you will need to edit `phpunit.xml` with your local MySQL credentials.

```xml
<server name="DB_DATABASE" value="localized_routes"/>
<server name="DB_USERNAME" value="root"/>
<server name="DB_PASSWORD" value=""/>
```

⚠️ You can not use an in memory SQLite database, because that won't support the JSON queries for the translatable models.

## 👀 Look at the Code

I'm trying to keep the [commit history](https://github.com/ivanvermeyen/test-app-laravel-localized-routes/commits/master) as clean as possible,
so you can easily see what I have added to achieve certain functionality.

This is mostly:

- routes in `routes/web.php`
- controllers in `app/Http/Controllers/`
- views in `resources/views`
- models in `app/`
- migrations in `database/migrations/`
- tests in `tests/`

## 📖 Examples

#### ☑️ Categories with localized slug

For this example I have setup a `Category` model with a localized slug, stored in the database.
Querying the database for a localized value is taken care of by the `HasTranslation` trait, provided by `spatie/laravel-translatable`.

The `resolveRouteBinding()` method in the model ensures that the slug matches the locale.
This will only work with route model binding (if you type hint the model in the controller)
and if the slug is stored in the database (we need to run a query).

The `getRouteKeyName()` method in the model makes sure that the `route()` helper uses the `slug` attribute as the route parameter.
The `HasTranslation` trait does the work to get the right translation.

**This will work:**

- /en/categories/category-english
- /nl/categories/category-dutch

**This will result in a `404` not found error:**

- /en/categories/category-dutch
- /nl/categories/category-english

Since the `slug` is the route key, we can just call `Route::localizedUrl($locale)` to get a localized URL for the current route.

#### ☑️ Posts with ID and automatic localized slug

A cool pattern you see on many sites is that URL's contain a unique ID and a descriptive slug.

```
https://example.com/posts/1234/the-title-of-the-post
```

I like this, because even if we change the title of the post, we can still make the link work.

For this example I've created a `Post` model with a route and controller.
It looks for the post by its ID using Laravel's default behavior when type hinting our model in the controller.
Then we perform a quick check if the provided slug matches the slug in the current locale.
If not, we can redirect with the correct slug.

In this model, the slug is computed from the title on the fly, so it doesn't have to be stored in the database.

The `getSlugAttribute()` method is optional. It's just a nice shortcut to get the slug in the current locale
with `$post->slug` instead of `$post->getSlug()`.

When using the `route()` helper, you will need to provide both ID and slug parameters.
Laravel will find the ID from any model instance automatically, but it does't have a clue about the slug.
So you need to be explicit about the slug:

```php
$url = route('posts.show', [$post, $post->slug]);
```

**So in short, these URL's:**

- /en/posts/1
- /en/posts/1/post-in-dutch

**Will redirect to** /en/posts/1/post-in-english

**And these URL's:**

- /nl/posts/1
- /nl/posts/1/post-in-english

**Will redirect to** /nl/posts/1/post-in-dutch

Since the `id` is the route key, Laravel has no way to know what the localized slug should be.
To use the `Route::localizedUrl($locale)` macro in full-auto (without manually passing through the parameters)
I implemented the `\CodeZero\LocalizedRoutes\ProvidesRouteParameters` interface and added this method to the `Post` model:

```php
public function getRouteParameters($locale = null)
{
    return [$this->id, $this->getSlug($locale)];
}
```

Behind the scenes, the macro will see the interface and call the method to get the right parameters for the URL. 

## ☕️ Credits

- [Ivan Vermeyen](https://byterider.io)
- [All contributors](../../contributors)

## 🔓 Security

If you discover any security related issues, please [e-mail me](mailto:ivan@codezero.be) instead of using the issue tracker.

## 📜 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
