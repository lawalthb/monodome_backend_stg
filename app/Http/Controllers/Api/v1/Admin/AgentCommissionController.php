<?php


namespace App\Http\Controllers\Api\v1\Admin;

use Illuminate\Http\Request;
use App\Models\AgentCommission;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AgentCommissionResource;

class AgentCommissionController extends Controller  {


    public function index()
    {
        $commissions = AgentCommission::with('state')->paginate();
        return AgentCommissionResource::collection($commissions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'percentage' => 'required|numeric|between:0,100',
        ]);

        $commission = AgentCommission::create($request->all());
        return new AgentCommissionResource($commission);
    }


    public function show($id)
    {
        $commission = AgentCommission::with('state')->findOrFail($id);
        return new AgentCommissionResource($commission);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'percentage' => 'required|numeric|between:0,100',
        ]);

        $commission = AgentCommission::findOrFail($id);
        $commission->update($request->all());
        return new AgentCommissionResource($commission);
    }

    public function destroy($id)
    {
        $commission = AgentCommission::findOrFail($id);
        $commission->delete();
        return response()->json(null, 204);
    }


}
