<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function kafa(Request $request)
{
    return $this->index($request);
}

public function muip(Request $request)
{
    return $this->index($request);
}

public function parent(Request $request)
{
    return $this->index($request);
}

public function teacher(Request $request)
{
    return $this->index($request);
}


    public function index(Request $request)
    {
        $user = Auth::user();

        switch ($user->type) {

    case 'muip_admin':
        return $this->adminDashboard($request, 'homeMuip');

    case 'kafa_admin':
        return $this->adminDashboard($request);

    case 'teacher':
        return $this->teacherDashboard($request); // 👈 TAMBAH INI

    case 'parent':
        return $this->studentDashboard($request);

    default:
        abort(403, 'Unauthorized role');
}



    }

    // ================= ADMIN DASHBOARD =================
   protected function adminDashboard(Request $request, $view = 'homeAdmin')
{
    $selectedType = $request->get('assessment_type', 'Peperiksaan Awal Tahun 2024');

    $results = Result::where('assessment_type', $selectedType)->get();
    $subjects = $results->groupBy('assessment_subject');

    $subjectStats = [];
    foreach ($subjects as $subject => $subjectResults) {
        $marks = $subjectResults->pluck('marks');
        $subjectStats[$subject] = [
            'highest' => $marks->max(),
            'lowest' => $marks->min(),
            'mean' => round($marks->average(), 2),
        ];
    }

    $subjectAverages = [];
    foreach ($subjects as $subject => $subjectResults) {
        $subjectAverages[$subject] = $subjectResults->avg('marks');
    }

    $labels = array_keys($subjectAverages);
    $data = array_values($subjectAverages);
    $assessmentTypes = Result::select('assessment_type')->distinct()->pluck('assessment_type');

    return view($view, compact(
        'labels',
        'data',
        'subjectStats',
        'assessmentTypes',
        'selectedType'
    ));
}

    // ================= STUDENT DASHBOARD =================
    protected function studentDashboard()
    {
        $studentName = auth()->user()->name;
        $results = Result::where('student_name', $studentName)->get();
        $groupedResults = $results->groupBy('assessment_subject');

        $data = [];
        $labels = [];
        $assessmentTypes = [];

        foreach ($groupedResults as $subject => $subjectResults) {
            $latestTwoAssessments = $subjectResults->take(2);

            if ($latestTwoAssessments->count() == 2) {
                $marks = $latestTwoAssessments->pluck('marks')->toArray();
                $assessmentTypes = $latestTwoAssessments->pluck('assessment_type')->toArray();
            } else {
                $marks = [0, $latestTwoAssessments->first()->marks ?? 0];
                $assessmentTypes = [$latestTwoAssessments->first()->assessment_type ?? 'N/A', 'N/A'];
            }

            $data[] = $marks;
            $labels[] = $subject;
        }

        return view('homeStudent', compact('data', 'labels', 'assessmentTypes'));
    }

    // ================= TEACHER DASHBOARD =================


protected function teacherDashboard(Request $request)
{
    $results = Result::all();
    $groupedResults = $results->groupBy('assessment_subject');

    $data = [];
    $labels = [];
    $assessmentTypes = [];

    foreach ($groupedResults as $subject => $subjectResults) {
        $latestTwo = $subjectResults->sortByDesc('created_at')->take(2);

        if ($latestTwo->count() == 2) {
            $marks = $latestTwo->pluck('marks')->toArray();
            $assessmentTypes = $latestTwo->pluck('assessment_type')->toArray();
        } else {
            $marks = [0, $latestTwo->first()->marks ?? 0];
            $assessmentTypes = [$latestTwo->first()->assessment_type ?? 'N/A', 'N/A'];
        }

        $data[] = $marks;
        $labels[] = $subject;
    }

    return view('homeTeacher', compact('data', 'labels', 'assessmentTypes'));
}


}
