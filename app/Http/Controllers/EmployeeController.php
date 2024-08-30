<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Location;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::all();
        $locations = Location::all();
        return view('employee', compact('employees', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location_code' => 'required|max:5',
            'birth_date' => 'required|date',
        ]);

        Employee::create([
            'name' => $request->name,
            'location_code' => $request->location_code,
            'birth_date' => $request->birth_date,
        ]);

        return redirect('/')->with('success', 'Employee Added successfully.');
    }

    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();
        return redirect('/')->with('success', 'Employee deleted successfully.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location_code' => 'required|max:5',
            'birth_date' => 'required|date',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return redirect('/')->with('success', 'Employee updated successfully.');
    }

    public function search(Request $request){
        $locations = Location::all();
        if (!$request->has('age') || $request->input('age') == '') {
            $employees = Employee::all();
        } else {
            $request->validate([
                'age' => 'required|integer|min:0',
            ]);

            $age = $request->input('age');
            $cutoffDate = now()->subYears($age)->endOfDay(); // Menghitung tanggal batas maksimal

            $employees = Employee::whereDate('birth_date', '<=', $cutoffDate)
                ->where('location_code', 'JKT')
                ->get();
        }
        return view('employee', compact('employees', 'locations'));
    }
}
