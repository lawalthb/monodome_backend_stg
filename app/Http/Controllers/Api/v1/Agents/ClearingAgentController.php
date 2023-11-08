<?php

namespace App\Http\Controllers\Api\v1\Agents;

use App\Models\LoadBoard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoadBoardResource;

class ClearingAgentController extends Controller
{
    //

    public function broadcast(Request $request)
    {
        $query = LoadBoard::orderBy('created_at', 'desc');

        // Filter by Order Number
        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }
        $perPage = $request->input('per_page', 10); // Number of items per page, defaulting to 10.

        $loadBoards = $query->whereIn('load_type_id',[3,4])->latest()->paginate($perPage);

        return LoadBoardResource::collection($loadBoards);
    }

    public function singleBroadcast(Request $request, $id)
    {
        $query = LoadBoard::where("id", $id)->whereIn('load_type_id',[3,4]);

        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }

        $loadBoard = $query->first();

        if ($loadBoard) {
            return new LoadBoardResource($loadBoard);
        } else {
            return response()->json(['message' => 'LoadBoard record not found'], 404);
        }
    }

}
