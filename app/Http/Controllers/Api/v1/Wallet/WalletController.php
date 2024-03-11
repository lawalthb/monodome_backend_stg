<?php

namespace App\Http\Controllers\Api\v1\Wallet;

use App\Models\User;
use App\Models\Wallet;
use App\Models\PriceSetting;
use Illuminate\Http\Request;
use App\Models\WalletHistory;
use App\Models\RequestPayment;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\BeneficiaryBankDetail;
use App\Http\Resources\WalletResource;
use App\Http\Resources\WalletHistoryResource;
use App\Http\Resources\RequestPaymentResource;

class WalletController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $wallet = Wallet::where('user_id', auth()->user()->id)->paginate( $perPage );

        return $this->success(['wallet' => WalletResource::collection($wallet)], "Wallet Dashboard details");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //api
    }

    public function wallet_history(Request $request){
        $perPage = $request->input('per_page', 10);
        $walletHistory = WalletHistory::where('user_id', auth()->user()->id)->paginate($perPage);

        return $this->success(['walletHistory' => WalletHistoryResource::collection($walletHistory)], "Wallet History details");

    }

    public function getWalletHistory(Request $request)
    {
        $page = $request->page;
        $limit = 25;
        $offset = ($page - 1) * $limit;
        $walletHistory = WalletHistory::where('user_id',Auth::id())
                            ->OrderBy('id','desc')
                            ->offset($offset)
                            ->limit($limit)
                            ->get();

        if($walletHistory)
            return response()->json(['status'=>true,'data'=> $walletHistory],200);
        else
            return response()->json(['status'=>false, 'message' => 'No Data Found.', 'data'=> [] ],200); 
    }

    public function update_pin(Request $request){

        $request->validate([
          'pin' => 'required|numeric|digits:4'
        ]);

        $wallet = Wallet::where('user_id', auth()->user()->id)->first();

        $wallet->pin = $request->pin;

        if($wallet->save()){
          $walletHistory = WalletHistory::where('wallet_id', $wallet->id)->get();

          if($walletHistory->isEmpty()){
            return $this->success(['walletHistory' => []], "Wallet pin updated successfully");
          }else{
            return $this->success(['walletHistory' => WalletResource::collection($walletHistory)], "Wallet pin updated successfully");
          }
        }else{
          return $this->error(null, 'Error Wallet pin details', 422);
        }
      }

     public function checkPinExists(){

            // Find the wallet by its ID
            $wallet = Wallet::where('user_id', auth()->user()->id)->first();

            // Check if the wallet exists and if the PIN is null
            if ($wallet && is_null($wallet->pin)) {
                // PIN is null
                return $this->error(['message' =>false], 'Wallet pin was not set by user', 422);
            } else {
                // PIN is not null
                return $this->success(['message' =>true], "This user has set his wallet pin");
            }
     }


     public function validate_pin(Request $request){

        $request->validate([
          'pin' => 'required|numeric|digits:4'
        ]);
        // Here Find the wallet by its ID
        $wallet = Wallet::where(['user_id' => auth()->user()->id, 'pin'=>$request->pin])->first();

        // Naso Check if the wallet exists and if the PIN is null
        if ($wallet) {
            // PIN is null
            return $this->success(['pin' =>$wallet->pin], "Correct pin code");
        } else {
            // PIN is not null
            return $this->error([], 'Pin code is not correct', 422);
        }
 }

    public function fetchContact(Request $request){

        $request->validate([
            'email_or_phone' => 'required'
          ]);

             // Here Find the wallet by its ID
        $user = User::where('email', $request->email_or_phone)->orWhere('phone', $request->email_or_phone)->first();


        if(in_array($user, [ $user->email,  $user->phone])){
            return $this->error([], 'you cant lookup to yourself', 422);

        }

        // Naso Check if the wallet exists and if the PIN is null
        if ($user) {
            // PIN is null
            return $this->success(['user' =>$user], "Current Fetch User");
        } else {
            // PIN is not null
            return $this->error([], 'Unable to fetch user', 422);
        }
    }

    public function requestMoney(Request $request)
    {
        $userId = $request->input('user_id');
        $amount = $request->input('amount');
        $comment = $request->input('note');
    
        // Validate the inputs
        $request->validate([
            'user_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'comment' => 'nullable|string|max:255',
        ]);
    
        // Create a new request payment
        $requestPayment = RequestPayment::create([
            'user_id' => $userId,
            'receiver_id' =>auth()->id(),
            'amount' => $amount,
            'comment' => $comment,
            'status' => 'Pending', // Set the default status
        ]);
    
        // Return a success response
        return response()->json([
            'message' => 'Request payment created successfully',
            'request_payment' => $requestPayment,
        ]);
    }
    

    public function listBeneficiaryBankDetails() {
        $banks = BeneficiaryBankDetail::where('user_id', Auth::user()->id)->get();
        return response()->json(['status' => 1, 'data' => $banks], 200);
    }
    
    public function removeBeneficiaryBankDetails(Request $request) {
        $banks = BeneficiaryBankDetail::where(['user_id' => Auth::user()->id, 'id' => $request->id])->first();
        $banks->delete();
        return response()->json(['status' => 1, 'message' => 'Beneficiary account removed successfully'], 200);
    }


    public function requestInbox(Request $request){

      $perPage = $request->input('per_page', 10);

      $requestPayment =  RequestPayment::where('receiver_id',auth()->id())->where('status','Pending')->paginate($perPage);

      if($requestPayment){

          return RequestPaymentResource::collection($requestPayment);
          
    //   return response()->json(['status'=>true,'data'=> RequestPaymentResource::collection($requestPayment)],200);

    } else{
        
        return response()->json(['status'=>false, 'message' => 'No Data Found.', 'data'=> [] ],200); 
    }
    }

    public function sendRequest(){

        
    }


}
