<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Schedule::factory(5)->create();
        $start = strtotime('5:10:00');
        $end = strtotime('6:50:00');

        $timeList = [];
        // $timeList pattern
        // $timeList = [
        //     [
        //         'start' => '5:10:00',
        //         'end' => '6:50:00'
        //     ],
        //     [
        //         'start' => '7:00:00',
        //         'end' => '8:40:00'
        //     ],
        //     //  ...
        // ];

        for ($i = 0; $i < 9; $i++) {
            $start_time = date('H:i:s', $start);
            $end_time = date('H:i:s', $end);
            $timeList[] = [
                'start' => $start_time,
                'end' => $end_time
            ];
            $start = strtotime('+10 minutes', $end);
            $end = strtotime('+1 hour 40 minutes', $start);
        }

        foreach ($timeList as $index => $time) {
            Schedule::create([
                'seq' => $index+1,
                'start_time' => $time['start'],
                'end_time' => $time['end'],
            ]);
        }
    }
}
