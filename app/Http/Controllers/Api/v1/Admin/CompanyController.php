<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Models\company;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $company = company::where(function ($q) use ($key) {
            // Assuming there's a relationship between Company and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('status', 'like', "%{$key}%")->orWhere('nin_number', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return CompanyResource::collection($company);
    }


    public function search(Request $request)
    {
        $terms = explode(" ", $request->input('search'));
        $perPage = $request->input('per_page', 10);

        $company = company::query();

        foreach ($terms as $term) {
            $company->where(function ($query) use ($term) {
                $query->orWhereHas('user', function ($userQuery) use ($term) {
                    $userQuery->where('email', 'like', "%$term%")
                        ->orWhere('full_name', 'like', "%$term%");
                })
                ->orWhere('phone_number', 'like', "%$term%")
                ->orWhere('nin_number', 'like', "%$term%")
                ->orWhere('status', 'like', "%$term%")
                ->orWhereHas('state', function ($stateQuery) use ($term) {
                    $stateQuery->where('name', 'like', "%$term%");
                });
            });
        }

        $company = $company->latest()->paginate($perPage);

        return CompanyResource::collection($company);
    }

    public function show($companyId) {
        $company = company::find($companyId);

        if (!$company) {

            return $this->error('', 'shipping Company not found', 422);

        }

        return new CompanyResource($company);
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $company = company::findOrFail($id);

            // Update company information
            $company->phone_number = $request->input('phone_number');
            $company->street = $request->input('address');
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


    public function destroy($companyId)
    {
        try {
            // Find the driver by ID
            $company = company::with('user')->find($companyId);

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
            'status' => ['required', 'string','in:Pending,Confirmed,Rejected,Failed'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $company = company::find($companyId);

        if (!$company) {

            return $this->error('', 'company not found', 422);

        }

        // Update the status
        $company->status = $request->status;
        $company->save();

        return $this->success(['company'=> new CompanyResource($company)], 'Company status updated successfully');
    }
}
