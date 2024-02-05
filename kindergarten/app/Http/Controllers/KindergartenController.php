<?php

namespace App\Http\Controllers;

use App\Models\Kindergarten;
use App\Models\User;
use Illuminate\Http\Request;

class KindergartenController extends Controller
{
    public function index()
    {
        // Fetch all kindergartens
        $kindergartens = Kindergarten::withTrashed()->paginate(10);

        // Return the view with kindergartens data
        return view('kindergartens.index', compact('kindergartens'));
    }

    public function create()
{
    // Retrieve only users with the role 'director'
    $directors = User::where('role', 'director')->get();

    return view('kindergartens.create', compact('directors'));
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




    // Create a new kindergarten with the director's ID associated
    Kindergarten::create([
        'name' => $request->name,
        'city' => $request->city,
        'street' => $request->street,
        'managed_by' => $request->managed_by // Assuming managed_by is the user_id of the director
    ]);



    // Redirect to the index page with a success message
    return redirect()->route('kindergartens.index')->with('success', 'Kindergarten created successfully.');
}

    public function edit(Kindergarten $kindergarten)
    {
        // Retrieve only users with the role 'director'
        $directors = User::where('role', 'director')->get();

        // Return the view for editing a kindergarten
        return view('kindergartens.edit', compact('kindergarten', 'directors'));
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
