<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Page
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
 * @property-read Collection|PostMedia[] $medias
 * @property-read int|null $medias_count
 * @property-read User $user
 * @method static Builder|Page findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 * @method static Builder|Page whereCategoryId($value)
 * @method static Builder|Page whereCommentAble($value)
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereDescription($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page wherePostStatus($value)
 * @method static Builder|Page wherePostType($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereTitle($value)
 * @method static Builder|Page whereUpdatedAt($value)
 * @method static Builder|Page whereUserId($value)
 * @method static Builder|Page withUniqueSlugConstraints(Model $model, string $attribute, array $config, string $slug)
 * @mixin Eloquent
 */
class Page extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'posts';
    protected $guarded = [];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function medias()
    {
        return $this->hasMany(PostMedia::class, 'post_id', 'id');
    }
}
