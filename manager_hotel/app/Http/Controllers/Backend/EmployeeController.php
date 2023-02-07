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
        // sao đường dẫn kp ghi rõ hết ra
        return Inertia::render('Admin/Employees/Index',[
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
        return Inertia::render('Admin/Employees/Create',[]);
    }

    public function store(Request $request)
    {
        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return Redirect::route('employees.index');
    }
}
