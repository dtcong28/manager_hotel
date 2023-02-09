<?php

namespace App\Http\Controllers\Backend;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class EmployeeController extends BackendController
{
    public function index()
    {
        return Inertia::render('Admin/Employees/Index', [
            'employees' => Employee::all()->map(function ($employees) {
                return [
                    'id' => $employees->id,
                    'name' => $employees->name,
                    'email' => $employees->email,
                ];
            })
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Employees/Create', []);
    }

    public function store(Request $request)
    {
        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return Redirect::route('employees.index');
    }

    public function edit(Employee $employee)
    {
        return Inertia::render('Admin/Employees/Edit', [
            'employee' => $employee
        ]);
    }

    public function update(Employee $employee)
    {
       // dd(json_decode(Request()->all('name')));
        $employee->update([
            'name' => request()->all()["name"],
            'email' => request()->all()["email"],
        ]);

        return Redirect::route('employees.index');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return Redirect::route('employees.index');
    }
}
