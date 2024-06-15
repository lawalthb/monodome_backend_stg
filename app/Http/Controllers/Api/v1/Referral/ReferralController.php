<?php

namespace App\Http\Controllers\Api\v1\Referral;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReferralController extends Controller
{

  public function listReferrals()
  {

    $userIds = Referral::select('referred_user_id')->distinct()->pluck('referred_user_id');
    $refferalUsers = User::whereIn('id', $userIds)->paginate(10);
    return response()->json($refferalUsers);
  }


  public function viewRefeeres($referred_user_id)
  {

    $viewRefeeres = Referral::with('user')->where('referred_user_id', $referred_user_id)->paginate(10);
    return response()->json($viewRefeeres);
  }
}
