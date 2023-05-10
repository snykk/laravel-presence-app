<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Subject;
use App\Models\SubjectSchedule;
use Illuminate\Database\Seeder;

class SubjectScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classIndexs = ['A', 'B', 'C'];
        $subjectIds = Subject::pluck('id')->toArray();
        $scheduleIds = Schedule::pluck('id')->toArray();

        foreach($subjectIds as $subjectId) {
            foreach($classIndexs as $classIndex) {
                SubjectSchedule::create([
                    'subject_id' => $subjectId,
                    'class_index' => $classIndex,
                    'schedule_id' => $scheduleIds[random_int(0, count($scheduleIds)-1)],
                ]);
            }
        }
    }
}
