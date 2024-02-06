<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $attendances = collect();

        if ($user->hasRole('director') && $user->kindergarten) {
            // If the user is a director and belongs to a kindergarten
            $groupIds = $user->kindergarten->groups->pluck('id');
            $attendances = Attendance::whereIn('group_id', $groupIds)->get();
        } elseif ($user->hasRole('teacher')) {
            // If the user is a teacher, retrieve attendances related to groups they are associated with
            $attendances = $user->groups()->with('attendances')->get()->pluck('attendances')->flatten();
        }

        // Return the view with attendance data
        return view('attendances.index', compact('attendances'));
    }

public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'kid_id' => 'required|exists:kids,id',
        'group_id' => 'required|exists:groups,id',
        'kindergarten_id' => 'required|exists:kindergartens,id', // Add validation for kindergarten_id
        'date' => 'required|date',
        'status' => 'required|boolean'
    ]);

    // Create a new attendance record
    $attendance = Attendance::create([
        'kid_id' => $request->kid_id,
        'group_id' => $request->group_id,
        'kindergarten_id' => $request->kindergarten_id, // Set the kindergarten_id
        'date' => $request->date,
        'status' => $request->status,
    ]);

    // Redirect to the index page with a success message
    return redirect()->route('attendances.index')->with('success', 'Attendance created successfully.');
}

    public function edit(Attendance $attendance)
    {
        // Return the view for editing an attendance
        return view('attendances.edit', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
{
    // Validate the request data
    $rules = [
        'status' => 'required|boolean',
    ];

    // If the user is a teacher, allow updating only the status field
    if (auth()->user()->hasRole('teacher')) {
        $rules['status'] = 'required|boolean'; // Allow only changing from 0 to 1
    }

    $request->validate($rules);

    // Update the attendance record with the allowed fields
    $attendance->update([
        'status' => $request->status,
    ]);

    // Redirect to the index page with a success message
    return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully.');
}


    // You can implement destroy method as per your requirements
}
