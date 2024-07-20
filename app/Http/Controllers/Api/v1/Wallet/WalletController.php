<?php

namespace App\Http\Controllers\Api\v1\Wallet;

use App\Models\User;
use App\Models\Wallet;
use App\Models\PriceSetting;
use Illuminate\Http\Request;
use App\Models\WalletHistory;
use App\Models\RequestPayment;
use App\Traits\ApiStatusTrait;
use App\Services\WalletService;
use App\Traits\FileUploadTrait;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\BeneficiaryBankDetail;
use App\Http\Resources\WalletResource;
use App\Notifications\SendNotification;
use Illuminate\Support\Facades\Validator;
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
        $user = User::where('email', $request->email_or_phone)->orWhere('phone_number', $request->email_or_phone)->first();


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
        // Validate the inputs
        $request->validate([
            'request_receiver' => ['required', 'integer', Rule::notIn([auth()->id()])],
            'amount' => 'required|numeric|min:0',
            'comment' => 'nullable|string|max:255',
            'type' => 'required|string|in:cash-out,request',
        ]);

        $cashOutUserWallet = Wallet::where("user_id",auth()->id())->first();

        if ($request->type === 'cash-out' && $request->amount > $cashOutUserWallet->amount) {

            return $this->error(null, 'Insufficient funds in wallet', 422);
        }

        // Create a new request payment
        $requestPayment = RequestPayment::create([
            'request_sender' => auth()->id(),
            'request_receiver' => $request->input('request_receiver'),
            'amount' => $request->input('amount'),
            'comment' => $request->input('comment'),
            'type' => $request->input('type'), // Set the type (cash-out or request)
            'status' => 'Pending', // Set the default status
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Request payment created successfully',
            'request_payment' => $requestPayment,
        ]);
    }


    public function approveRequest(Request $request, $id)
{
    // Validate the inputs
    $request->validate([
        'accept_amount' => 'required|numeric|min:0',
        'status' => 'required|string|in:Pending,Success,Refund,Blocked',
        'comment' => 'nullable|string|max:255',
    ]);

    // Find the request payment by ID and ensure it belongs to the authenticated user
    $requestPayment = RequestPayment::where('id', $id)
        ->where('request_receiver', auth()->id())
        ->firstOrFail();

    // Check if the request status is already Refund or Success
    if (in_array($requestPayment->status, ['Refund', 'Success'])) {
        return response()->json(['message' => 'Payment request is already Refund or Successfully!'], 404);
    }

    // Update the request payment status and comment for Refund or Blocked requests
    if (in_array($request->input('status'), ['Blocked'])) {
        $requestPayment->status = $request->input('status');
        $requestPayment->comment = $request->input('comment');
        $requestPayment->save();
        return response()->json(['status' => true, 'data' => new RequestPaymentResource($requestPayment)], 200);
    }

    // Process the request if the status is Success
    if ($request->input('status') === 'Success') {
        // Use a database transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // Lock the receiver's and requester's wallets for update
            $receiverWallet = Wallet::where('user_id', $requestPayment->request_sender)->lockForUpdate()->first();
            $senderWallet = Wallet::where('user_id', $requestPayment->request_receiver)->lockForUpdate()->first();

            // Check if the requester has sufficient funds if it's a cash-out request
            if ($requestPayment->type === 'cash-out' && $request->accept_amount > $senderWallet->amount) {
                return $this->error(null, 'Insufficient funds in wallet in his wallet', 422);
            }

            // Update the wallets using WalletService
            $receiverData = [
                'type' => 'credit',
                'amount' => $request->accept_amount,
                'payment_type' => 'wallet',
                'description' => 'Received payment with the following ID: ' . $requestPayment->uuid,
                'fee' => 0,
            ];

            $senderData = [
                'type' => 'debit',
                'amount' => $request->accept_amount,
                'payment_type' => 'wallet',
                'description' => 'Sent payment with the following ID: ' . $requestPayment->uuid,
                'fee' => 0,
            ];

            WalletService::updateWallet($receiverWallet->user, $receiverData);
            WalletService::updateWallet($senderWallet->user, $senderData);

            // Update the request payment details
            $requestPayment->accept_amount = $request->accept_amount;
            $requestPayment->status = 'Success';
            $requestPayment->comment = $request->input('comment');
            $requestPayment->save();

            DB::commit();

            // Return success response
            return response()->json(['wallet_amount' => $senderWallet->amount, 'requestPayment' => new RequestPaymentResource($requestPayment)]);
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Return a default response if the request does not fall into any of the above conditions
    return response()->json(['message' => 'Request not processed'], 400);
}


    public function transfer_balance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_user_id' => 'required|exists:wallets,user_id',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        $fromWallet = Wallet::where("user_id",auth()->id())->first();
        $toWallet = Wallet::where("user_id",$request->to_user_id)->first();
        $amount = $request->input('amount');

        if ($fromWallet->amount < $amount) {
            return $this->error('', "Insufficient balance", 422);
        }

        WalletService::updateWallet($fromWallet->user, [
            'type' => 'debit',
            'amount' => $amount,
            'payment_type' => 'transfer',
            'description' => 'Transfer to wallet ID ' . $toWallet->id,
        ]);

        WalletService::updateWallet($toWallet->user, [
            'type' => 'credit',
            'amount' => $amount,
            'payment_type' => 'transfer',
            'description' => 'Transfer from wallet ID ' . $fromWallet->id,
        ]);

        return $this->success([], "Balance transferred successfully");
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

      $requestPayment =  RequestPayment::where('request_receiver',auth()->id())->where('status','Pending')->paginate($perPage);

      if($requestPayment){

          return RequestPaymentResource::collection($requestPayment);

    //   return response()->json(['status'=>true,'data'=> RequestPaymentResource::collection($requestPayment)],200);

    } else{

        return response()->json(['status'=>false, 'message' => 'No Data Found.', 'data'=> [] ],200);
    }
    }

    public function sendRequest(Request $request){

      $perPage = $request->input('per_page', 10);

      $requestPayment =  RequestPayment::where('request_sender',auth()->id())->where('status','Pending')->paginate($perPage);

      if($requestPayment){

          return RequestPaymentResource::collection($requestPayment);
    //   return response()->json(['status'=>true,'data'=> RequestPaymentResource::collection($requestPayment)],200);

    } else{
        return response()->json(['status'=>false, 'message' => 'No Data Found.', 'data'=> [] ],200);
    }

    }

    public function allMoneyRequest(Request $request){

        $perPage = $request->input('per_page', 10);
        $requestPayment =  RequestPayment::where('request_sender',auth()->id())->orWhere('request_receiver',auth()->id())->where('status','Pending')->paginate($perPage);

        if($requestPayment){
            return RequestPaymentResource::collection($requestPayment);
      //   return response()->json(['status'=>true,'data'=> RequestPaymentResource::collection($requestPayment)],200);
      } else{
          return response()->json(['status'=>false, 'message' => 'No Data Found.', 'data'=> [] ],200);
      }

      }

    //   public function approveRequest(Request $request, $id)
    //   {
    //       // Validate the inputs
    //       $request->validate([
    //           'accept_amount' => 'required|numeric|min:0',
    //           'status' => 'required|string|in:Pending,Success,Refund,Blocked',
    //           'comment' => 'nullable|string|max:255',
    //       ]);

    //       // Find the request payment by ID and ensure it belongs to the authenticated user
    //       $requestPayment = RequestPayment::where('id', $id)
    //           ->where('request_receiver', auth()->id())
    //           ->firstOrFail();

    //       // Check if the request status is already Refund or Success
    //       if (in_array($requestPayment->status, ['Refund', 'Success'])) {
    //           return response()->json(['message' => 'Payment request is already Refund or Successfully!'], 404);
    //       }

    //       // Update the request payment status and comment for Refund or Blocked requests
    //       if (in_array($request->input('status'), ['Blocked'])) {
    //           $requestPayment->status = $request->input('status');
    //           $requestPayment->comment = $request->input('comment');
    //           $requestPayment->save();
    //           return response()->json(['status' => true, 'data' => new RequestPaymentResource($requestPayment)], 200);
    //       }

    //       // Process the request if the status is Success
    //       if ($request->input('status') === 'Success') {
    //           // Use a database transaction to ensure atomicity
    //           DB::beginTransaction();

    //           try {
    //               // Lock the receiver's and requester's wallets for update
    //               $receiverWallet = Wallet::where('user_id', $requestPayment->request_sender)->lockForUpdate()->first();
    //               $senderWallet = Wallet::where('user_id', $requestPayment->request_receiver)->lockForUpdate()->first();

    //               // Check if the requester has sufficient funds
    //               if ($request->accept_amount > $senderWallet->amount) {
    //                   throw new \Exception('Insufficient funds in wallet');
    //               }

    //               // Update the wallets using WalletService
    //               $receiverData = [
    //                   'type' => 'credit',
    //                   'amount' => $request->accept_amount,
    //                   'payment_type' => 'wallet',
    //                   'description' => 'Received payment with the following ID: ' . $requestPayment->uuid,
    //                   'fee' => 0,
    //               ];

    //               $senderData = [
    //                   'type' => 'debit',
    //                   'amount' => $request->accept_amount,
    //                   'payment_type' => 'wallet',
    //                   'description' => 'Sent payment with the following ID: ' . $requestPayment->uuid,
    //                   'fee' => 0,
    //               ];

    //               WalletService::updateWallet($receiverWallet->user, $receiverData);
    //               WalletService::updateWallet($senderWallet->user, $senderData);

    //               // Update the request payment details
    //               $requestPayment->accept_amount = $request->accept_amount;
    //               $requestPayment->status = 'Success';
    //               $requestPayment->comment = $request->input('comment');
    //               $requestPayment->save();

    //               DB::commit();

    //               // Return success response
    //               return response()->json(['wallet_amount' => $senderWallet->amount, 'requestPayment' => new RequestPaymentResource($requestPayment)]);
    //           } catch (\Exception $e) {
    //               // Roll back the transaction on error
    //               DB::rollBack();
    //               return response()->json(['error' => $e->getMessage()], 500);
    //           }
    //       }

    //       // Return a default response if the request does not fall into any of the above conditions
    //       return response()->json(['message' => 'Request not processed'], 400);
    //   }


    //   public function approveRequest(Request $request, $id)
    //   {
    //       // Validate the inputs
    //       $request->validate([
    //           'accept_amount' => 'required|integer',
    //           'status' => 'required|string|in:Pending,Success,Refund,Blocked',
    //           'comment' => 'nullable|string|max:255',
    //       ]);

    //       // Find the request payment
    //       $requestPayment = RequestPayment::where("receiver_id", auth()->id())->findOrFail($id);

    //       if(in_array($requestPayment->status, ['Refund', 'Success'])){

    //         return $this->error('', 'payment request is already Refund or Successfully!', 404);

    //         // return response()->json(['status' => true, 'data' => new RequestPaymentResource($requestPayment)], 200);
    //       }

    //     //   if (in_array($requestPayment->status, ['Refund', 'Blocked'])) {
    //       if (in_array($requestPayment->status, ['Blocked'])) {
    //           // Update status and comment for Refund or Blocked requests
    //           $requestPayment->status = $request->status;
    //           $requestPayment->comment = $request->comment;
    //           $requestPayment->save();
    //           return response()->json(['status' => true, 'data' => new RequestPaymentResource($requestPayment)], 200);
    //       }

    //       if ($request->status === "Success") {
    //           // Use a database transaction to ensure atomicity
    //           DB::beginTransaction();

    //           try {
    //               // Lock the user's wallet row for update
    //               $wallet = Wallet::where('user_id', $requestPayment->receiver_id)->lockForUpdate()->first();

    //               // Check if the user has sufficient funds
    //               if ($requestPayment->accept_amount > $wallet->amount) {
    //                   throw new \Exception('Insufficient funds in wallet');
    //               }

    //               // Update the wallet balance
    //               $wallet->amount -= $requestPayment->accept_amount;
    //               $wallet->save();

    //               // Update the request payment status and save
    //               $requestPayment->status = $request->status;
    //               $requestPayment->comment = $request->comment;
    //               $requestPayment->save();

    //               // Update wallet history
    //             $walletHistory = new WalletHistory;
    //             $walletHistory->wallet_id = $requestPayment->receiver->wallet->id;
    //             $walletHistory->user_id = $requestPayment->receiver->id;
    //             $walletHistory->type = "debit";
    //             $walletHistory->payment_type = "wallet";
    //             $walletHistory->amount = $requestPayment->accept_amount;
    //             $walletHistory->closing_balance = $requestPayment->receiver->wallet->amount - $requestPayment->accept_amount;
    //             $walletHistory->fee = 0;
    //             $walletHistory->description = "Request Payment with the following ID: " . $requestPayment->uuid . "!";
    //             $walletHistory->save();

    //             // Notify the user
    //             $requestPayment->receiver->notify(new SendNotification($requestPayment->receiver, 'Request payment was successful!'));

    //             DB::commit();

    //               // Return success response
    //               return response()->json(['wallet_amount' => $wallet->amount, 'requestPayment' =>  new RequestPaymentResource($requestPayment)]);
    //           } catch (\Exception $e) {
    //               // Roll back the transaction on error
    //               DB::rollBack();

    //               return response()->json(['error' => $e->getMessage()], 500);
    //           }
    //       }

    //       // Return a default response if the request does not fall into any of the above conditions
    //       return response()->json(['message' => 'Request not processed'], 400);
    //   }


      public function topUpWallet(Request $request){


      }

      public static function getWalletGrossVolume($user_id)
    {
        $sql = "SELECT IFNULL(SUM(amount), 0) AS total FROM wallet_transactions WHERE user_id = :ID AND type='credit'";

        $result = DB::select($sql, ['ID' => $user_id]);

        return $result;
    }

    public static function getWalletTotalTransactions($user_id)
    {
        $sql = "SELECT IFNULL(COUNT(*), 0) AS total FROM wallet_transactions WHERE user_id = :ID";

        $result = DB::select($sql, ['ID' => $user_id]);

        return $result;
    }

}
