<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\DriverManger;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DriverMangerResource;
use Doctrine\DBAL\DriverManager;

class DriverManagerController extends Controller
{

    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $drivers = DriverManger::where(function ($q) use ($key) {
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('status', 'like', "%{$key}%")->orWhere('business_name', 'like', "%{$key}%");
        })
        ->withCount('user_created_by') // Eager load the user_created_by relationship and count
        ->latest()
        ->paginate($perPage);

        return DriverMangerResource::collection($drivers);
    }



    public function search(Request $request)
    {
        $terms = explode(" ", $request->input('search'));
        $perPage = $request->input('per_page', 10);

        $drivers = DriverManger::query();

        foreach ($terms as $term) {
            $drivers->where(function ($query) use ($term) {
                $query->orWhereHas('user', function ($userQuery) use ($term) {
                    $userQuery->where('email', 'like', "%$term%")
                        ->orWhere('phone_number', 'like', "%$term%")
                        ->orWhere('full_name', 'like', "%$term%");
                })
                ->orWhere('street', 'like', "%$term%")
                ->orWhere('have_motor', 'like', "%$term%")
                ->orWhere('type', 'like', "%$term%")
                ->orWhere('license_number', 'like', "%$term%")
                ->orWhere('nin_number', 'like', "%$term%")
                ->orWhere('status', 'like', "%$term%")
                ->orWhereHas('state', function ($stateQuery) use ($term) {
                    $stateQuery->where('name', 'like', "%$term%");
                });
            });
        }

        $drivers = $drivers->latest()->paginate($perPage);

        return DriverMangerResource::collection($drivers);
    }


    public function show($DriverId) {
        $Driver = DriverManger::find($DriverId);

        if (!$Driver) {

            return $this->error('', 'Driver not found', 422);

        }

        return new DriverMangerResource($Driver);
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $Driver = DriverManger::findOrFail($id);

            // Update Driver information
          //  $Driver->phone_number = $request->input('phone_number');
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

            return $this->success(new DriverMangerResource($user->Driver), 'Driver updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while updating the Driver and user.');
        }
    }


    public function destroy($driverID)
    {
        try {
            // Find the driver by ID
            $driver = DriverManger::with('user')->find($driverID);

        if (!$driver) {
                return $this->error('', 'driver not found', 404);
            }

            if ( $user = $driver->user) {
                $driver->delete();

                $user->delete();

            return $this->success([], 'driver and user deleted successfully');

        }
        } catch (\Exception $e) {
            return $this->error('', 'Unable to delete driver and user', 500);
        }
    }


    public function setStatus(Request $request, $driverID) {


        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string','in:Pending,Confirmed,Rejected,Failed'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $driver = DriverManger::find($driverID);

        if (!$driver) {

            return $this->error('', 'Agent not found', 422);

        }

        // Update the status
        $driver->status = $request->status;
        $driver->save();

        return $this->success(['driver'=> new DriverMangerResource($driver)], 'Driver status updated successfully');
    }
}
