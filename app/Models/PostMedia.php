<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PostMedia
 *
 * @property int $id
 * @property int $post_id
 * @property string $file_name
 * @property string|null $file_type
 * @property string|null $file_size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post $post
 * @method static Builder|PostMedia newModelQuery()
 * @method static Builder|PostMedia newQuery()
 * @method static Builder|PostMedia query()
 * @method static Builder|PostMedia whereCreatedAt($value)
 * @method static Builder|PostMedia whereFileName($value)
 * @method static Builder|PostMedia whereFileSize($value)
 * @method static Builder|PostMedia whereFileType($value)
 * @method static Builder|PostMedia whereId($value)
 * @method static Builder|PostMedia wherePostId($value)
 * @method static Builder|PostMedia whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PostMedia extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
