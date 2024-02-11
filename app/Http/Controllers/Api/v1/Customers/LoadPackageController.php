<?php
namespace App\Http\Controllers\Api\v1\Customers;

use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use App\Models\LoadType;
use App\Models\LoadPackage;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadPackageRequest;
use App\Http\Resources\LoadPackageResource;

    class LoadPackageController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;
    public function index()
    {

        $key = request()->input('search');

        $loadPackages = LoadPackage::where('user_id', auth()->id())->where(function ($q) use ($key) {
            $q->where('sender_name', 'like', "%{$key}%")
            ->orWhere('sender_email', 'like', "%{$key}%");
        })->latest()->paginate();


       return LoadPackageResource::collection($loadPackages);
       // return response()->json($loadPackages);
    }

    public function show($id)
    {
        $loadPackage = LoadPackage::with('order')->find($id);

        if (!$loadPackage) {
            return $this->error(null, "Load Package not found", 404);
        }

        $secretkey = Setting::where(['slug' => 'secretkey'])->first()->value;

                $url = "https://api.paystack.co/transaction/initialize";

                $fields = [
                    'email' => $loadPackage->user->email,
                    'amount' => str_pad($loadPackage->total_amount, 2, '0', STR_PAD_RIGHT),
                ];

                $fields_string = http_build_query($fields);

                //open connection
                $ch = curl_init();

                //set the url, number of POST vars, POST data
                curl_setopt($ch,CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Authorization: Bearer $secretkey",
                    "Cache-Control: no-cache",
                ));

                //So that curl_exec returns the contents of the cURL; rather than echoing it
                curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

                //execute post
                $result = curl_exec($ch);
                $result  = json_decode($result);

                if ($result->status == true) {
                    return $this->success([
                        "paystack" => $result->data,
                        "loadPackage" => new LoadPackageResource($loadPackage),
                    ], "Successfully");
                } else {
                    return $this->error(null, "Paystack key not found", 404);
                }
    }


    public function delivery_fee(Request $request){


    }

    public function store(LoadPackageRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $loadType = LoadType::find($request->load_type_id);
            $validatedData = $request->validated();

            // Create a new LoadPackage instance
            // $loadPackage = $loadType->loadPackages()->create($request->validated());

            $totalAmount = $validatedData['delivery_fee'] + $validatedData['insure_amount'];


            $loadPackage = LoadPackage::firstOrCreate(
                [
                    'load_type_id' => $request->load_type_id,
                    'user_id' => $request->user()->id ,
                    'total_amount' => $request->total_amount,
                    'weight' => $request->weight,
                ],
                array_merge($validatedData, ['total_amount' => $totalAmount])
            );

            if (!$loadPackage->order) {
                $order = $loadPackage->order()->create([
                    'order_no' => getNumber(),
                  //  'driver_id' => 1, // Change this to the actual driver ID
                    'amount' =>  $totalAmount, // Set the appropriate amount
                    'user_id' => $loadPackage->user_id,
                    'status' => "Pending",
                ]);
            } else {
                $order = $loadPackage->order; // If an order already exists, use the existing one
            }

        // Handle document uploads (if any)
        if ($request->hasFile('documents')) {
            $documents = [];

            foreach ($request->file('documents') as $file) {

                $file = $this->uploadFileWithDetails('load_documents', $file);
                $path = $file['path'];
                $name = $file['file_name'];

                // Create a record in the load_documents table
                $document = new LoadDocument([
                    'name' => $name,
                    'path' => $path,
                ]);

                // Associate the document with the LoadBulk
                $loadPackage->loadDocuments()->save($document);
            }
        }

            return $this->success([
                "loadPackage" => new LoadPackageResource($loadPackage),
                // "order" => $order, // Include the order in the response
            ], "Created Successfully");
        });
    }

    public function update(LoadPackageRequest $request, $id)
    {
        $loadType = LoadType::where('user_id', auth()->id())->find($request->load_type_id);

        $loadPackage = $loadType->loadPackages()->create($request->validated());
        return $this->success(
            [
                "loadPackage" => new LoadPackageResource($loadPackage),
            ],
            "update Successfully"
        );
    }

    public function destroy($id)
    {
        $loadPackage = LoadPackage::where('user_id', auth()->id())->find($id);

        if (!$loadPackage) {
            return $this->error(null, "Load Package not found'",404 );
        }
        $loadPackage->delete();
        return $this->success(["loadType" => new LoadPackageResource($loadPackage),], "Package Type deleted");
    }
}
