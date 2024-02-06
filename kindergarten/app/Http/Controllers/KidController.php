<?php

namespace App\Http\Controllers;

use App\Models\Kid;
use App\Models\GeneratedNumber;
use Illuminate\Http\Request;

class KidController extends Controller
{
    public function index()
{
    // Get the authenticated user's parent_id
    $parent_id = auth()->user()->id;

    // Retrieve all kids associated with the parent_id, including trashed ones
    $kids = Kid::where('parent_id', $parent_id)->withTrashed()->get();

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
        $numbers = GeneratedNumber::where('status', 0)->get();
        return view('kids.edit', compact('kid', 'numbers'));
    }

    public function update(Request $request, Kid $kid)
    {
        $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer|min:1',
        ]);

        $kid->update([
            'name' => $request->name,
            'age' => $request->age,
        ]);

        return redirect()->route('kids.index')->with('success', 'Kid updated successfully.');
    }


}
