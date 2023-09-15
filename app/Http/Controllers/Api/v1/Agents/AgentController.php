<?php

namespace App\Http\Controllers\Api\v1\Agents;

use App\Models\User;
use App\Models\Agent;
use App\Models\Guarantor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AgentResource;
use App\Http\Requests\AgentFormRequest;

class AgentController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $agents = Agent::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('street', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return AgentResource::collection($agents);
    }


    public function search(Request $request)
    {
        $terms = explode(" ", $request->input('search'));
        $perPage = $request->input('per_page', 10);

        $agents = Agent::query();

        foreach ($terms as $term) {
            $agents->where(function ($query) use ($term) {
                $query->orWhereHas('user', function ($userQuery) use ($term) {
                    $userQuery->where('email', 'like', "%$term%")
                        ->orWhere('full_name', 'like', "%$term%");
                })
                ->orWhere('street', 'like', "%$term%")
                ->orWhereHas('state', function ($stateQuery) use ($term) {
                    $stateQuery->where('name', 'like', "%$term%");
                });
            });
        }

        $agents = $agents->latest()->paginate($perPage);

        return AgentResource::collection($agents);
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
                $password  = Str::random(16);
                $user->password = $password;
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
                $role = Role::where('name', 'Agent')->first();

                if ($role) {
                    $user->assignRole($role);
                }
            }

            $agent = new Agent([
                'user_id' => $user->id,
                'country_id' => $request->input('country_id'),
                'state_id' => $request->input('state_id'),
                'street' => $request->input('street'),
                'status' => 'Pending',
                'lga' => $request->input('lga'),
                'state_of_residence' => $request->input('state_of_residence'),
                'city_of_residence' => $request->input('city_of_residence'),
                // Add other agent fields here
            ]);

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

            return $this->success( new AgentResource($agent), 'Agent and guarantors registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while registering the agent and guarantors.');
        }
    }

}
