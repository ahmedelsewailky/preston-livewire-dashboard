<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name', 'slug'
    ];

    /**
     * The attributes that are avaialble for translate
     *
     * @var array<string>
     */
    public $translatable = ['name'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function($category) {
            return $category->slug = str($category->name)->slug();
        });
    }

    /**
     * Relation with posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }
}
