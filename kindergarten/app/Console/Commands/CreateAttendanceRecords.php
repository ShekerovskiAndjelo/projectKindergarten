<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Group;
use App\Models\Kid;
use App\Models\Attendance;
use App\Models\Kindergarten;

class CreateAttendanceRecords extends Command
{
    protected $signature = 'attendance:create';
    protected $description = 'Create attendance records for kids associated with groups';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
{
    // Get the next weekday (Monday to Friday)
    $nextWeekday = Carbon::now()->nextWeekday();

    // Fetch all kindergartens
    $kindergartens = Kindergarten::all();

    foreach ($kindergartens as $kindergarten) {
        // Fetch all groups associated with the kindergarten
        $groups = $kindergarten->groups;

        foreach ($groups as $group) {
            // Fetch kids associated with the group
            $kids = $group->kids()->whereNotNull('group_id')->get();

            foreach ($kids as $kid) {
                // Skip weekends
                if ($nextWeekday->isWeekend()) {
                    $nextWeekday->next(Carbon::MONDAY);
                }

                // Check if attendance record already exists for the kid and the next weekday
                $existingAttendance = Attendance::where('kid_id', $kid->id)
                    ->whereDate('date', $nextWeekday)
                    ->first();

                if (!$existingAttendance) {
                    // Create a new attendance record
                    $attendance = new Attendance();
                    $attendance->kid_id = $kid->id;
                    $attendance->group_id = $group->id;
                    $attendance->kindergarten_id = $kindergarten->id;
                    $attendance->date = $nextWeekday;
                    $attendance->status = 0; // Default status
                    $attendance->save();
                }
            }
        }
    }

    $this->info('Attendance records created successfully.');
}

}

