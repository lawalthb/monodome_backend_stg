<?php

namespace App\Http\Controllers\Api\v1\Agents;

use App\Models\User;
use App\Models\Agent;
use App\Models\Order;
use App\Models\Driver;
use App\Models\Company;
use App\Models\Guarantor;
use App\Models\LoadBoard;
use Illuminate\Support\Str;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Traits\ApiStatusTrait;
use App\Models\AgentCommission;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AgentResource;
use App\Http\Resources\OrderResource;
use App\Http\Requests\AgentFormRequest;
use App\Notifications\SendNotification;
use App\Http\Resources\LoadBoardResource;

class ClearingAgentController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;


        /**
     * Display the specified resource.
     */
    public function my_order(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $order = LoadBoard::orderBy('created_at', 'desc');

        $loadBoards = $order->whereIn('load_type_id', [3, 4])
            ->where('acceptable_id', auth()->user()->id)
            ->latest()
            ->paginate($perPage);

            return LoadBoardResource::collection($loadBoards);
        }


    public function broadcast(Request $request)
    {
        $query = LoadBoard::orderBy('created_at', 'desc');

        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }
        $perPage = $request->input('per_page', 10);

        $loadBoards = $query->whereIn('load_type_id',[3,4])
     //   ->where('acceptable_id', auth()->user()->id)
        // ->whereHas('user', function($query){
        //     $query->where('isPremium',true);
        // })
        ->latest()->paginate($perPage);

        return LoadBoardResource::collection($loadBoards);
    }

    public function singleBroadcast(Request $request, $id)
    {

        $loadBoard =  LoadBoard::where("id", $id)->first();

        if ($loadBoard) {
            return new LoadBoardResource($loadBoard);
        } else {
            return response()->json(['message' => 'LoadBoard record not found'], 404);
        }

        // Build the query to find the LoadBoard with the specified id and load type
        // $query = LoadBoard::where("id", $id)->whereIn('load_type_id', [3, 4]);

        // if ($request->has('order_no')) {
        //     $query->where('order_no', $request->input('order_no'));
        // }

        // $loadBoard = $query->first();

        // if ($loadBoard) {
        //     return new LoadBoardResource($loadBoard);
        // } else {
        //     return response()->json(['message' => 'LoadBoard record not found'], 404);
        // }
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

            $commission = AgentCommission::where("state_id",$request->input('state_id'))->first();
            $agent = Agent::updateOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'phone_number' => $request->input('phone_number'),
                    'state_id' => $request->input('state_id'),
                    'street' => $request->input('street'),
                    'custom_license_number' => $request->input('custom_license_number'),
                    'status' => 'Pending',
                    'type' => 'clearing',
                    'percentage' => $commission ? $commission->percentage : 0,
                    'nin_number' => $request->input('nin_number'),
                    'business_name' => $request->input('business_name'),
                    'lga' => $request->input('lga'),
                    // Add other agent fields here
                ]
            );
            if ($request->hasFile('cac_certificate') && $request->file('cac_certificate')->isValid()) {
                $agent->cac_certificate = $this->uploadFile('agent/agent_images', $request->file('cac_certificate'));
            }

            if ($request->hasFile('other_documents') && $request->file('other_documents')->isValid()) {
                $agent->other_documents = $this->uploadFile('agent/agent_images', $request->file('other_documents'));
            }

            if ($request->hasFile('store_front_image') && $request->file('store_front_image')->isValid()) {
                $agent->store_front_image = $this->uploadFile('agent/agent_images', $request->file('store_front_image'));
            }

            if ($request->hasFile('inside_store_image') && $request->file('inside_store_image')->isValid()) {
                $agent->inside_store_image = $this->uploadFile('agent/agent_images', $request->file('inside_store_image'));
            }

            if ($request->hasFile('registration_documents') && $request->file('registration_documents')->isValid()) {
                $agent->registration_documents = $this->uploadFile('agent/agent_documents', $request->file('registration_documents'));
            }

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


      /**
     * orderAssign
     * this function assign order to driver
     * @param  mixed $request
     * @return void
     */
    public function orderAssign(Request $request){

        return DB::transaction(function () use ($request) {

        $request->validate([
            'order_id' => 'required',
            'driver_id' => 'required',
        ]);

        $driver = Driver::find($request->driver_id);
        $order =  Order::where("id",$request->order_id)->where("driver_id",null)->first();

        if($order){
         //   return $order->loadable->state;
            $order->driver_id = $driver->id;
          //  $order->acceptable_id = $driver->id;
           // $order->acceptable_type = get_class($driver) ;
            $order->placed_by_id = auth()->user()->id;
            $order->save();
            $message ="You have been assign an order with number ". $order->order_no. " to delivery from: ".$order->loadable->sender_location." To: ".$order->loadable->receiver_location;
            $driver->user->notify(new SendNotification($driver->user, $message));

            return $this->success([
                new OrderResource($order),
            ]);


        }else{
             return $this->error([
            ], "Order already assign or doesn't exist!");
        }

    });

    }

    /**
     * acceptOrder
     *  this function is for driver manager to accept
     *  order from loadboard or loadbrocast
     * @param  mixed $request
     * @return void
     */
    public function acceptOrder(Request $request){

        return DB::transaction(function () use ($request) {

        $request->validate([
            'load_board_id' => 'required',
            //'driver_id' => 'required',
        ]);

        $loadBoards = LoadBoard::where("id",$request->load_board_id)->whereNull('acceptable_id')
        ->whereNull('acceptable_type')->first();

        if($loadBoards){

            $driverManger = Agent::where("user_id",auth()->id())->first();
            $order = Order::where("order_no", $loadBoards->order_no)->first();


            $loadBoards->acceptable_id = $driverManger->id;
            $loadBoards->acceptable_type = get_class($driverManger) ;

            $order->acceptable_id = $driverManger->id;
            $order->acceptable_type = get_class($driverManger) ;
            $order->save();

            $loadBoards->loadable->status = "Processing";
            $loadBoards->save();

            return new LoadBoardResource($loadBoards);
        }else{

            return $this->error([
            ], "This load has is empty or been taken!");
        }

    });

    }

    public function uploadDocs(Request $request)
{
    // Check if the request has files under 'documents'
    if (!$request->hasFile('documents')) {
        return $this->error([], "Document File is empty!");
    }

    // Attempt to find the Agent by the authenticated user's ID
    $agent = Agent::find(auth()->id());

    // Check if an Agent was found
    if (!$agent) {
        return $this->error([], "Agent not found.");
    }

    // Initialize an array to hold the documents
    $documents = [];

    // Iterate over each uploaded file
    foreach ($request->file('documents') as $file) {
        // Upload the file and get its details
        $fileDetails = $this->uploadFileWithDetails('load_documents', $file);
        $path = $fileDetails['path'];
        $name = $fileDetails['file_name'];

        // Create a new LoadDocument instance with the file details
        $document = new LoadDocument([
            'name' => $name,
            'path' => $path,
        ]);

        // Associate the document with the Agent
        $agent->loadDocuments()->save($document);
    }

    // Return a success response with the updated Agent resource
    return $this->success(new AgentResource($agent), 'Document uploaded successfully');
}



}
