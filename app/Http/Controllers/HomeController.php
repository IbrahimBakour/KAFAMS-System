<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->type == 'admin') {
              // Fetch the selected assessment type from the request, default to 'Midterm'
            $selectedType = $request->get('assessment_type', 'Peperiksaan Awal Tahun 2024');

            // Fetch results filtered by the selected assessment type
            $results = Result::where('assessment_type', $selectedType)->get();

            // Group results by assessment subject
            $subjects = $results->groupBy('assessment_subject');
            $subjectStats = [];

            // Calculate statistics for each subject
            foreach ($subjects as $subject => $subjectResults) {
                $marks = $subjectResults->pluck('marks');
                $subjectStats[$subject] = [
                    'highest' => $marks->max(),
                    'lowest' => $marks->min(),
                    'mean' => round($marks->average(), 2),
                ];
            }

            // Calculate the average marks for each subject
            $subjectAverages = [];
            foreach ($subjects as $subject => $subjectResults) {
                $averageMarks = $subjectResults->avg('marks'); // Average marks per subject
                $subjectAverages[$subject] = $averageMarks;
            }

            // Prepare data for the chart
            $labels = array_keys($subjectAverages); // Subjects for the X-axis
            $data = array_values($subjectAverages); // Average marks for the Y-axis

            // Fetch all assessment types for the dropdown menu
            $assessmentTypes = Result::select('assessment_type')->distinct()->pluck('assessment_type');

            return view('homeAdmin', compact('labels', 'data', 'subjectStats', 'assessmentTypes', 'selectedType'));
        } elseif ($user->type == 'student') {
           // Get the logged-in student's name
            $studentName = auth()->user()->name;

            // Fetch the results for this student, grouped by subject, ordered by assessment date
            $results = Result::where('student_name', $studentName)
                            ->get();

            // Group the results by subject
            $groupedResults = $results->groupBy('assessment_subject');

            $data = [];
            $labels = [];

            // Loop through each subject and get the last two assessments
            foreach ($groupedResults as $subject => $subjectResults) {
                // Get the latest two assessments for the subject
                $latestTwoAssessments = $subjectResults->take(2);

                // Check if we have two assessments, if not, fill in with zero or previous data
                if ($latestTwoAssessments->count() == 2) {
                    $marks = $latestTwoAssessments->pluck('marks')->toArray();
                    $assessmentTypes = $latestTwoAssessments->pluck('assessment_type')->toArray();
                } else {
                    $marks = [0, $latestTwoAssessments->first()->marks]; // If there's only one assessment
                    $assessmentTypes = [$latestTwoAssessments->first()->assessment_type, 'N/A'];
                }

                // Add data for the graph
                $data[] = $marks;
                $labels[] = $subject;
            }

            // Return the view with the data
            return view('homeStudent', compact('data', 'labels', 'assessmentTypes'));
        } elseif ($user->type == 'parent') {
            return view('homeParent');
        }
    }
}
