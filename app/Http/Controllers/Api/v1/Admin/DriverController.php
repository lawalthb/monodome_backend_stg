<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{

    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $drivers = Driver::where(function ($q) use ($key) {
            // Assuming there's a relationship between Driver and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('status', 'like', "%{$key}%")->orWhere('have_motor', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return DriverResource::collection($drivers);
    }


    public function search(Request $request)
    {
        $terms = explode(" ", $request->input('search'));
        $perPage = $request->input('per_page', 10);

        $drivers = Driver::query();

        foreach ($terms as $term) {
            $drivers->where(function ($query) use ($term) {
                $query->orWhereHas('user', function ($userQuery) use ($term) {
                    $userQuery->where('email', 'like', "%$term%")
                        ->orWhere('full_name', 'like', "%$term%");
                })
                ->orWhere('street', 'like', "%$term%")
                ->orWhere('have_motor', 'like', "%$term%")
                ->orWhere('type', 'like', "%$term%")
                ->orWhere('status', 'like', "%$term%")
                ->orWhereHas('state', function ($stateQuery) use ($term) {
                    $stateQuery->where('name', 'like', "%$term%");
                });
            });
        }

        $drivers = $drivers->latest()->paginate($perPage);

        return DriverResource::collection($drivers);
    }



//     public function search(Request $request)
// {
//     $perPage = $request->input('per_page', 10);

//     $drivers = Driver::query();

//     // Filter by have_motor
//     $haveMotor = $request->input('have_motor');
//     if ($haveMotor !== null) {
//         $drivers->where('have_motor', $haveMotor);
//     }

//     // Filter by type
//     $type = $request->input('type');
//     if ($type) {
//         $drivers->where('type', 'like', "%$type%");
//     }

//     // Filter by street
//     $street = $request->input('street');
//     if ($street) {
//         $drivers->where('street', 'like', "%$street%");
//     }

//     $drivers = $drivers->latest()->paginate($perPage);

//     return DriverResource::collection($drivers);
// }


    public function show($DriverId) {
        $Driver = Driver::find($DriverId);

        if (!$Driver) {

            return $this->error('', 'Driver not found', 422);

        }

        return new DriverResource($Driver);
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $Driver = Driver::findOrFail($id);

            // Update Driver information
            $Driver->phone_number = $request->input('phone_number');
            $Driver->street = $request->input('address');
            $Driver->save();

            // Update Driver information
            if ($Driver->user) {
                // If the user has an associated Driver, update its information
            $user = $Driver->user;
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->address = $request->input('address');
            $user->phone_number = $request->input('phone_number');
            $user->save();

            }

            DB::commit();

            return $this->success(new DriverResource($user->Driver), 'Driver updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while updating the Driver and user.');
        }
    }


    public function destroy($driverID) {
        // Find the user by ID
            $driver = Driver::find($driverID);

        if (!$driver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

       return $user = $driver->user;
        if ($user) {
            $user->delete();
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }


    public function setStatus(Request $request, $driverID) {


        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string','in:Pending,Confirmed,Rejected,Failed'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $driver = Driver::find($driverID);

        if (!$driver) {

            return $this->error('', 'Agent not found', 422);

        }

        // Update the status
        $driver->status = $request->status;
        $driver->save();

        return $this->success(['driver'=> new DriverResource($driver)], 'Driver status updated successfully');
    }
}
