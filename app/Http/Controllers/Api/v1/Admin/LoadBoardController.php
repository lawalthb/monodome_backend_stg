<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\LoadBoard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadBoardRequest;
use App\Http\Resources\LoadBoardResource;

class LoadBoardController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index(Request $request)
    {

        $query = LoadBoard::query();

       // Filter by Cargo Type
        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }

        // // Filter by Country
        // if ($request->has('country')) {
        //     $query->where('country', $request->input('country'));
        // }

        // // Filter by Pickup Distance
        // if ($request->has('pickup_distance')) {
        //     $query->where('pickup_distance', $request->input('pickup_distance'));
        // }

        $loadBoards = $query->get();

        return LoadBoardResource::collection($loadBoards);
        // return $this->success(['loadBoards' => $loadBoards], 'Load boards retrieved successfully');
    }


     /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoadBoard  $loadBoard
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LoadBoard $loadBoard)
    {
        return $this->success(['loadBoard' => $loadBoard], 'Load board retrieved successfully');
    }


    public function store(LoadBoardRequest $request)
    {
        $data = $request->validated();
       // $data['uuid'] = Str::uuid()->toString();

        $loadBoard = LoadBoard::create($data);

        return $this->success(['loadBoard' => $loadBoard], 'Load board created successfully');
    }


    public function update(LoadBoardRequest $request, LoadBoard $loadBoard)
    {
        $data = $request->validated();
        $loadBoard->update($data);

        return $this->success(['loadBoard' => $loadBoard], 'Load board updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoadBoard  $loadBoard
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LoadBoard $loadBoard)
    {
        $loadBoard->delete();

        return $this->success(null, 'Load board deleted successfully');
    }


    public function status(Request $request, LoadBoard $loadBoard)
{
   // $loadBoard = LoadBoard::where("order_no",$status)->first();

    $loadBoard->status = $request->status;

    if($loadBoard->save()){
        return response()->json([
            'data' => new LoadBoardResource($loadBoard),
        ],200);
    }else{
        return response()->json([
            'error' => "unable to update the status.",
        ],400);
    }


}
}
