<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\DriverManger;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Doctrine\DBAL\DriverManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DriverManagersImport;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DriverMangerResource;

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
        ->withCount('user_created_by')
      //  ->where('status','Confirmed') // Eager load the user_created_by relationship and count
        ->latest()
        ->paginate($perPage);

        return DriverMangerResource::collection($drivers);
    }


    public function pending(Request $request){

        $perPage = $request->input('per_page', 10);

       $driver = DriverManger::query();


       $driver = $driver->whereIn('status', ['Pending','Rejected'])->latest()->paginate($perPage);

       return DriverMangerResource::collection($driver);
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
             //   ->orWhere('have_motor', 'like', "%$term%")
              //  ->orWhere('type', 'like', "%$term%")
           //     ->orWhere('license_number', 'like', "%$term%")
             //   ->orWhere('nin_number', 'like', "%$term%")
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

            return $this->error('', 'Driver manager not found', 422);

        }

        return new DriverMangerResource($Driver);
    }


    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id . ',id',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Find the DriverManager by ID
            $driverManager = DriverManger::findOrFail($id);

            // Update DriverManager information
            $driverManager->street = $validatedData['address'];
            $driverManager->save();

            // Check if the driver manager has an associated user and update the user details
            if ($driverManager->user) {
                $user = $driverManager->user;
                $user->full_name = $validatedData['full_name'];
                $user->email = $validatedData['email'];
                $user->address = $validatedData['address'];
                $user->phone_number = $validatedData['phone_number'];
                $user->save();
            } else {
                throw new \Exception("Associated user not found for the Driver Manager with ID {$id}");
            }

           DB::commit();

            return $this->success(new DriverMangerResource($driverManager), 'Driver Manager and user updated successfully');
        } catch (\Exception $e) {
           DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while updating the Driver Manager and user.');
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
            'status' => ['required', 'string','in:Pending,Confirmed,Rejected,Banned'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $driver = DriverManger::find($driverID);

        if (!$driver) {

            return $this->error('', 'Driver not found', 422);

        }

        // Update the status
        $driver->status = $request->status;
        $driver->user->status = $request->status;
        $driver->user->save();
        $driver->save();

        return $this->success(['driver'=> new DriverMangerResource($driver)], 'Driver status updated successfully');
    }


    public function bulkUpload(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,csv,txt'
    ]);

    try {
        Excel::import(new DriverManagersImport, $request->file('file'));
        return $this->success([], "Driver Managers imported successfully");
    } catch (\Throwable $th) {
        return $this->error(['error' => $th->getMessage()]);
    }
}
}
