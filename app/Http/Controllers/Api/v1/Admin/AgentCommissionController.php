<?php


namespace App\Http\Controllers\Api\v1\Admin;

use Illuminate\Http\Request;
use App\Models\AgentCommission;
use App\Http\Controllers\Controller;

class AgentCommissionController extends Controller  {


    public function index()
    {
        $commissions = AgentCommission::with('state')::all();
        return response()->json($commissions);
    }

    public function create()
    {
        // Not needed for API-based application
    }


    public function store(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'percentage' => 'required|numeric|between:0,100',
        ]);

        $commission = AgentCommission::create($request->all());
        return response()->json($commission, 201);
    }


    public function show($id)
    {
        $commission = AgentCommission::findOrFail($id);
        return response()->json($commission);
    }

    public function edit($id)
    {
        // Not needed for API-based application
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'percentage' => 'required|numeric|between:0,100',
        ]);

        $commission = AgentCommission::findOrFail($id);
        $commission->update($request->all());
        return response()->json($commission);
    }

    public function destroy($id)
    {
        $commission = AgentCommission::findOrFail($id);
        $commission->delete();
        return response()->json(null, 204);
    }


}
