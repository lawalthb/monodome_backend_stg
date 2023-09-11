<?php

namespace App\Http\Controllers\Api\v1\Brokers;

use App\Models\User;
use App\Models\Broker;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\BrokersRequest;
use App\Http\Resources\BrokerResource;

class BrokerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrokersRequest $request)
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

                $user->password = bcrypt(Str::random(16));
                $user->user_type = 'agent';
                $user->save();

                $data = [
                    "full_name" => $request->input('full_name'),
                    "password" => $password,
                    "message" => "",
                ];
                Mail::to($user->email)->send(
                    new SendPasswordMail($data)
                );
                $role = Role::where('name', 'Broker')->first();

                if ($role) {
                    $user->assignRole($role);
                }
            }

            $broker = new Broker([
                'user_id' => $user->id,
                'state_id' => $request->input('state_id'),
                'street' => $request->input('street'),
                'status' => 'Waiting',
                'user_type' => 'broker',
                'role_id' =>  $role->id,
                'role' => 'broker',
                'lga' => $request->input('lga'),
                'nin_number' => $request->input('nin_number'),
                'city_of_residence' => $request->input('city_of_residence'),
                // Add other agent fields here
            ]);

            $broker->profile_picture = $this->uploadFile('broker/broker_images', $request->file('profile_picture'));
            $broker->save();

            DB::commit();

            return $this->success( new BrokerResource($broker), 'broker registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the broker.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Broker $broker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Broker $broker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Broker $broker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Broker $broker)
    {
        //
    }
}
