<?php

namespace App\Http\Controllers\Api\v1\Truck;

use App\Models\User;
use App\Models\Truck;
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
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\TruckResource;

class TruckController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $truck = Truck::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('email', 'like', "%{$key}%");
            })->orWhere('plate_number', 'like', "%{$key}%")
            ->orWhere('truck_location', 'like', "%{$key}%")
            ->orWhere('truck_name', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return TruckResource::collection($truck);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = User::firstOrNew(['email' => $request->input('email')]);

            if (!$user->exists) {
                // User doesn't exist, so create a new user
                $user->full_name = "Truck";//$request->input('full_name');
                $user->email = $request->input('email');
              //  $user->address = $request->input('address');
                $user->phone_number = $request->input('phone_number');
                $password  = Str::random(16);
                $user->password = $password;
                $user->user_type = 'truck';
                $user->save();

                // $data = [
                //     "full_name" => $request->input('full_name'),
                //     "password" => $password,
                //     "message" => "",
                // ];
                // Mail::to($user->email)->send(
                //     new SendPasswordMail($data)
                // );
                $role = Role::where('name', 'Truck')->first();

                if ($role) {
                    $user->assignRole($role);
                }
            }

            $truck = Truck::updateOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'phone_number' => $request->input('phone_number'),
                    'state_id' => $request->input('state_id'),
                    'street' => $request->input('street'),
                    'lga' => $request->input('lga'),
                    'status' => 'Pending',
                    'truck_name' => $request->input('truck_name'),
                    'truck_type' => $request->input('truck_type'),
                    'truck_location' => $request->input('truck_location'),
                    'truck_make' => $request->input('truck_make'),
                    'plate_number' => $request->input('plate_number'),
                    'cac_number' => $request->input('cac_number'),
                    'truck_description' => $request->input('truck_description'),
                    'business_name' => $request->input('business_name'),
                    // Add other truck fields here
                ]
            );

            $truck->profile_picture = $this->uploadFile('truck/truck_images', $request->file('profile_picture'));
          //  $truck->inside_store_image = $this->uploadFile('truck/truck_images', $request->file('inside_store_image'));
            //$truck->registration_documents = $this->uploadFile('truck/truck_documents', $request->file('registration_documents'));

            $truck->save();

            if ($request->input('documents')) {

                foreach ($request->input('documents') as $key => $fileData) {

                    $file = $this->uploadFileWithDetails('load_documents', $request->file("documents.$key.file"));
                    $path = $file['path'];
                    $name = $fileData['document_type'];//$file['file_name'];

                    // Create a record in the load_documents table
                    $document = new LoadDocument([
                        'name' => $name,
                        'path' => $path,
                    ]);

                    // Associate the document with the LoadBulk
                    $truck->loadDocuments()->save($document);
                }
            }

            DB::commit();

            return $this->success( new TruckResource($truck), 'Truck registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the agent and guarantors.');
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
