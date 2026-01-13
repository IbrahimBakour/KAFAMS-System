<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    // Display all activities
    public function index()
    {
        $activities = Activity::all();

        $activities->each(function ($activity) {
            $activity->level = rand(1, 5); // Generate a random level
        });
        
        return view('activity.index', compact('activities'));
    }

    // Show form to create a new activity
    public function create()
    {
        return view('activity.create');
    }

    // Store a newly created activity
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
        ]);

        Activity::create($request->all());

        return redirect()->route('activity.index')->with('success', 'Activity created successfully.');
    }

    public function show(Activity $quiz)
    {
        return view('activity.show', compact('quiz'));
    }

    public function edit(Activity $quiz)
    {
        return view('activity.edit', compact('quiz'));
    }

    public function destroy(Activity $quiz)
    {
        $quiz->delete();
        return redirect()->route('activity.index')->with('success', 'Activity deleted successfully.');
    }


    // Update an existing activity
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
        ]);

        $activity->update($request->all());

        return redirect()->route('activity.index')->with('success', 'Activity updated successfully.');
    }
}
