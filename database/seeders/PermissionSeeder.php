<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Permission::findOrCreate('access-cms', config('cms.guard'));

        $this->createResourcePermissionsFor('admins');
        $this->createResourcePermissionsFor('settings');
        $this->createResourcePermissionsFor('static_pages');
        $this->createResourcePermissionsFor('components');
        $this->createResourcePermissionsFor('privacy_policies');
        $this->createResourcePermissionsFor('roles');
        $this->createResourcePermissionsFor('seo_metas');
        $this->createResourcePermissionsFor('departments');
        $this->createResourcePermissionsFor('schedules');
        $this->createResourcePermissionsFor('subjects');
        $this->createResourcePermissionsFor('subject_schedules');
        $this->createResourcePermissionsFor('buildings');

        Permission::where('name', 'cms.settings.create')
            ->orWhere('name', 'cms.settings.delete')
            ->delete();
    }

    /**
     * Create a set of resource permissions for the given resource string.
     *
     * @param string $resource
     *
     * @return void
     */
    public function createResourcePermissionsFor(string $resource): void
    {
        Permission::findOrCreate('cms.'.$resource.'.viewAny', config('cms.guard'));
        Permission::findOrCreate('cms.'.$resource.'.view', config('cms.guard'));
        Permission::findOrCreate('cms.'.$resource.'.create', config('cms.guard'));
        Permission::findOrCreate('cms.'.$resource.'.update', config('cms.guard'));
        Permission::findOrCreate('cms.'.$resource.'.delete', config('cms.guard'));
        Permission::findOrCreate('cms.'.$resource.'.restore', config('cms.guard'));
        Permission::findOrCreate('cms.'.$resource.'.forceDelete', config('cms.guard'));
    }
}
