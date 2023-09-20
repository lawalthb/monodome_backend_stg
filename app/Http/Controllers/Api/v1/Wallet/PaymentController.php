<?php

namespace App\Http\Controllers\Api\v1\Wallet;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{

    public function webhooks(Request $request){
        $data = $request['data'];
      //  Storage::disk('local')->put('file-'.$data['customer']['customer_code'].'-'.$request['event'].'.txt', json_encode($request->all()));

        Log::info($request);
        Log::info($data);
        http_response_code(200);


    }
}
