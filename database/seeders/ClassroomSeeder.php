<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Classroom;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $buildingIds = Building::pluck('id')->toArray();

        foreach ($buildingIds as $buildingId) {
            Classroom::factory(5)->create([
                'building_id' => $buildingId,
            ]);
        }
    }
}
