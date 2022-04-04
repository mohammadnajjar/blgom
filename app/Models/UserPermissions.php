<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserPermissions
 *
 * @property int $user_id
 * @property int $permission_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permission
 * @property-read int|null $permission_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermissions whereUserId($value)
 * @mixin \Eloquent
 */
class UserPermissions extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'id', 'permission_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'id', 'user_id');
    }

}
