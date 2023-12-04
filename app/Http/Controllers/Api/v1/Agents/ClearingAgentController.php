<?php

namespace App\Http\Controllers\Api\v1\Agents;

use App\Models\User;
use App\Models\Agent;
use App\Models\Guarantor;
use App\Models\LoadBoard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AgentResource;
use App\Http\Requests\AgentFormRequest;
use App\Http\Resources\LoadBoardResource;

class ClearingAgentController extends Controller
{
    //

    public function broadcast(Request $request)
    {
        $query = LoadBoard::orderBy('created_at', 'desc');

        // Filter by Order Number
        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }
        $perPage = $request->input('per_page', 10); // Number of items per page, defaulting to 10.

        $loadBoards = $query->whereIn('load_type_id',[3,4])->latest()->paginate($perPage);

        return LoadBoardResource::collection($loadBoards);
    }

    public function singleBroadcast(Request $request, $id)
    {
        $query = LoadBoard::where("id", $id)->whereIn('load_type_id',[3,4]);

        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }

        $loadBoard = $query->first();

        if ($loadBoard) {
            return new LoadBoardResource($loadBoard);
        } else {
            return response()->json(['message' => 'LoadBoard record not found'], 404);
        }
    }


    public function store(AgentFormRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::firstOrNew(['email' => $request->input('email')]);

            if (!$user->exists) {
                // User doesn't exist, so create a new user
                $user->full_name = $request->input('full_name');
                $user->email = $request->input('email');
                $user->address = $request->input('address');
                $user->phone_number = $request->input('phone_number');
                $password  = Str::random(16);
                $user->password = $password;
                $user->user_type = 'clearing_agent';
                $user->save();

                $data = [
                    "full_name" => $request->input('full_name'),
                    "password" => $password,
                    "message" => "",
                ];
                Mail::to($user->email)->send(
                    new SendPasswordMail($data)
                );
                $role = Role::find(7);

                if ($role) {
                    $user->assignRole($role);
                }
            }

            $agent = Agent::updateOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'phone_number' => $request->input('phone_number'),
                    'state_id' => $request->input('state_id'),
                    'street' => $request->input('street'),
                    'status' => 'Pending',
                    'nin_number' => $request->input('nin_number'),
                    'business_name' => $request->input('business_name'),
                    'lga' => $request->input('lga'),
                    // Add other agent fields here
                ]
            );

            $agent->store_front_image = $this->uploadFile('agent/agent_images', $request->file('store_front_image'));
            $agent->inside_store_image = $this->uploadFile('agent/agent_images', $request->file('inside_store_image'));
            $agent->registration_documents = $this->uploadFile('agent/agent_documents', $request->file('registration_documents'));

            $agent->save();

            $guarantorProfilePictures = [];

            foreach ($request->input('guarantors') as $key => $guarantorData) {
                $guarantor = new Guarantor([
                    'full_name' => $guarantorData['full_name'],
                    'phone_number' => $guarantorData['phone_number'],
                    'street' => $guarantorData['street'],
                    'state' => $guarantorData['state'],
                    'lga' => $guarantorData['lga'],
                    'email' => $guarantorData['email'],
                ]);

                $guarantor->loadable()->associate($agent);

                $guarantorProfilePictures[] = $this->uploadFile('agent/guarantor_images', $request->file("guarantors.$key.profile_picture"));

                $agent->guarantors()->save($guarantor);
            }

            foreach ($agent->guarantors as $key => $guarantor) {
                $guarantor->profile_picture = $guarantorProfilePictures[$key];
                $guarantor->save();
            }

            DB::commit();

            return $this->success( new AgentResource($agent), 'Clearing Agent  and guarantors registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the Clearing Agent  and guarantors.');
        }
    }

}
