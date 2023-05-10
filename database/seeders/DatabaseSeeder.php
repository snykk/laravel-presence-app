<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SeoMetaSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(StaticPageSeeder::class);

        $this->call(ComponentSeeder::class);
        $this->call(PrivacyPolicySeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(ScheduleSeeder::class);
    }
}
