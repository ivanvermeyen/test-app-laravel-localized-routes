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

## 🚏 The `Route::currentUrl()` Macro

I have temporarily added a macro in `app/Providers/AppServiceProvider.php`
that can be used to very easily generate alternate localized URL's for the current route.
This is something I'm still working on, but this might be added to `codezero/laravel-localized-routes` in the future.
You will also find tests in this app for this feature.

## 📖 Examples

## ☕️ Credits

- [Ivan Vermeyen](https://byterider.io)
- [All contributors](../../contributors)

## 🔓 Security

If you discover any security related issues, please [e-mail me](mailto:ivan@codezero.be) instead of using the issue tracker.

## 📜 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
