<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mindscms\Entrust\EntrustPermission;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property string|null $route
 * @property string|null $module
 * @property string|null $as
 * @property string|null $icon
 * @property Permission|null $parent
 * @property int $parent_show
 * @property int $parent_original
 * @property int $sidebar_link
 * @property int $appear
 * @property int $ordering
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Permission[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereAppear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereAs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereParentOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereParentShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereSidebarLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends EntrustPermission
{
    use HasFactory;
    protected $guarded = [];

    public function parent()
    {
        return $this->hasOne(Permission::class, 'id', 'parent');
    }

    public function children()
    {
        return $this->hasMany(Permission::class, 'parent', 'id');
    }

    public static function tree( $level = 1 )
    {
        return static::with(implode('.', array_fill(0, $level, 'children')))
            ->whereParent(0)
            ->whereAppear(1)
            ->whereSidebarLink(1)
            ->orderBy('ordering', 'asc')
            ->get();
    }

}
