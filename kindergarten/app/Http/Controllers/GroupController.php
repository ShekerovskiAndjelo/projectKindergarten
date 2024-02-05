<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
{
    $user = auth()->user();

    if ($user->hasRole('director')) {
        // If the user is a director, retrieve all groups
        $groups = Group::all();
    } elseif ($user->hasRole('teacher')) {
        // If the user is a teacher, retrieve only groups associated with the teacher's ID
        $groups = Group::where('teacher_id', $user->id)->get();
    }

    // Return the view with groups data
    return view('groups.index', compact('groups'));
}

    public function create()
    {
        // Return the view for creating a group
        return view('groups.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'period' => 'required|string',
            'kindergarten_id' => 'required|exists:kindergartens,id',
            'teacher_id' => 'required|exists:users,id'
        ]);

        // Create a new group
        $group = Group::create($request->all());

        // Redirect to the index page with a success message
        return redirect()->route('groups.index')->with('success', 'Group created successfully.');
    }

    public function edit(Group $group)
{
    $user = auth()->user();

    if ($user->hasRole('director') || $user->id === $group->teacher_id) {
        // If the user is a director or the group's teacher, proceed with editing
        return view('groups.edit', compact('group'));
    } else {
        // Redirect the user back with an error message
        return redirect()->route('groups.index')->with('error', 'You are not authorized to edit this group.');
    }
}

public function update(Request $request, Group $group)
{
    // Validate the request data
    $rules = [
        'name' => 'required|string',
        'period' => 'required|string'
    ];

    // If the user is a director, allow updating the kindergarten_id and teacher_id
    if (auth()->user()->hasRole('director')) {
        $rules['kindergarten_id'] = 'required|exists:kindergartens,id';
        $rules['teacher_id'] = 'required|exists:users,id';
    }

    $request->validate($rules);

    // Update the group with the allowed fields
    $group->update($request->only(array_keys($rules)));

    // Redirect to the index page with a success message
    return redirect()->route('groups.index')->with('success', 'Group updated successfully.');
}

    public function destroy(Group $group)
    {
        // Delete the group
        $group->delete();

        // Redirect to the index page with a success message
        return redirect()->route('groups.index')->with('success', 'Group deleted successfully.');
    }

    public function restore($id)
    {
    // Find the soft-deleted group by its ID
    $group = Group::withTrashed()->findOrFail($id);

    // Restore the soft-deleted group
    $group->restore();

    // Redirect to the index page with a success message
    return redirect()->route('groups.index')->with('success', 'Group restored successfully.');
    }

}
