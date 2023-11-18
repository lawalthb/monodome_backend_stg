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
use App\Models\Broker;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{

    use ApiStatusTrait,FileUploadTrait;
    public function index(Request $request)
    {

        $terms = explode(" ", $request->input('search'));

        $perPage = $request->input('per_page', 10);

        $driver = Driver::query();

        foreach ($terms as $term) {
            $driver->where(function ($query) use ($term) {
                $query->orWhereHas('user', function ($userQuery) use ($term) {
                    $userQuery->where('email', 'like', "%$term%")
                        ->orWhere('full_name', 'like', "%$term%");
                })
                ->orWhere('nin_number', 'like', "%$term%")
                ->orWhere('license_number', 'like', "%$term%")
                ->orWhere('have_motor', 'like', "%$term%")
                ->orWhere('type', 'like', "%$term%")
              //  ->orWhere('status', 'like', "%$term%")
                ->orWhereHas('state', function ($stateQuery) use ($term) {
                    $stateQuery->where('name', 'like', "%$term%");
                });
            });
        }

        $driver = $driver->where('status','Confirmed')->latest()->paginate($perPage);

        return DriverResource::collection($driver);
    }



    public function pending(Request $request){

        $perPage = $request->input('per_page', 10);

       $driver = Driver::query();


       $driver = $driver->whereIn('status', ['Pending','Rejected'])->latest()->paginate($perPage);

       return DriverResource::collection($driver);
   }

    // public function search(Request $request)
    // {
    //     $terms = explode(" ", $request->input('search'));
    //     $perPage = $request->input('per_page', 10);

    //     $drivers = Driver::query();

    //     foreach ($terms as $term) {
    //         $drivers->where(function ($query) use ($term) {
    //             $query->orWhereHas('user', function ($userQuery) use ($term) {
    //                 $userQuery->where('email', 'like', "%$term%")
    //                     ->orWhere('phone_number', 'like', "%$term%")
    //                     ->orWhere('full_name', 'like', "%$term%");
    //             })
    //             ->orWhere('street', 'like', "%$term%")
    //             ->orWhere('have_motor', 'like', "%$term%")
    //             ->orWhere('type', 'like', "%$term%")
    //             ->orWhere('license_number', 'like', "%$term%")
    //             ->orWhere('nin_number', 'like', "%$term%")
    //             ->orWhere('status', 'like', "%$term%")
    //             ->orWhereHas('state', function ($stateQuery) use ($term) {
    //                 $stateQuery->where('name', 'like', "%$term%");
    //             });
    //         });
    //     }

    //     $drivers = $drivers->latest()->paginate($perPage);

    //     return DriverResource::collection($drivers);
    // }


    public function search(Request $request)
{
    // Get query parameters from the request
    $sort = $request->input('sort');
    $email = $request->input('email');
    $businessName = $request->input('business_name');
    $license_number = $request->input('license_number');
    $nin_number = $request->input('nin_number');
    $have_motor = $request->input('have_motor');
    $type = $request->input('type');
    $status = $request->input('status');
    $fullName = $request->input('full_name');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $date = $request->input('date');

    // Apply filters to the Agent query
    $driver = Driver::query();

    // Filter by 'sort' parameter
    if ($sort) {
        $driver->orderBy($sort);
    }

    // Filter by 'email' parameter
    if ($email) {
        $driver->whereHas('user', function ($userQuery) use ($email) {
            $userQuery->where('email', 'like', "%$email%");
        });
    }

    // Filter by 'business_name' parameter
    if ($businessName) {
        $driver->where('business_name', 'like', "%$businessName%");
    }

    if ($license_number) {
        $driver->where('license_number', 'like', "%$license_number%");
    }

    if ($nin_number) {
        $driver->where('nin_number', 'like', "%$nin_number%");
    }

    if ($have_motor) {
        $driver->where('have_motor', 'like', "%$have_motor%");
    }

    if ($type) {
        $driver->where('type', 'like', "%$type%");
    }

    // Filter by 'status' parameter
    if ($status) {
        $driver->where('status', $status);
    }

    // Filter by 'full_name' parameter
    if ($fullName) {
        $driver->whereHas('user', function ($userQuery) use ($fullName) {
            $userQuery->where('full_name', 'like', "%$fullName%");
        });
    }

     // Filter by 'date' parameter (created_at date)
     if ($date) {
        $driver->whereDate('created_at', $date);
    }


    // Filter by date range
    if ($startDate) {
        $driver->whereDate('created_at', '>=', $startDate);
    }

    if ($endDate) {
        $driver->whereDate('created_at', '<=', $endDate);
    }

    $perPage = $request->input('per_page', 10);

    // Retrieve and paginate the results
    $driver = $driver->latest()->paginate($perPage);

    return DriverResource::collection($driver);
}


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

            return $this->success(new DriverResource($user->Driver), 'Driver updated successfully');
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
            $driver = Driver::with('user')->find($driverID);

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
            'status' => ['required', 'string','in:Pending,Confirmed,Rejected,Banned'],
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
