<?php

namespace App\Http\Controllers;

use App\Models\GeneratedNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GeneratedNumberController extends Controller
{
    public function index()
    {
        $numbers = GeneratedNumber::paginate(10);
        return view('generated_numbers.index', compact('numbers'));
    }

    public function store(Request $request)
    {
        // Validate the request data as needed
        $request->validate([
            'number' => 'required|numeric|unique:generated_numbers,number',
            'status' => 'required|boolean',
        ]);

        // Create a new generated number
        GeneratedNumber::create($request->only('number', 'status'));

        return redirect()->route('generated_numbers.index')->with('success', 'Number created successfully.');
    }

    public function storeRandomNumbers()
    {
        // Generate and store random numbers
        $existingNumbers = GeneratedNumber::pluck('number')->toArray();
        $count = 0;
        while ($count < 50) {
            $randomNumber = mt_rand(10000, 99999); // Generate a random number
            if (!in_array($randomNumber, $existingNumbers)) {
                // Store the number if it's unique
                GeneratedNumber::create([
                    'number' => $randomNumber,
                    'status' => 0, // Assuming default status is active
                ]);
                $existingNumbers[] = $randomNumber; // Add the number to the existing numbers array
                $count++;
            }
        }

        return redirect()->route('generated_numbers.index')->with('success', '50 random numbers stored successfully.');
    }
}
