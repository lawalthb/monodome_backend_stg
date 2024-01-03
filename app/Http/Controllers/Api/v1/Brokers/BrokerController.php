<?php

namespace App\Http\Controllers\Api\v1\Brokers;

use App\Models\User;
use App\Models\Broker;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\BrokersRequest;
use App\Http\Resources\BrokerResource;

class BrokerController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $agents = Broker::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('street', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return BrokerResource::collection($agents);
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

        $user = User::where('email', $request->input('email'))->first();
        $ref_by = null;

        if ($request->has('ref_by')) {
            $ref_by = User::where('referral_code', $request->input('ref_by'))->first();
        }

        if (!$user && $request->has('address')) {
            // User doesn't exist, so create a new user
            $user = new User();
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->ref_by = $ref_by ? $ref_by->id : null;
            $user->referral_code = $request->input('referral_code') ?? generateReferralCode();
            $user->address = $request->input('address');
            $user->phone_number = $request->input('phone_number');
            $password = Str::random(16);
            $user->password = Hash::make($password);
            $user->user_type = 'broker';
            $user->save();

            // Sending password via email
            $data = [
                "full_name" => $request->input('full_name'),
                "password" => $password,
                "message" => "",
            ];
            Mail::to($user->email)->send(new SendPasswordMail($data));

            $role = Role::where('name', 'Broker')->first();
            if ($role) {
                $user->assignRole($role);
            }
        } else {
            // User already exists, update the user
            $user->full_name = $request->input('full_name');
            $user->ref_by = $ref_by ? $ref_by->id : null;
            $user->referral_code = $request->input('referral_code') ?? generateReferralCode();
            $user->phone_number = $request->input('phone_number');
            // Check if 'password' exists in the request, then update password
            if ($request->has('password')) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();
        }

        $broker = new Broker([
            'user_id' => $user->id,
            'state_id' => $request->input('state_id'),
            'street' => $request->input('street'),
            'lga' => $request->input('lga'),
            'nin_number' => $request->input('nin_number'),
            'status' => 'Waiting',
        ]);

        $broker->profile_picture = $this->uploadFile('broker/broker_images', $request->file('profile_picture'));
        $broker->save();

        DB::commit();

        return $this->success(new BrokerResource($broker), 'Broker registered successfully');
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
