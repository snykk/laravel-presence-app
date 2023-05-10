<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departmentIds = Department::pluck('id')->toArray();

        foreach ($departmentIds as $departmentId) {
            Subject::factory(5)->create([
                'department_id' => $departmentId,
            ]);
        }
    }
}
