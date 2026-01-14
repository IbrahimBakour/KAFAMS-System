
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// CHANGED: Use PascalCase model import to match class name.
// If your model class is named `profile` (lowercase), strongly consider renaming it to `Profile`.
use App\Models\Profile;

class profileController extends Controller
{
    // NEW: Protect every action by requiring login
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Admin/Teacher list (Perfective: role separation handled via Dashboard; index remains for admin/teacher)
    public function index()
    {
        // NEW: Authorization (Adaptive: enforce least privilege)
        $this->authorize('index', Profile::class);

        // CHANGED: Ensure we query the correct Model class
        $profiles = Profile::paginate(10);

        // CHANGED: `profile.update` should be a view you control; consider `profile.index`
        return view('profile.update', ['profiles' => $profiles]);
    }

    // Parent self-view (kept; logic improved)
    public function index2()
    {
        $userId = Auth::id();
        if (!$userId) {
            // NOTE: Typically use 'login' route; keeping your 'register' redirect as-is
            return redirect()->route('register');
        }

        // CHANGED: This assumes profile PK equals userId. If not, you should use `Profile::where('parent_id',$userId)->first()`
        $profile = Profile::find($userId);
        if (!$profile) {
            return redirect()->route('profile.create');
        }

        return view('profile.view', ['profile' => $profile]);
    }

    public function view($id)
    {
        $profile = Profile::find($id);

        // NEW: Authorize viewing this specific profile
        $this->authorize('view', $profile);

        return view('profile.view', compact('profile'));
    }

    public function show($id)
    {
        $profile = Profile::find($id);

        // NEW: Authorize viewing
        $this->authorize('view', $profile);

        return view('profile.show', compact('profile'));
    }

    public function create()
    {
        // NEW: Authorize creation (Parent/Admin)
        $this->authorize('create', Profile::class);

        return view('profile.create');
    }

    public function store(Request $request)
    {
        // NEW: Authorize creation
        $this->authorize('create', Profile::class);

        $request->validate([
            'student_name' => 'required|string',
            'gender'       => 'required|string',
            'address'      => 'required|string',
            'parent_name'  => 'required|string',
            'contact_no'   => 'required|numeric',
        ]);

        // CHANGED: Use correct Model class & fix request arrow spacing
        $profile = new Profile();
        $profile->student_name = $request->input('student_name');
        $profile->gender       = $request->input('gender');
        $profile->address      = $request->input('address');
        $profile->parent_name  = $request->input('parent_name');
        $profile->contact_no   = $request->input('contact_no');

        // NEW: Set parent ownership (Adaptive: role-aware data)
        $profile->parent_id    = Auth::id() ?? null;

        // Optional: approval workflow
        // $profile->profile_status = 'PENDING';

        $profile->save();

        return redirect(route('profile.view', ['id' => $profile->id]));
    }

    public function edit($id)
    {
        // CHANGED: Use correct Model class
        $profile = Profile::findOrFail($id);

        // NEW: Authorize update
        $this->authorize('update', $profile);

        return view('profile.edit', ['profile' => $profile]);
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        // NEW: Authorize update
        $this->authorize('update', $profile);

        $request->validate([
            'student_name' => 'required|string',
            'gender'       => 'required|string',
            'address'      => 'required|string',
            'parent_name'  => 'required|string',
            'contact_no'   => 'required|numeric',
        ]);

        $profile->update([
            'student_name' => $request->input('student_name'),
            'gender'       => $request->input('gender'),
            'address'      => $request->input('address'),
            'parent_name'  => $request->input('parent_name'),
            'contact_no'   => $request->input('contact_no'),
        ]);

        return redirect(route('profile.view', ['id' => $profile->id]));
    }

    public function destroy($id)
    {
        // CHANGED: Use correct Model class
        $profile = Profile::findOrFail($id);

        // NEW: Authorize delete (Admin/MUIP only)
        $this->authorize('delete', $profile);

        $profile->delete();

        return redirect()->route('profile.index')->with('success', 'Profile deleted successfully.');
    }
}
