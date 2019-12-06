<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    /**
     * Use 'spatie/laravel-translatable'
     * to manage translatable attributes.
     */
    use HasTranslations;

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = ['name', 'slug'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Use the localized slug attribute to generate
     * URL's with the route() helper.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug'; // HasTranslations trait will automatically find the slug for the active locale
    }

    /**
     * Use a custom query to find the localized slug
     * when you access a localized route.
     *
     * @param mixed $value
     *
     * @return \Illuminate\Database\Eloquent\Model|void|null
     */
    public function resolveRouteBinding($value)
    {
        return $this->where('slug->'.app()->getLocale(), $value)->first() ?? abort(404);
    }
}
