<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        return response()->json(['data' => EmployeeResource::collection($employees)], 200);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return response()->json(['data' => new EmployeeResource($employee)], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required|string',
            'full_name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'department' => 'required|string',
            'status' => 'required|in:Pending,Confirmed,Approved,Rejected,Failed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $employee = Employee::create($request->all());

        return response()->json(['data' => new EmployeeResource($employee)], 201);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'uuid' => 'required|string',
            'full_name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'department' => 'required|string',
            'status' => 'required|in:Pending,Confirmed,Approved,Rejected,Failed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $employee->update($request->all());

        return response()->json(['data' => new EmployeeResource($employee)], 200);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully'], 200);
    }
}
