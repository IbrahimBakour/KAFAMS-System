<?php

namespace App\Http\Controllers;

use App\Models\Bulletins;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class BulletinController extends Controller
{
    public function index(Request $request)
{
    // Start the query
    $query = Bulletins::query();

    // Get the category from the request
    $category = $request->input('category', 'all');

    // Apply filtering based on the category
    if ($category != 'all') {
        $query->where('bulletin_category', $category);
    }

    // Apply sorting logic
    if ($request->has('sort')) {
        if ($request->sort == 'date_asc') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
    } else {
        // Default sorting if no sort parameter is provided
        $query->orderBy('created_at', 'desc');
    }

    // Execute the query and get the results
    $bulletins = $query->get();

    // Return the view with the bulletins and category
    return view('bulletin.indexBulletin', compact('bulletins', 'category'));
}

    public function indexAdmin(Request $request)
    {
        $category = $request->input('category', 'all');

        if ($category == 'all') {
            $bulletins = Bulletins::all();
        } else {
            $bulletins = Bulletins::where('bulletin_category', $category)->get();
        }

        return view('bulletin.indexBulletinAdmin', compact('bulletins', 'category'));
    }

    public function edit($id)
    {
        $bulletin = Bulletins::find($id);
        return view('bulletin.updateBulletin', compact('bulletin'));
    }

    public function update(Request $request, $id)
    {
        $bulletin = Bulletins::find($id);
        $bulletin->update($request->all());

        return redirect()->route('bulletin.indexBulletinAdmin')->with('success', 'Bulletin updated successfully');
    }

    public function create()
    {
        return view('bulletin.createBulletin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulletin_title' => 'required|string|max:255',
            'bulletin_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bulletin_desc' => 'required|string',
            'bulletin_category' => 'required|string|max:255',
        ]);

        $imageName = time() . '.' . $request->bulletin_image->extension();
        $request->bulletin_image->move(public_path('images'), $imageName);

        Bulletins::create([
            'bulletin_title' => $request->bulletin_title,
            'bulletin_image' => $imageName,
            'bulletin_desc' => $request->bulletin_desc,
            'bulletin_category' => $request->bulletin_category,
        ]);

        return redirect()->route('bulletin.createBulletin')
            ->with('success', 'Bulletin created successfully.');
    }

    public function destroy($id)
    {
        $bulletin = Bulletins::find($id);
        $bulletin->delete();

        return redirect()->route('bulletin.indexBulletinAdmin')->with('success', 'Bulletin deleted successfully');
    }

}