<?php

namespace App\Http\Controllers\Api\v1\Admin;

use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
use App\Models\LoadSpecialized;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\LoadSpecializedResource;

class SpecializedShipmentController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $specialized = LoadSpecialized::where('user_id', auth()->id())->where(function ($q) use ($key) {
            $q->where('sender_name', 'like', "%{$key}%")
            ->orWhere('sender_email', 'like', "%{$key}%");
        })->latest()->paginate();

        return LoadSpecializedResource::collection($specialized);
    }


    public function search(Request $request)
    {
        $terms = explode(" ", $request->input('search'));
        $perPage = $request->input('per_page', 10);

        $specialized = LoadSpecialized::query();

        foreach ($terms as $term) {
            $specialized->where(function ($query) use ($term) {
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

        $specialized = $specialized->latest()->paginate($perPage);

        return LoadSpecializedResource::collection($specialized);
    }

    public function show($specializedId) {
        $specialized = LoadSpecialized::find($specializedId);

        if (!$specialized) {

            return $this->error('', 'shipping specialized not found', 422);

        }

        return new LoadSpecializedResource($specialized);
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $specialized = LoadSpecialized::findOrFail($id);

            // Update specialized information
            $specialized->phone_number = $request->input('phone_number');
            $specialized->street = $request->input('address');
            $specialized->save();

            // Update specialized information
            if ($specialized->user) {
                // If the user has an associated specialized, update its information
            $user = $specialized->user;
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->address = $request->input('address');
            $user->phone_number = $request->input('phone_number');
            $user->save();

            }

            DB::commit();

            return $this->success(new LoadSpecializedResource($user->specialized), 'specialized updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while updating the specialized and user.');
        }
    }


    public function destroy($specializedId)
    {
        try {
            // Start a transaction
            DB::beginTransaction();

            // Find the specialized shipment by ID
            $specialized = LoadSpecialized::with(['order', 'loadBoard', 'user'])->find($specializedId);

            if (!$specialized) {
                return $this->error('', 'Specialized shipment not found', 404);
            }

            // Delete related order if exists
            if ($order = $specialized->order) {
                $order->delete();
            }

            // Delete related load board entry if exists
            if ($loadBoard = $specialized->loadBoard) {
                $loadBoard->delete();
            }

            // Delete the specialized shipment
            $specialized->delete();

            // Optionally, delete the associated user if required
            if ($user = $specialized->user) {
                $user->delete();
            }

            // Commit the transaction
            DB::commit();

            return $this->success([], 'Specialized shipment, related order, and load board entry deleted successfully');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            return $this->error('', 'Unable to delete specialized shipment and related records', 500);
        }
    }



    public function setStatus(Request $request, $specializedId) {


        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string','in:Pending,Confirmed,Rejected,Failed'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $specialized = LoadSpecialized::find($specializedId);

        if (!$specialized) {

            return $this->error('', 'specialized not found', 422);

        }

        // Update the status
        $specialized->status = $request->status;
        $specialized->save();

        return $this->success(['specialized'=> new LoadSpecializedResource($specialized)], 'specialized status updated successfully');
    }

    public function sendToLoadBoard(Request $request, $specializedId) {

        if ($specializedId == "") {
            return $this->error('', "id cant be empty", 422);
        }

        $specialized = LoadSpecialized::find($specializedId);

        if (!$specialized) {

            return $this->error('', 'specialized not found', 422);

        }


        event(new LoadTypeCreated( $specialized));

        return $this->success(['specialized'=> new LoadSpecializedResource($specialized)], 'specialized load move to loadBoard successfully');
    }



    public function price(Request $request, $specializedId) {

        $validator = Validator::make($request->all(), [
            'total_amount' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $specialized = LoadSpecialized::find($specializedId);

        if (!$specialized) {

            return $this->error('', 'specialized not found', 422);

        }

        // Update the status
        $specialized->total_amount = $request->total_amount;
        $specialized->save();

        return $this->success(['specialized'=> new LoadSpecializedResource($specialized)], 'specialized Total Amount updated successfully');
    }

}
