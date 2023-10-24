<?php

namespace App\Http\Controllers\Api\v1\Company;

use App\Models\User;
use App\Models\company;
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
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;


class CompanyController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $agents = company::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('street', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return CompanyResource::collection($agents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::firstOrNew(['email' => $request->input('email')]);

            if (!$user->exists) {
                $user->full_name = $request->input('full_name');
                $user->email = $request->input('email');
                $user->address = $request->input('address');
                $user->phone_number = $request->input('phone_number');
                $password  = Str::random(16);
                $user->password = Hash::make($password);
                $user->imageUrl = $this->uploadFile('company/company_images', $request->file('company_logo'));
                $user->save();

                $data = [
                    "full_name" => $request->input('full_name'),
                    "password" => $password,
                    "message" => "",
                ];
                Mail::to($user->email)->send(
                    new SendPasswordMail($data)
                );
            }

            $role = Role::find(10);
            if ($role) {
                $user->user_type = Str::slug($role->name, "_"); //str_replace(' ', '_', $role->name);;
                $user->role_id = $role->id;
                $user->role = $role->name;
                $user->assignRole($role);
            }
            $user->save();
            $company = new Company([
                'user_id' => $user->id,
                'state_id' => $request->input('state_id'),
                'street' => $request->input('street'),
                'truck_type' => $request->input('type_of_truck'),
                'number_of_drivers' => $request->input('number_of_drivers'),
                'number_of_trucks' => $request->input('number_of_trucks'),
                'status' => 'Waiting',
                'lga' => $request->input('lga'),
                'state_of_residence' => $request->input('state_of_residence'),
                'city_of_residence' => $request->input('city_of_residence'),
            ]);

            $company->company_logo = $this->uploadFile('company/company_images', $request->file('company_logo'));
            $company->cac_documents = $this->uploadFile('company/company_documents', $request->file('cac_documents'));

            $company->save();

            DB::commit();

            return $this->success(new CompanyResource($company), 'Company registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the Company.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(company $company)
    {
        //
    }
}
