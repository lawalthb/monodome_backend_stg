<?php

namespace App\Http\Controllers\Api\v1\Wallet;

use App\Models\Card;
use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\WalletHistory;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Notifications\SendNotification;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    public function webhooks(Request $request)
    {
        http_response_code(200);

        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $_SERVER) ) exit();

        $input = @file_get_contents("php://input");
        http_response_code(200);

        //get the secretkey from database and check if the hash are thesame else exist
        $secretkey = Setting::where(['slug' => 'secretkey'])->first()->value;
        if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, $secretkey)) exit();



        if ($request['event'] == 'charge.success' && $request['data']['metadata']['custom_fields'][0]['from'] =='wallet') {

            try {
            DB::beginTransaction();
            $data = $request['data'];
            $user = User::where('email', $data['customer']['email'])->first();
            if ($user) {
                if ($user->wallet) {
                    // Update the existing wallet
                    $user->wallet->update([
                        "amount" => $user->wallet->amount + ($data['amount'] / 100),
                        "status" => "active",
                    ]);

                    // Create a wallet history entry
                    $walletHistory = new WalletHistory;
                    $walletHistory->wallet_id = $user->wallet->id;
                    $walletHistory->user_id =  $user->id;
                    $walletHistory->type = "deposit";
                    $walletHistory->paystack_reference =  $data["reference"];
                    $walletHistory->payment_type = "paystack";
                    $walletHistory->amount = $data['amount'] / 100;
                    $walletHistory->closing_balance = $user->wallet->amount;
                    $walletHistory->fee = $data['fees']/ 100;
                    $walletHistory->description = "Paystack deposit via wallet";
                    $walletHistory->save();

                    // Check if the user has a card and update its details
                    $card = Card::where('user_id', $user->id)->first();
                    if ($card) {
                        $card->auth_token = $data['authorization']['authorization_code'];
                        $card->customer_code = $data['customer']['customer_code'];
                        $card->save();
                    }
                } else {
                    // Create a new wallet
                    $wallet = new Wallet;
                    $wallet->amount = $data['amount'] / 100;
                    $wallet->status = 'active';
                    $wallet->user_id = $user->id;
                    $wallet->save();

                    // Create a wallet history entry
                    $walletHistory = new WalletHistory;
                    $walletHistory->wallet_id = $wallet->id;
                    $walletHistory->user_id = $user->id;
                    $walletHistory->type = "deposit";
                    $walletHistory->payment_type = "paystack";
                    $walletHistory->amount = $data['amount'] / 100;
                    $walletHistory->closing_balance = $wallet->amount;
                    $walletHistory->fee = $data['fees'];
                    $walletHistory->description = "Paystack deposit";
                    $walletHistory->save();

                    // Check if the user has a card and update its details
                    $card = Card::where('user_id', $user->id)->first();
                    if ($card) {
                        $card->auth_token = $data['authorization']['authorization_code'];
                        $card->customer_code = $data['customer']['customer_code'];
                        $card->save();
                    }
                }
                DB::commit();
            }

        } catch (\Throwable $th) {
            DB::rollBack();
           Log::info($th->getMessage());
        }

        }elseif($request['event'] == 'charge.success' && $request['data']['metadata']['custom_fields'][0]['from'] =='order'){

            Log::info("inside order");
            Log::info($request['data']);
            // Log::info($request['event']);

            // $data = $request['data'];
            // $order_no = $request['data']['metadata']['order_no'];

            // $order = Order::where("order_no",$order_no)->first();
            // $order->payment_type = 'online';
            // $order->payment_status = 'Paid';
            // $order->save();
            // $order->user->notify(new SendNotification($order->user, 'Your wallet payment order was successful!'));

            $orderNo = $request['data']['metadata']['order_no'];
            $order = Order::find($orderNo);

            if ($order) {
                $order->update([
                    'payment_type' => 'online',
                    'payment_status' => 'Paid',
                ]);

                $order->user->notify(new SendNotification($order->user, 'Your paystack online payment order was successful!'));
            }

        }

        http_response_code(200);

        return response()->json(['message' => 'Webhook received successfully'], 200);
    }

}
