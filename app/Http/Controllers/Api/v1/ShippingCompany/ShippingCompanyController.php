<?php

namespace App\Http\Controllers\Api\v1\ShippingCompany;

use App\Models\User;
use App\Models\Guarantor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Models\ShippingCompany;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ShippingCompanyRequest;
use App\Http\Resources\ShippingCompanyResource;


class ShippingCompanyController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $agents = ShippingCompany::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('street', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return ShippingCompanyResource::collection($agents);
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
    public function store(ShippingCompanyRequest $request)
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
                $user->user_type = 'shipping_company_super';
                $user->save();

                $data = [
                    "full_name" => $request->input('full_name'),
                    "password" => $password,
                    "message" => "",
                ];
                Mail::to($user->email)->send(
                    new SendPasswordMail($data)
                );
                $role = Role::where('name', 'Shipping Company')->first();

                if ($role) {
                    $user->assignRole($role);
                }
            }

            $shippingComPany = new ShippingCompany([
                'user_id' => $user->id,
                'state_id' => $request->input('state_id'),
                'street' => $request->input('street'),
                'lga' => $request->input('lga'),
               // 'profile_picture' => $request->input('profile_picture'),
                'nin_number' => $request->input('nin_number'),
                'phone_number' => $request->input('phone_number'),
                'status' => 'Waiting',

            ]);
            $shippingComPany->profile_picture = $this->uploadFile('shipping_company/agent_images', $request->file('profile_picture'));


            $shippingComPany->save();

                $guarantor = new Guarantor([
                    'full_name' =>  $request->input('guarantors_full_name'),
                    'phone_number' =>  $request->input('guarantors_phone_number'),
                    'street' =>  $request->input('guarantors_street'),
                    'state' =>  $request->input('guarantors_state'),
                    'lga' =>  $request->input('guarantors_lga'),
                    'profile_picture' => $this->uploadFile('agent/guarantor_images', $request->file("guarantors_profile_picture")),

                ]);

                $guarantor->loadable()->associate($shippingComPany);
                $shippingComPany->guarantors()->save($guarantor);

            DB::commit();

            return $this->success( new ShippingCompanyResource($shippingComPany), 'ShippingCompany and guarantors registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the ShippingCompany and guarantors.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingCompany $shippingCompany)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingCompany $shippingCompany)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingCompany $shippingCompany)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingCompany $shippingCompany)
    {
        //
    }
}
