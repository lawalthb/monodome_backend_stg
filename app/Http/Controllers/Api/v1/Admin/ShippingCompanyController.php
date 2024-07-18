<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Broker;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Models\ShippingCompany;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ShippingCompaniesExport;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ShippingCompanyResource;

class ShippingCompanyController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $shippingCompany = ShippingCompany::where(function ($q) use ($key) {
            // Assuming there's a relationship between shippingCompany and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('status', 'like', "%{$key}%")->orWhere('nin_number', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return ShippingCompanyResource::collection($shippingCompany);
    }


    public function search(Request $request)
    {
        $terms = explode(" ", $request->input('search'));
        $perPage = $request->input('per_page', 10);

        $shippingCompany = ShippingCompany::query();

        foreach ($terms as $term) {
            $shippingCompany->where(function ($query) use ($term) {
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

        $shippingCompany = $shippingCompany->latest()->paginate($perPage);

        return ShippingCompanyResource::collection($shippingCompany);
    }

    public function show($shippingCompanyId) {
        $shippingCompany = ShippingCompany::find($shippingCompanyId);

        if (!$shippingCompany) {

            return $this->error('', 'shipping Company not found', 422);

        }

        return new ShippingCompanyResource($shippingCompany);
    }

    public function pending(Request $request){

        $perPage = $request->input('per_page', 10);

       $shippingCompany = ShippingCompany::query();


       $shippingCompany = $shippingCompany->whereIn('status', ['Pending','Rejected'])->latest()->paginate($perPage);

       return ShippingCompanyResource::collection($shippingCompany);
   }



    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $shippingCompany = ShippingCompany::findOrFail($id);

            // Update shippingCompany information
            $shippingCompany->phone_number = $request->input('phone_number');
            $shippingCompany->street = $request->input('address');
            $shippingCompany->save();

            // Update shippingCompany information
            if ($shippingCompany->user) {
                // If the user has an associated shippingCompany, update its information
            $user = $shippingCompany->user;
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->address = $request->input('address');
            $user->phone_number = $request->input('phone_number');
            $user->save();

            }

            DB::commit();

            return $this->success(new ShippingCompanyResource($user->shippingCompany), 'shippingCompany updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while updating the shippingCompany and user.');
        }
    }


    public function destroy($shippingCompanyId)
    {
        try {
            // Start a transaction
            DB::beginTransaction();

            // Find the shipping company by ID
            $shippingCompany = ShippingCompany::with(['user', 'order', 'loadBoard'])->find($shippingCompanyId);

            if (!$shippingCompany) {
                return $this->error('', 'Shipping company not found', 404);
            }

            // Delete related order if exists
            if ($order = $shippingCompany->order) {
                $order->delete();
            }

            // Delete related load board entry if exists
            if ($loadBoard = $shippingCompany->loadBoard) {
                $loadBoard->delete();
            }

            // Delete the shipping company
            $shippingCompany->delete();

            // Optionally, delete the associated user if required
            if ($user = $shippingCompany->user) {
                $user->delete();
            }

            // Commit the transaction
            DB::commit();

            return $this->success([], 'Shipping company, related order, and load board entry deleted successfully');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            return $this->error('', 'Unable to delete shipping company and related records', 500);
        }
    }




    public function setStatus(Request $request, $shippingCompanyId) {


        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string','in:Pending,Confirmed,Rejected,Failed'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $shippingCompany = ShippingCompany::find($shippingCompanyId);

        if (!$shippingCompany) {

            return $this->error('', 'shippingCompany not found', 422);

        }

        // Update the status
        $shippingCompany->status = $request->status;
        $shippingCompany->save();

        return $this->success(['shippingCompany'=> new ShippingCompanyResource($shippingCompany)], 'shippingCompany status updated successfully');
    }


    public function export()
    {
        return Excel::download(new ShippingCompaniesExport, 'shipping_companies.xlsx');
    }

}
