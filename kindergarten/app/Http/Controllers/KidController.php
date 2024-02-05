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

        // Retrieve only kids associated with the parent_id
        $kids = Kid::where('parent_id', $parent_id)->get();

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
            'generated_number_id' => 'required|exists:generated_numbers,id',
        ]);

        $kid = Kid::create([
            'name' => $request->name,
            'age' => $request->age,
            'generated_number_id' => $request->generated_number_id,
            'parent_id' => auth()->user()->id, // Set parent_id to the authenticated user's id
        ]);

        // Update the status of the associated generated number
        $generatedNumber = GeneratedNumber::findOrFail($request->generated_number_id);
        $generatedNumber->update(['status' => 1]);

        return redirect()->route('kids.index')->with('success', 'Kid created successfully.');
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
            'generated_number_id' => 'required|exists:generated_numbers,id',
        ]);

        $kid->update([
            'name' => $request->name,
            'age' => $request->age,
            'generated_number_id' => $request->generated_number_id,
        ]);

        return redirect()->route('kids.index')->with('success', 'Kid updated successfully.');
    }

    public function destroy(Kid $kid)
    {
        $kid->delete();

        return redirect()->route('kids.index')->with('success', 'Kid deleted successfully.');
    }
}
