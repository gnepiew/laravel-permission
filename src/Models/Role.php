<?php

namespace Gnepiew\Permission\Models;

use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    /**
     * Find or create role by its name (and optionally guardName, title, description).
     *
     * @param string $name
     * @param string|null $guardName
     * @param string|null $title
     * @param string|null $description
     * @return RoleContract
     */
    public static function findOrCreate(string $name, $guardName = null, $title = null, $description = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = static::where('name', $name)->where('guard_name', $guardName)->first();

        if (! $role) {
            return static::query()->create([
                'name' => $name,
                'guard_name' => $guardName,
                'title' => $title ?? $name,
                'description' => $description
            ]);
        }

        return $role;
    }
}
