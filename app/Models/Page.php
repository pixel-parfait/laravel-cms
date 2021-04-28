<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Page extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'index', 'cover_id', 'draft',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title', 'slug', 'content',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'url',
    ];

    /**
     * Get the page's URL.
     */
    public function getUrlAttribute()
    {
        return config('app.url') .'/'. $this->slug;
    }

    /**
     * Get the cover for the page.
     */
    public function cover()
    {
        return $this->belongsTo(Media::class, 'cover_id');
    }

    /**
     * Scope a query to only include published pages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('draft', 0);
    }

    /**
     * Scope a query to only include a given index.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $index
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByIndex($query, $index)
    {
        return $query->where('index', $index);
    }
}

class PageTranslation extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'content',
    ];
}
