<?php

namespace App\Http\Controllers\Api\v1\Agents;

use App\Models\User;
use App\Models\Agent;
use App\Models\Guarantor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\AgentResource;
use App\Http\Requests\AgentFormRequest;

class AgentController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $offices = Agent::where(function ($q) use ($key) {
            $q->where('name', 'like', "%{$key}%")
                ->orWhere('address', 'like', "%{$key}%");
        })->with(['agent', 'country', 'state'])
            ->latest()
            ->paginate($perPage);

        return AgentResource::collection($offices);
    }


    public function store(AgentFormRequest $request)
{
    // Validate the request data using AgentFormRequest

    // Check if the user with the provided email exists, or create a new user
    $user = User::firstOrNew(['email' => $request->input('email')]);

    if (!$user->exists) {
        // User doesn't exist, so create a new user
        $user->full_name = $request->input('full_name');
        $user->email = $request->input('email');
        $user->password = bcrypt(Str::random(16)); // You can change this logic
        $user->user_type = 'agent'; // Set the user type to 'agent'
        $user->save();
    }

    // Now, create the agent record using the validated data
    $agent = new Agent([
        'user_id' => $user->id,
        'country_id' => $request->input('country_id'),
        'state_id' => $request->input('state_id'),
        'address' => $request->input('address'),
        'street' => $request->input('street'),
        'status' => 'Active', // You can set the default status here
        'lga' => $request->input('lga'),
        'state_of_residence' => $request->input('state_of_residence'),
        'city_of_residence' => $request->input('city_of_residence'),
        // Add other agent fields here
    ]);

    // Upload store front image, inside store image, and registration documents
    $agent->store_front_image = $request->file('store_front_image')->store('agent_images');
    $agent->inside_store_image = $request->file('inside_store_image')->store('agent_images');
    $agent->registration_documents = $request->file('registration_documents')->store('agent_documents');

    // Save the agent record
    $agent->save();

    // Create guarantors
    foreach ($request->input('guarantors') as $guarantorData) {
        $guarantor = new Guarantor([
            'full_name' => $guarantorData['full_name'],
            'phone_number' => $guarantorData['phone_number'],
            'address' => $guarantorData['address'],
            'street' => $guarantorData['street'],
            'state' => $guarantorData['state'],
            'lga' => $guarantorData['lga'],
            'state_of_residence' => $guarantorData['state_of_residence'],
            'city_of_residence' => $guarantorData['city_of_residence'],
            // Add other guarantor fields here
        ]);

        // Upload guarantor profile picture
        $guarantor->profile_picture = $request->file('guarantors.*.profile_picture')->store('guarantor_images');

        // Save the guarantor record
        $agent->guarantors()->save($guarantor);
    }

    // Return a success response
    return $this->success($agent, 'Agent and guarantors registered successfully');
}

//     public function store(Request $request)
// {
//     $request->validate([
//         // Add validation rules for agent and guarantor details here
//     ]);

//     // Check if the user exists by email
//     $user = User::where('email', $request->input('email'))->first();

//     if (!$user) {
//         // User does not exist, create a new user
//         $user = new User([
//             'full_name' => $request->input('full_name'),
//             'email' => $request->input('email'),
//             'password' => Hash::make('password'), // Set a default password or generate one
//             // Add other user details here
//         ]);

//         // Save the new user
//         $user->save();
//     }

//     // Create the agent record
//     $agent = new Agent([
//         'user_id' => $user->id,
//         'country_id' => $request->input('country_id'),
//         'state_id' => $request->input('state_id'),
//         'address' => $request->input('address'),
//         'street' => $request->input('street'),
//         'status' => 'Active', // You can set a default status here
//         'lga' => $request->input('lga'),
//         'state_of_residence' => $request->input('state_of_residence'),
//         'city_of_residence' => $request->input('city_of_residence'),
//         'store_front_image' => $request->input('store_front_image'),
//         'inside_store_image' => $request->input('inside_store_image'),
//         'registration_documents' => $request->input('registration_documents'),
//     ]);

//     // Save the agent record
//     $agent->save();

//     // Create guarantor records
//     foreach ($request->input('guarantors') as $guarantorData) {
//         $guarantor = new Guarantor([
//             'full_name' => $guarantorData['full_name'],
//             'phone_number' => $guarantorData['phone_number'],
//             'address' => $guarantorData['address'],
//             'street' => $guarantorData['street'],
//             'state' => $guarantorData['state'],
//             'lga' => $guarantorData['lga'],
//             'state_of_residence' => $guarantorData['state_of_residence'],
//             'city_of_residence' => $guarantorData['city_of_residence'],
//             'profile_picture' => $guarantorData['profile_picture'],
//             'agent_id' => $agent->id,
//         ]);

//         // Save the guarantor record
//         $guarantor->save();
//     }

//     // Commit the database transaction
//     DB::commit();

//     return response()->json(['message' => 'Agent registered successfully']);
// }
}
