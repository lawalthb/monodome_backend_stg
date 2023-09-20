<?php

namespace App\Http\Controllers\Api\v1\Wallet;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Notifications\SendNotification;
use App\Http\Requests\CardRequest;
use App\Http\Controllers\Controller;

class CardController extends Controller
{

    use ApiStatusTrait, FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = Card::where('user_id', auth()->user()->id)->get();

    // Decrypt sensitive card information in each card
    foreach ($cards as $card) {
        $card->card_number = decrypt($card->card_number);
        $card->cvv = decrypt($card->cvv);
        $card->expiry_month = decrypt($card->expiry_month);
        $card->expiry_year = decrypt($card->expiry_year);
    }

    return $this->success(['cards' => $cards], "All Card details");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CardRequest  $request)
    {
        // if($request->has('card_id')){

        //     $card =  Card::find($request->card_id);

        // }


        $encryptedCard = new Card;
        $encryptedCard->user_id = auth()->user()->id;
        $encryptedCard->type = $request->input('type');
        $encryptedCard->card_number = encrypt($request->input('card_number'));
        $encryptedCard->cvv = encrypt($request->input('cvv'));
        $encryptedCard->name_on_card = $request->input('name_on_card');
        $encryptedCard->expiry_month = encrypt($request->input('expiry_month'));
        $encryptedCard->expiry_year = encrypt($request->input('expiry_year'));

        if($encryptedCard->save()){


        $message ="Your Profile details was save successfully. Thank you for trusting us";
        auth()->user()->notify(new SendNotification(auth()->user(), $message));

            return $this->success(['card' => $encryptedCard], "Card details Save successfully");
        }else{
            return $this->error(null, 'Error saving card details', 422);

        }
        }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $card = Card::findOrFail($id);

        // Decrypt sensitive card information
        // just using normal laravel decrypt
        $card->card_number = decrypt($card->card_number);
        $card->cvv = decrypt($card->cvv);
        $card->expiry_month = decrypt($card->expiry_month);
        $card->expiry_year = decrypt($card->expiry_year);

        return $this->success(['card' => $card], "Card details");


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CardRequest $request, $id)
    {
        $encryptedCard = Card::where(['user_id'=> auth()->user()->id,'id'=>$id])->first();

        // Update card data
        $encryptedCard->user_id = auth()->user()->id;
        $encryptedCard->type = $request->input('type');
        $encryptedCard->card_number = encrypt($request->input('card_number'));
        $encryptedCard->cvv = encrypt($request->input('cvv'));
        $encryptedCard->name_on_card = $request->input('name_on_card');
        $encryptedCard->expiry_month = encrypt($request->input('expiry_month'));
        $encryptedCard->expiry_year = encrypt($request->input('expiry_year'));

        if ($encryptedCard->save()) {
            return $this->success(['card' => $encryptedCard], "Card details updated successfully");
        } else {
            return $this->error(null, 'Error updating card details', 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $encryptedCard = Card::where(['user_id' => auth()->user()->id, 'id' => $id])->first();

    if (!$encryptedCard) {
        return $this->error(null, 'Card not found', 404);
    }

    if ($encryptedCard->delete()) {
        return $this->success(null, "Card deleted successfully");
    } else {
        return $this->error(null, 'Error deleting card', 422);
    }
}

public function payWithExistingCard(Request $request){

    $this->validate($request,[
        "card_id" => 'required|exists,cards',
        "transaction_type" => 'required|in:deposit,withdraw,transfer',
    ]);
    $encryptedCard = Card::where(['user_id'=> auth()->user()->id,'id'=>$request->card_id])->first();
}
}
