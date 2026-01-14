<?php

namespace App\Http\Controllers;

use App\Models\Bulletins;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class BulletinController extends Controller
{
 public function index(Request $request)
{
    $user = auth()->user();

    $query = Bulletins::query();

    // FILTER CATEGORY
    if ($request->category && $request->category !== 'all') {
        $query->where('bulletin_category', $request->category);
    }

    // 🔥 FILTER VISIBILITY BASED ON ROLE
    if (in_array($user->type, ['student', 'parent'])) {
        // Student & Parent → APPROVED ONLY
        $query->where('status', 'approved');
    }

    if ($user->type === 'kafa_admin') {
    $query->where(function ($q) {
        // bulletins dibuat oleh KAFA admin → semua status
        $q->where('created_by', 'kafa_admin')
          // bulletins dibuat oleh MUIP admin → hanya approved
          ->orWhere(function ($q2) {
              $q2->where('created_by', 'muip_admin')
                 ->where('status', 'approved');
          });
    });
}


    

    // SORT
    if ($request->sort === 'date_asc') {
        $query->orderBy('created_at', 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $bulletins = $query->get();

    return view('bulletin.indexBulletin', compact('bulletins'));
}

public function reject($id)
{
    if (!auth()->check()) {
        $user = User::where('type', 'muip_admin')->first();
        auth()->login($user);
    }

    $user = auth()->user();

    if ($user->type !== 'muip_admin') {
        abort(403);
    }

    Bulletins::where('id', $id)->update([
        'status' => 'rejected'
    ]);

    return back()->with('success', 'Bulletin has been rejected');
}

public function indexTeacher(Request $request)
{
    $user = auth()->user();

    if ($user->type !== 'teacher') {
        abort(403);
    }

    $query = Bulletins::query();

    // FILTER CATEGORY
    if ($request->category && $request->category !== 'all') {
        $query->where('bulletin_category', $request->category);
    }

    // TEACHER → APPROVED ONLY
    $query->where('status', 'approved');

    // SORT
    if ($request->sort === 'oldest') {
        $query->orderBy('created_at', 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $bulletins = $query->get();

    return view('bulletin.indexBulletinTeacher', compact('bulletins', 'user'));
}


 public function indexAdmin(Request $request)
{
    $user = auth()->user();

    // ambil filter dari URL
    $category = $request->input('category', 'all');
    $sort = $request->input('sort', 'latest');

    $query = Bulletins::query();

    // 🔥 VISIBILITY UNTUK KAFA ADMIN
    if ($user->type === 'kafa_admin') {
        $query->where(function ($q) {
            // bulletin KAFA (pending + approved)
            $q->where('created_by', 'kafa_admin')

              // bulletin MUIP (approved sahaja)
              ->orWhere(function ($q2) {
                  $q2->where('created_by', 'muip_admin')
                     ->where('status', 'approved');
              });
        });
    }

    // 🔥 CATEGORY FILTER
    if ($category !== 'all') {
        $query->where('bulletin_category', $category);
    }

    // 🔥 SORT
    if ($sort === 'oldest') {
        $query->orderBy('created_at', 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $bulletins = $query->get();

    return view('bulletin.indexBulletinAdmin', compact('bulletins'));
}





public function approve($id)
{
    if (!auth()->check()) {
        $user = User::where('type', 'muip_admin')->first();
        auth()->login($user);
    }

    $user = auth()->user();

    if ($user->type !== 'muip_admin') {
        abort(403);
    }

    Bulletins::where('id', $id)->update(['status' => 'approved']);

    return back()->with('success', 'Successfully Approved the bulletins made by KAFA Admin');
}



public function indexMUIPAdmin(Request $request)
{
    // 🔥 Dev only: hardcode MUIP Admin login
    $user = User::firstOrCreate(
        ['type' => 'muip_admin'], // kalau takde, create satu user MUIP Admin dummy
        [
            'name' => 'MUIP Admin Dev',
            'email' => 'muipadmin@example.com',
            'password' => bcrypt('password'), // dummy password
        ]
    );

    auth()->login($user);

    $category = $request->input('category', 'all');
    $sort = $request->input('sort', 'latest');

    $query = Bulletins::query();

    // 🔥 CATEGORY FILTER
    if ($category !== 'all') {
        $query->where('bulletin_category', $category);
    }

    // 🔥 SORT
    if ($sort === 'oldest') {
        $query->orderBy('created_at', 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $bulletins = $query->get();

    return view('bulletin.indexBulletinMUIPAdmin', compact('bulletins'));
}


public function editMUIP($id)
{
    $bulletin = Bulletins::findOrFail($id);

    // optional safety
    if(auth()->user()->type !== 'muip_admin'){
        abort(403);
    }

    return view('bulletin.updateBulletinMUIP', compact('bulletin'));
}




 public function edit($id)
{
    $bulletin = Bulletins::findOrFail($id);

    $user = auth()->user();
    
    if ($user && $user->type === 'muip_admin') {
        return view('bulletin.updateBulletinMUIP', compact('bulletin'));
    }

    return view('bulletin.updateBulletin', compact('bulletin'));
}




 public function update(Request $request, $id)
{
    $bulletin = Bulletins::findOrFail($id);

    $data = $request->only([
        'bulletin_title',
        'bulletin_desc',
        'bulletin_category'
    ]);

    if ($request->bulletin_category === 'Events') {
    $data['event_date'] = $request->event_date;
    $data['event_time'] = $request->event_time;
}

if ($request->bulletin_category === 'Announcement') {
    $data['start_date'] = $request->start_date;
    $data['end_date'] = $request->end_date;
}

if ($request->bulletin_category === 'News') {
    $data['news_date'] = $request->news_date;
}


    // handle new image
    if ($request->hasFile('bulletin_image')) {
        $imageName = time().'.'.$request->bulletin_image->extension();
        $request->bulletin_image->move(public_path('images'), $imageName);
        $data['bulletin_image'] = $imageName;
    }

    // reset status jika KAFA edit
    if (auth()->user()->type === 'kafa_admin') {
        $data['status'] = 'pending';
    }

    $bulletin->update($data);

  if (auth()->user()->type === 'muip_admin') {
    return redirect()
        ->route('bulletin.indexMUIPAdmin')
        ->with('success', 'Bulletin updated successfully');
}

return redirect()
    ->route('bulletin.indexBulletinAdmin')
    ->with('success', 'Bulletin updated successfully');

}



    public function create()
    {
        return view('bulletin.createBulletin');
    }

    public function createMUIP()
{
    // 🔥 Dev only: hardcode MUIP Admin login
    $user = User::firstOrCreate(
        ['type' => 'muip_admin'],
        [
            'name' => 'MUIP Admin Dev',
            'email' => 'muipadmin@example.com',
            'password' => bcrypt('password'),
        ]
    );

    auth()->login($user);

    return view('bulletin.createBulletinMUIP');
}

public function store(Request $request)
{
    // 🔹 VALIDATE BERDASARKAN CATEGORY
    $rules = [
        'bulletin_title' => 'required',
        'bulletin_desc' => 'required',
        'bulletin_category' => 'required',
        'bulletin_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];

    if ($request->bulletin_category === 'Events') {
        $rules['event_date'] = 'required|date';
        $rules['event_time'] = 'nullable';
    }

    if ($request->bulletin_category === 'Announcement') {
        $rules['start_date'] = 'required|date';
        $rules['end_date'] = 'nullable|date|after_or_equal:start_date';
    }

    if ($request->bulletin_category === 'News') {
        $rules['news_date'] = 'required|date';
    }

    $validated = $request->validate($rules);

    // 🔹 HANDLE IMAGE
    $imageName = null;
    if ($request->hasFile('bulletin_image')) {
        $imageName = time().'.'.$request->bulletin_image->extension();
        $request->bulletin_image->move(public_path('images'), $imageName);
    }

    $user = auth()->user();

    $status = ($user->type === 'kafa_admin') ? 'pending' : 'approved';

    // 🔹 PREPARE DATA
    $data = [
        'bulletin_title' => $request->bulletin_title,
        'bulletin_desc' => $request->bulletin_desc,
        'bulletin_category' => $request->bulletin_category,
        'bulletin_image' => $imageName,
        'status' => $status,
        'created_by' => $user->type,
    ];

    if ($request->bulletin_category === 'Events') {
        $data['event_date'] = $request->event_date;
        $data['event_time'] = $request->event_time;
    }

    if ($request->bulletin_category === 'Announcement') {
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
    }

    if ($request->bulletin_category === 'News') {
        $data['news_date'] = $request->news_date;
    }

    Bulletins::create($data);

    // 🔹 REDIRECT BERDASARKAN USER TYPE
    if ($user->type === 'kafa_admin') {
        return redirect()->route('bulletin.indexBulletinAdmin')
                         ->with('success', 'Bulletin created and pending MUIP approval.');
    }

    return redirect()->route('bulletin.indexMUIPAdmin')
                     ->with('success', 'Bulletin created successfully.');
}


   public function destroy($id)
{
    $bulletin = Bulletins::find($id);

    // 🔥 optional: check user boleh delete bulletins ni
    if(auth()->user()->type === 'muip_admin' && $bulletin->created_by === 'kafa_admin'){
        return back()->with('error', 'You cannot delete KAFA Admin bulletins');
    }

    $bulletin->delete();

    // redirect ikut user type
    if(auth()->user()->type === 'muip_admin'){
        return redirect()->route('bulletin.indexMUIPAdmin')
                         ->with('success', 'Bulletin deleted successfully');
    } else {
        return redirect()->route('bulletin.indexBulletinAdmin')
                         ->with('success', 'Bulletin deleted successfully');
    }
}


}