<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignbale
     *
     * @var array<string>
     */
    protected $fillable = [
        'title', 'content', 'category_id', 'user_id', 'status', 'slug', 'views', 'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['category', 'user'];

    /**
     * Count number of views
     *
     * @return void
     */
    public function views()
    {
        $this->views += 1;
        $this->save();
    }

    /**
     * The relation with category modal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The relation with user modal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The relation with tag modal
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function tags(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
