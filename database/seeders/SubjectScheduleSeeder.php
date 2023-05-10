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
        $subjectIds = Subject::pluck('id')->toArray();
        $scheduleIds = Schedule::pluck('id')->toArray();

        foreach ($subjectIds as $subjectId) {
            foreach ($scheduleIds as $scheduleId) {
                SubjectSchedule::create([
                    'subject_id' => $subjectId,
                    'schedule_id' => $scheduleId,
                ]);
            }
        }
    }
}
