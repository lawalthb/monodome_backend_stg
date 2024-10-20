<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Company;
use App\Models\LoadBulk;
use App\Models\LoadPackage;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\LoadBulkResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\LoadPackageResource;

class CompanyController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $company = Company::where(function ($q) use ($key) {
            // Assuming there's a relationship between Company and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('status', 'like', "%{$key}%")
            ->orWhere('number_of_drivers', 'like', "%{$key}%")
            ->orWhere('number_of_trucks', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return CompanyResource::collection($company);
    }


    public function search(Request $request)
    {
        // Get query parameters from the request
        $sort = $request->input('sort');
        $email = $request->input('email');
        $businessName = $request->input('company_name');
        $phone = $request->input('phone_number');
        $status = $request->input('status');
        $fullName = $request->input('full_name');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $date = $request->input('date');

        // Apply filters to the Agent query
        $company = Company::query();

        // Filter by 'sort' parameter
        if ($sort) {
            $company->orderBy($sort);
        }

        // Filter by 'email' parameter
        if ($email) {
            $company->whereHas('user', function ($userQuery) use ($email) {
                $userQuery->where('email', 'like', "%$email%");
            });
        }

        // Filter by 'business_name' parameter
        if ($businessName) {
            $company->where('company_name', 'like', "%$businessName%");
        }

        // Filter by 'phone_number' parameter
        if ($phone) {
            $company->where('phone_number', 'like', "%$phone%");
        }

        // Filter by 'status' parameter
        if ($status) {
            $company->where('status', $status);
        }

        // Filter by 'full_name' parameter
        if ($fullName) {
            $company->whereHas('user', function ($userQuery) use ($fullName) {
                $userQuery->where('full_name', 'like', "%$fullName%");
            });
        }

        // Filter by date range
        if ($startDate) {
            $company->whereDate('created_at', '>=', $startDate);
        }

        if ($date) {
            $company->whereDate('created_at', '=', $date);
        }

        if ($endDate) {
            $company->whereDate('created_at', '<=', $endDate);
        }

        $perPage = $request->input('per_page', 10);

        // Retrieve and paginate the results
        $company = $company->latest()->paginate($perPage);

        return CompanyResource::collection($company);
    }

    // public function search(Request $request)
    // {
    //     $terms = explode(" ", $request->input('search'));
    //     $perPage = $request->input('per_page', 10);

    //     $company = Company::query();

    //     foreach ($terms as $term) {
    //         $company->where(function ($query) use ($term) {
    //             $query->orWhereHas('user', function ($userQuery) use ($term) {
    //                 $userQuery->where('email', 'like', "%$term%")
    //                     ->orWhere('full_name', 'like', "%$term%");
    //             })
    //             ->orWhere('phone_number', 'like', "%$term%")
    //             ->orWhere('number_of_drivers', 'like', "%$term%")
    //             ->orWhere('company_name', 'like', "%$term%")
    //             ->orWhere('number_of_trucks', 'like', "%$term%")
    //             ->orWhere('status', 'like', "%$term%")
    //             ->orWhereHas('state', function ($stateQuery) use ($term) {
    //                 $stateQuery->where('name', 'like', "%$term%");
    //             });
    //         });
    //     }

    //     $company = $company->latest()->paginate($perPage);

    //     return CompanyResource::collection($company);
    // }

    public function show($companyId) {
        $company = Company::find($companyId);

        if (!$company) {

            return $this->error('', 'Company transporter not found', 422);

        }

        return new CompanyResource($company);
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $company = Company::findOrFail($id);

            // Update company information
            $company->phone_number = $request->input('phone_number');
            $company->street = $request->input('address');
            $company->company_name = $request->input('company_name');
            $company->number_of_drivers = $request->input('number_of_drivers');
            $company->number_of_drivers = $request->input('number_of_drivers');
            $company->number_of_trucks = $request->input('number_of_trucks');
            $company->save();

            // Update company information
            if ($company->user) {
                // If the user has an associated company, update its information
            $user = $company->user;
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->address = $request->input('address');
            $user->phone_number = $request->input('phone_number');
            $user->save();

            }

            DB::commit();

            return $this->success(new CompanyResource($user->company), 'Company updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while updating the Company and user.');
        }
    }

    public function pending(Request $request){

        $perPage = $request->input('per_page', 10);

       $shippingCompany = Company::query();


       $shippingCompany = $shippingCompany->whereIn('status', ['Pending','Rejected'])->latest()->paginate($perPage);

       return CompanyResource::collection($shippingCompany);
   }

    public function destroy($companyId)
    {
        try {
            // Find the driver by ID
            $company = Company::with('user')->find($companyId);

        if (!$company) {
                return $this->error('', 'company not found', 404);
            }

            if ( $user = $company->user) {
                $company->delete();

                $user->delete();

            return $this->success([], 'Company and user deleted successfully');

        }
        } catch (\Exception $e) {
            return $this->error('', 'Unable to delete Company and user', 500);
        }
    }


    public function setStatus(Request $request, $companyId) {


        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string','in:Pending,Confirmed,Rejected,Banned'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $company = Company::find($companyId);

        if (!$company) {

            return $this->error('', 'company not found', 422);

        }

        // Update the status
        $company->status = $request->status;
        $company->save();

        return $this->success(['company'=> new CompanyResource($company)], 'Company status updated successfully');
    }

    public function privateLoadBulkGet()
    {
        $key = request()->input('search');
        $size = request()->input('size') ?? 20;

        $loadBulk = LoadBulk::where('user_id', auth()->id())->where("is_private", "Yes")->where(function ($q) use ($key) {
            $q->where('sender_name', 'like', "%{$key}%")
                ->orWhere('sender_email', 'like', "%{$key}%");
        })->latest()->paginate($size);


        return LoadBulkResource::collection($loadBulk);
        // return response()->json($loadBulk);
    }

    public function privateLoadPackageGet()
    {
        $key = request()->input('search');

        $loadPackages = LoadPackage::where('user_id', auth()->id())->where("is_private", "Yes")->where(function ($q) use ($key) {
            $q->where('sender_name', 'like', "%{$key}%")
            ->orWhere('sender_email', 'like', "%{$key}%");
        })->latest()->paginate();


       return LoadPackageResource::collection($loadPackages);
       // return response()->json($loadPackages);
    }
}
