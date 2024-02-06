<?php

namespace App\Http\Controllers;

use App\Models\Kid;
use App\Models\GeneratedNumber;
use App\Models\Group;
use Illuminate\Http\Request;

class KidController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $kids = [];

    if ($user->hasRole('director')) {
        // If the user is a director, retrieve all kids, including trashed ones
        $kids = Kid::withTrashed()->get();
    } else {
        // If the user is not a director, retrieve only kids associated with the parent_id
        $parent_id = $user->id;
        $kids = Kid::where('parent_id', $parent_id)->withTrashed()->get();
    }

    return view('kids.index', compact('kids'));
}


    public function create()
    {
        $numbers = GeneratedNumber::where('status', 0)->get();
        return view('kids.create', compact('numbers'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'age' => 'required|integer|min:1',
        'generated_number' => 'required|exists:generated_numbers,number,status,0',
    ]);

    // Find the generated number by its number
    $generatedNumber = GeneratedNumber::where('number', $request->generated_number)
                                       ->where('status', 0)
                                       ->first();

    // If the generated number exists, create the kid
    if ($generatedNumber) {
        $kid = Kid::create([
            'name' => $request->name,
            'age' => $request->age,
            'generated_number_id' => $generatedNumber->id,
            'parent_id' => auth()->user()->id,
        ]);

        // Update the status of the associated generated number
        $generatedNumber->update(['status' => 1]);

        return redirect()->route('kids.index')->with('success', 'Kid created successfully.');
    } else {
        // If the generated number doesn't exist or has already been used, return back with an error message
        return back()->withErrors(['generated_number' => 'The provided generated number is invalid or has already been used.'])->withInput();
    }
}


public function edit(Kid $kid)
{
    $user = auth()->user();

    // Check if the user is a director
    if ($user->hasRole('director')) {
        // Retrieve numbers for directors to assign groups
        $numbers = GeneratedNumber::where('status', 0)->get();
        $groups = Group::all(); // Retrieve all groups
        return view('kids.edit', compact('kid', 'numbers', 'groups'));
    } elseif ($user->id === $kid->parent_id) {
        // Check if the user is the parent of the kid
        return view('kids.edit', compact('kid'));
    } else {
        // If neither director nor parent, unauthorized to edit
        return redirect()->route('kids.index')->with('error', 'You are not authorized to edit this kid.');
    }
}

public function update(Request $request, Kid $kid)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string',
        'age' => 'required|integer|min:1',
    ]);

    $user = auth()->user();

    // Check if the user is a director
    if ($user->hasRole('director')) {
        // Update the kid's information including group_id
        $kid->update([
            'name' => $request->name,
            'age' => $request->age,
            'group_id' => $request->group_id,
        ]);
    } elseif ($user->id === $kid->parent_id) {
        // If the user is the parent, update name and age only
        $kid->update([
            'name' => $request->name,
            'age' => $request->age,
        ]);
    } else {
        // If the user is neither director nor parent, unauthorized to update
        return redirect()->route('kids.index')->with('error', 'You are not authorized to update this kid.');
    }

    return redirect()->route('kids.index')->with('success', 'Kid updated successfully.');
}




}
