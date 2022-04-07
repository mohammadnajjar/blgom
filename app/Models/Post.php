<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $post_type
 * @property int $post_status
 * @property int $comment_able
 * @property int $user_id
 * @property int $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category $category
 * @property-read Collection|Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read Collection|PostMedia[] $media
 * @property-read int|null $media_count
 * @property-read User $user
 * @method static Builder|Post findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @method static Builder|Post whereCategoryId($value)
 * @method static Builder|Post whereCommentAble($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereDescription($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post wherePostStatus($value)
 * @method static Builder|Post wherePostType($value)
 * @method static Builder|Post whereSlug($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static Builder|Post whereUserId($value)
 * @method static Builder|Post withUniqueSlugConstraints(Model $model, string $attribute, array $config, string $slug)
 * @mixin Eloquent
 */
class Post extends Model
{
    use HasFactory, Sluggable;
    use SearchableTrait;

    protected $guarded = [];
    protected $searchable = [
        'columns' => [
            'posts.title' => 10,
            'posts.description' => 10,
        ],
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('post_status', 1);
    }

    public function scopePost($query)
    {
        return $query->where('post_type', 'post');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function approved_comments()
    {
        return $this->hasMany(Comment::class)->whereCommentStatus(1);
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class);
    }
}
