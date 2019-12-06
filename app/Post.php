<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Post extends Model
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
    public $translatable = ['title'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the slug based on the translated title.
     *
     * @param string|null $locale
     *
     * @return string
     */
    public function getSlug($locale = null)
    {
        return Str::slug(
            $this->getTranslation('title', $locale ?? App::getLocale())
        );
    }

    /**
     * Get the computed slug attribute.
     *
     * @return string
     */
    protected function getSlugAttribute()
    {
        return $this->getSlug();
    }
}
