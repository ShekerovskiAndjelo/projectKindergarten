<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
{
    $user = auth()->user();

    if ($user->hasRole('teacher')) {
        // If the user is a teacher, fetch attendances related to groups they are associated with
        $attendances = $user->groups()->with('attendances')->get()->pluck('attendances')->flatten();
    } else {
        // For other roles, fetch all attendances
        $attendances = Attendance::all();
    }

    // Return the view with attendance data
    return view('attendances.index', compact('attendances'));
}

    public function create()
    {
        // Return the view for creating an attendance
        return view('attendances.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'group_id' => 'required|exists:groups,id',
            'kindergarten_id' => 'required|exists:kindergartens,id',
            'date' => 'required|date',
            'status' => 'required|boolean'
        ]);

        // Create a new attendance record
        $attendance = Attendance::create($request->all());

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
        'kid_id' => 'required|exists:kids,id',
        'group_id' => 'required|exists:groups,id',
        'kindergarten_id' => 'required|exists:kindergartens,id',
        'date' => 'required|date',
    ];

    // If the user is a teacher, allow updating only the status field
    if (auth()->user()->hasRole('teacher')) {
        $rules['status'] = 'required|boolean|in:1'; // Allow only changing from 0 to 1
    } else {
        $rules['status'] = 'required|boolean';
    }

    $request->validate($rules);

    // Update the attendance record with the allowed fields
    $attendance->update($request->only(array_keys($rules)));

    // Redirect to the index page with a success message
    return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully.');
}

    // You can implement destroy method as per your requirements
}
