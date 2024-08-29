<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return view('location', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:5',
            'name' => 'required|max:255',
        ]);

        Location::create([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return redirect('/location');
    }

    public function destroy($id)
    {
        Location::findOrFail($id)->delete();
        return redirect('/location')->with('success', 'Location deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|max:5',
            'name' => 'required|string|max:255',
        ]);

        $location = Location::findOrFail($id);
        $location->update($request->all());

        return redirect('/location')->with('success', 'Location updated successfully.');
    }
}
