<?php
namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search'); // Get the search query
        $user = Auth::user(); // Get the authenticated user

        // If the user is a student, only show their own results
        if ($user->type === 'student') {
            $results = Result::where('student_name', $user->name) // Filter by the logged-in student's name
                             ->when($search, function ($query, $search) {
                                 return $query->where('student_name', 'like', "%$search%")
                                              ->orWhere('student_class', 'like', "%$search%")
                                              ->orWhere('assessment_subject', 'like', "%$search%");
                             })->latest()->paginate(5);
        } else {
            // If the user is a teacher or admin, they can view all results
            $results = Result::when($search, function ($query, $search) {
                return $query->where('student_name', 'like', "%$search%")
                             ->orWhere('student_class', 'like', "%$search%")
                             ->orWhere('assessment_subject', 'like', "%$search%");
            })->latest()->paginate(5);
        }

        return view('results.index', compact('results', 'search'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('results.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'student_name' => 'required',
            'student_class' => 'required',
            'assessment_subject' => 'required',
            'assessment_type' => 'required',
            'marks' => 'required',
        ]);

        Result::create($request->all());

        return redirect()->route('results.index')
                        ->with('success', 'Result created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Result $result): View
    {
        $user = Auth::user();

        // If the user is a student, they should only be able to see their own result
        if ($user->type === 'student' && $result->student_name !== $user->name) {
            abort(403, 'Unauthorized action.'); // Deny access if the student tries to view another student's result
        }

        // If the user is an admin or teacher, allow viewing all results
        return view('results.show', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Result $result): View
    {
        return view('results.edit', compact('result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Result $result): RedirectResponse
    {
        $request->validate([
            'student_name' => 'required',
            'student_class' => 'required',
            'assessment_subject' => 'required',
            'assessment_type' => 'required',
            'marks' => 'required',
        ]);

        $result->update($request->all());

        return redirect()->route('results.index')
                        ->with('success', 'Result updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result): RedirectResponse
    {
        $result->delete();

        return redirect()->route('results.index')
                        ->with('success', 'Result deleted successfully.');
    }
}
