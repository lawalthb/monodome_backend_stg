<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendLoginNotificationJob;
use App\Http\Resources\EmployeeResource;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);


        $employees = Employee::latest()
            ->paginate($perPage);

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
            'full_name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string|unique:employees,phone_number',
            'email' => 'required|email|unique:employees,email',
            'department' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $employee = Employee::create($request->all());

        return response()->json(['data' => new EmployeeResource($employee)], 201);
    }


    public function search(Request $request)
    {
        // Get query parameters from the request
        $sort = $request->input('sort');
        $email = $request->input('email');
        $fullName = $request->input('full_name');
        $department = $request->input('department');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $date = $request->input('date');

        // Apply filters to the Employee query
        $employee = Employee::query();

        // Filter by 'sort' parameter
        if ($sort) {
            $employee->orderBy($sort);
        }

        // Filter by 'email' parameter
        if ($email) {
            $employee->where('email', 'like', "%$email%");
        }

        // Filter by 'full_name' parameter
        if ($fullName) {
            $employee->where('full_name', 'like', "%$fullName%");
        }

        // Filter by 'department' parameter
        if ($department) {
            $employee->where('department', 'like', "%$department%");
        }

        // Filter by 'status' parameter
        if ($status) {
            $employee->where('status', $status);
        }

        // Filter by 'date' parameter (created_at date)
        if ($date) {
            $employee->whereDate('created_at', $date);
        }

        // Filter by date range
        if ($startDate) {
            $employee->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $employee->whereDate('created_at', '<=', $endDate);
        }

        $perPage = $request->input('per_page', 10);

        // Retrieve and paginate the results
        $employee = $employee->latest()->paginate($perPage);

        return EmployeeResource::collection($employee);
    }


    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validator = Validator::make($request->all(), [
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


        if ($employee->user) {
            $employee->user->syncPermissions([]);
            $employee->user->delete();
            $employee->user->save();
        }

        $employee->delete();
        $employee->save();

        return response()->json(['message' => 'Employee deleted successfully'], 200);
    }


    public function status(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Pending,Confirmed,Approved,Rejected,Failed',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->status = $request->status;

        if ($employee->save()) {

            return response()->json(['message' => 'Employee status update successfully'], 200);
        } else {

            return response()->json(['message' => 'Unable to update Employee status'], 404);
        }
    }


    public function makeAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "emp_id" => 'required|integer|exists:employees,id',
            'permission_ids' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $employee = Employee::findOrFail($request->emp_id);

        // Check if the email already exists
        $existingUser = User::where('email', $employee->email)->first();
        if ($existingUser) {
            return $this->error('', 'Email address already exists', 422);
        }

        $password = Str::random(10);

        // Hash the password for storage
        $hashedPassword = Hash::make($password);

        $user = new User([
            'full_name' => $employee->full_name,
            'email' => $employee->email,
            'address' => $employee->address,
            'phone_number' => $employee->phone_number,
            'password' => $hashedPassword,
            'ref_by' => auth()->user()->id,
            'referral_code' => generateReferralCode(),
            'role_id' => 2,
            'user_agent' => $request->header('User-Agent'),
        ]);

        $permissions = Permission::whereIn('id', $request->permission_ids)->get();
        $user->syncPermissions($permissions);
        $user->save();

        $employee->user_id =  $user->id;
        $employee->save();

        $message = "You are now an admin at " . config('app.name') . ". Thank you for registering with " . config('app.name');
        dispatch(new SendLoginNotificationJob($user, $message));

        $data = [
            "full_name" => $employee->full_name,
            "password" => $password,
            "message" => "",
        ];

        Mail::to($user->email)->send(
            new SendPasswordMail($data)
        );

        return $this->success(
            [
                "user" => new UserResource($user),
            ],
            "Admin registered successfully"
        );
    }



    public function removeAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "emp_id" => 'required|integer|exists:employees,id',
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $employee = Employee::findOrFail($request->emp_id);

        // Check if employee has a related user
        if ($employee->user) {
            // Remove all permissions from the user
            $employee->user->syncPermissions([]);
            $employee->user->delete();
            $employee->user->save();
        }

        return $this->success(
            [
                "user" => new UserResource($employee->user),
            ],
            "Admin registered successfully"
        );
    }

    public function removePermissions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "emp_id" => 'required|integer|exists:employees,id',
            'permission_ids' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $employee = Employee::findOrFail($request->emp_id);

        // Check if employee has a related user
        if ($employee->user) {
            // Remove specific permissions from the user
            $permissionsToRemove = Permission::whereIn('id', $request->permission_ids)->get();
            $employee->user->revokePermissionTo($permissionsToRemove);

            // Save the updated user record
            $employee->user->save();
        }

        return $this->success(
            [
                "user" => new UserResource($employee->user),
            ],
            "Permissions removed successfully"
        );
    }
}
