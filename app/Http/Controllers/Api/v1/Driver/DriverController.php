<?php

namespace App\Http\Controllers\Api\v1\Driver;

use App\Models\User;
use App\Models\Agent;
use App\Models\Driver;
use App\Models\Guarantor;
use Illuminate\Support\Str;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\DriverRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AgentResource;
use App\Http\Resources\DriverResource;
use App\Http\Requests\AgentFormRequest;

class DriverController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $driver = Driver::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
                $userQuery->where('address', 'like', "%{$key}%");
            })->orWhere('license_number', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return DriverResource::collection($driver);
    }


    public function store(DriverRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::firstOrNew(['email' => $request->input('email')]);

            if (!$user->exists) {
                // User doesn't exist, so create a new user
                $user->full_name = $request->input('full_name');
                $user->email = $request->input('email');
                $user->address = $request->input('address');
                $password  = Str::random(16);
                $user->password = $password;
                $user->user_type = 'driver';
                $user->save();

                $data = [
                    "full_name" => $request->input('full_name'),
                    "password" => $password,
                    "message" => "",
                ];
                Mail::to($user->email)->send(
                    new SendPasswordMail($data)
                );

                $role = Role::where('name', 'Driver')->first();

                if ($role) {
                    $user->assignRole($role);
                }
            }


           // $data = $request->validated();
        //   $driver = Driver::create($data);


            $driver = new Driver([
                'user_id' => $user->id,
                'state_id' => $request->input('state_id'),
                'street' => $request->input('street'),
                'status' => 'Pending',
                'lga' => $request->input('lga'),
                'nin_number' => $request->input('nin_number'),
                'license_number' => $request->input('license_number'),
                'have_motor' => $request->input('have_motor'),
                'vehicle_type_id' => $request->input('vehicle_type_id'),
                // Add other agent fields here
            ]);


            $driver->proof_of_license = $this->uploadFile('driver/driver_images', $request->file('proof_of_license'));
            $driver->profile_picture = $this->uploadFile('driver/driver_images', $request->file('profile_picture'));
           // $driver->registration_documents = $this->uploadFile('agent/agent_documents', $request->file('registration_documents'));

            $driver->save();

            if ($request->hasFile('vehicle_image')) {
                $documents = [];

                foreach ($request->file('vehicle_image') as $file) {

                    $file = $this->uploadFileWithDetails('vehicle_image', $file);
                    $path = $file['path'];
                    $name = $file['file_name'];

                    // Create a record in the load_documents table
                    $document = new LoadDocument([
                        'name' => $name,
                        'path' => $path,
                       // 'loadable_id' => $driver->id, // Set the loadable_id to the driver's ID
                         //'loadable_type' => Driver::class, //
                    ]);

                    // Associate the document with the LoadBulk
                    $driver->loadDocuments()->save($document);
                }
            }

            $guarantorProfilePictures = [];

            foreach ($request->input('guarantors') as $key => $guarantorData) {
                $guarantor = new Guarantor([
                    'full_name' => $guarantorData['full_name'],
                    'phone_number' => $guarantorData['phone_number'],
                    'address' => $guarantorData['address'],
                    'street' => $guarantorData['street'],
                    'state' => $guarantorData['state'],
                    'lga' => $guarantorData['lga'],
                    'state_of_residence' => $guarantorData['state_of_residence'],
                    'city_of_residence' => $guarantorData['city_of_residence'],
                    // Add other guarantor fields here
                ]);

                $guarantor->loadable()->associate($driver);

                $guarantorProfilePictures[] = $this->uploadFile('driver/guarantor_images', $request->file("guarantors.$key.profile_picture"));

                $driver->guarantors()->save($guarantor);
            }

            foreach ($driver->guarantors as $key => $guarantor) {
                $guarantor->profile_picture = $guarantorProfilePictures[$key];
                $guarantor->save();
            }

            DB::commit();

            return $this->success( new DriverResource($driver), 'Driver and guarantors registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the driver and guarantors.');
        }
    }

}
