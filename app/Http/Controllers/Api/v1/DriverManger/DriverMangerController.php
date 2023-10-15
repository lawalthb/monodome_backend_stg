<?php

namespace App\Http\Controllers\Api\v1\DriverManger;

use App\Models\User;
use App\Models\Guarantor;
use Illuminate\Support\Str;
use App\Models\DriverManger;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\DriverMangerRequest;
use App\Http\Resources\DriverMangerResource;

class DriverMangerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DriverMangerRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::firstOrNew(['email' => $request->input('email')]);

            if (!$user->exists) {
                // User doesn't exist, so create a new user
                $user->full_name = $request->input('full_name');
                $user->email = $request->input('email');
                $user->address = $request->input('address');
                $user->phone_number = $request->input('phone_number');
                $password  = Str::random(16);
                $user->password = $password;
                $user->user_type = 'driver_manager';
                $user->save();

                $data = [
                    "full_name" => $request->input('full_name'),
                    "password" => $password,
                    "message" => "",
                ];
                Mail::to($user->email)->send(
                    new SendPasswordMail($data)
                );
                $role = Role::where('name', 'Agent')->first();

                if ($role) {
                    $user->assignRole($role);
                }
            }

            $driverManager = new DriverManger([
                'user_id' => $user->id,
                'phone_number' => $request->input('phone_number'),
                'state_id' => $request->input('state_id'),
                'street' => $request->input('street'),
                'status' => 'Pending',
                'business_name' =>  $request->input('business_name'),
                'lga' => $request->input('lga'),
               // 'state_of_residence' => $request->input('state_of_residence'),
                //'city_of_residence' => $request->input('city_of_residence'),
                // Add other agent fields here
            ]);

            $driverManager->office_front_image = $this->uploadFile('driver_manager', $request->file('office_front_image'));
            $driverManager->inside_office_image = $this->uploadFile('driver_manager', $request->file('inside_office_image'));
            $driverManager->cac_certificate = $this->uploadFile('driver_manager', $request->file('cac_certificate'));

            $driverManager->save();

            $guarantorProfilePictures = [];

            foreach ($request->input('guarantors') as $key => $guarantorData) {
                $guarantor = new Guarantor([
                    'full_name' => $guarantorData['full_name'],
                    'phone_number' => $guarantorData['phone_number'],
                    'street' => $guarantorData['street'],
                    'state' => $guarantorData['state'],
                    'lga' => $guarantorData['lga'],
                    'email' => $guarantorData['email'],
                ]);

                $guarantor->loadable()->associate($driverManager);

                $guarantorProfilePictures[] = $this->uploadFile('driver_manager/guarantor_images', $request->file("guarantors.$key.profile_picture"));

                $driverManager->guarantors()->save($guarantor);
            }

            foreach ($driverManager->guarantors as $key => $guarantor) {
                $guarantor->profile_picture = $guarantorProfilePictures[$key];
                $guarantor->save();
            }

            DB::commit();

            return $this->success( new DriverMangerResource($driverManager), 'Driver Manager and guarantors registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the driver Manager and guarantors.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
