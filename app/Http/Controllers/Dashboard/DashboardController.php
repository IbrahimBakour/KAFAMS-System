
<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\KafaClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (Gate::allows('dashboard.view.parent'))  return $this->parent();
        if (Gate::allows('dashboard.view.teacher')) return $this->teacher();
        if (Gate::allows('dashboard.view.admin'))   return $this->admin($request);

        abort(403);
    }

    private function parent()
    {
        $profiles = Profile::with(['class.teacher'])
            ->where('parent_id', Auth::id())
            ->orderBy('tahap')->orderBy('standard')->get();

        return view('dashboard.parent', compact('profiles'));
    }

    private function teacher()
    {
        $classes = KafaClass::with(['profiles' => fn($q) => $q->orderBy('student_name')])
            ->where('teacher_id', Auth::id())
            ->orderBy('standard')->orderBy('name')->get();

        return view('dashboard.teacher', compact('classes'));
    }

    private function admin(Request $request)
    {
        $tahap    = $request->integer('tahap');
        $standard = $request->integer('standard');
        $classId  = $request->integer('class_id');

        $profiles = Profile::with(['class.teacher'])
            ->when($tahap, fn($q) => $q->where('tahap', $tahap))
            ->when($standard, fn($q) => $q->where('standard', $standard))
            ->when($classId, fn($q) => $q->where('class_id', $classId))
            ->orderBy('tahap')->orderBy('standard')->orderBy('student_name')
            ->paginate(12)->appends($request->query());

        $classes = KafaClass::when($tahap, fn($q) => $q->where('tahap', $tahap))
            ->when($standard, fn($q) => $q->where('standard', $standard))
            ->orderBy('standard')->orderBy('name')->get();

        $pendingCount = Profile::where('profile_status', 'PENDING')->count();

        return view('dashboard.admin', compact('profiles', 'classes', 'tahap', 'standard', 'classId', 'pendingCount'));
    }
}
