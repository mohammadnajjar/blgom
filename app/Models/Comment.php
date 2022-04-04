<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $url
 * @property string $ip_address
 * @property string $comment
 * @property int $comment_status
 * @property int $post_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post $post
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @method static Builder|Comment whereComment($value)
 * @method static Builder|Comment whereCommentStatus($value)
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereEmail($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereIpAddress($value)
 * @method static Builder|Comment whereName($value)
 * @method static Builder|Comment wherePostId($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 * @method static Builder|Comment whereUrl($value)
 * @method static Builder|Comment whereUserId($value)
 * @mixin Eloquent
 */
class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
