<?php

namespace App\Http\Controllers;

use App\Models\Kindergarten;
use Illuminate\Http\Request;

class KindergartenController extends Controller
{
    public function index()
    {
        // Fetch all kindergartens
        $kindergartens = Kindergarten::all();

        // Return the view with kindergartens data
        return view('kindergartens.index', compact('kindergartens'));
    }

    public function create()
    {
        // Return the view for creating a kindergarten
        return view('kindergartens.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'city' => 'required|string',
            'street' => 'required|string',
            'managed_by' => 'required|exists:users,id' // Assuming managed_by is the user_id of the director
        ]);

        // Create a new kindergarten
        $kindergarten = Kindergarten::create($request->all());

        // Redirect to the index page with a success message
        return redirect()->route('kindergartens.index')->with('success', 'Kindergarten created successfully.');
    }

    public function edit(Kindergarten $kindergarten)
    {
        // Return the view for editing a kindergarten
        return view('kindergartens.edit', compact('kindergarten'));
    }

    public function update(Request $request, Kindergarten $kindergarten)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'city' => 'required|string',
            'street' => 'required|string',
            'managed_by' => 'required|exists:users,id' // Assuming managed_by is the user_id of the director
        ]);

        // Update the kindergarten
        $kindergarten->update($request->all());

        // Redirect to the index page with a success message
        return redirect()->route('kindergartens.index')->with('success', 'Kindergarten updated successfully.');
    }

    public function destroy(Kindergarten $kindergarten)
    {
        // Soft delete the kindergarten
        $kindergarten->delete();

        // Redirect to the index page with a success message
        return redirect()->route('kindergartens.index')->with('success', 'Kindergarten deleted successfully.');
    }

    public function restore($id)
    {
        // Restore the soft deleted kindergarten
        $kindergarten = Kindergarten::withTrashed()->findOrFail($id);
        $kindergarten->restore();

        // Redirect to the index page with a success message
        return redirect()->route('kindergartens.index')->with('success', 'Kindergarten restored successfully.');
    }
}
