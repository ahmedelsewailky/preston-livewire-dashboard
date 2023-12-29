<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['name', 'slug'];

    /**
     * The attributes that are avaialble for translate
     *
     * @var array<string>
     */
    protected $translatable = ['name'];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function($tag) {
            return $tag->slug = str($tag->name)->slug();
        });
    }
}
