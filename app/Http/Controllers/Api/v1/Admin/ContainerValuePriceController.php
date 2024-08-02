<?php

namespace App\Http\Controllers\Api\v1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CarsContainerValuePrice;
use App\Models\OtherContainerValuePrice;

class ContainerValuePriceController extends Controller
{
    // Determine which model to use based on a parameter in the request
    protected function getModel($type)
    {
        switch ($type) {
            case 'other':
                return new OtherContainerValuePrice();
            case 'cars':
                return new CarsContainerValuePrice();
            default:
                throw new \Exception("Invalid type specified");
        }
    }

    // Display a listing of the resource.
    public function index(Request $request)
    {
        $type = $request->get('type');
        $model = $this->getModel($type);

        // Number of items per page, default is 15
        $perPage = $request->get('per_page', 15);

        $items = $model->paginate($perPage);

        return response()->json($items);
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $type = $request->get('type');
        $model = $this->getModel($type);

        $data = $request->validate([
            'min' => 'required|numeric',
            'max' => 'required|numeric',
            'price' => 'required|numeric',
            'status' => 'required|string'
        ]);

        $createdItem = $model->create($data);

        return response()->json($createdItem, 201);
    }

    // Display the specified resource.
    public function show(Request $request, $id)
    {
        $type = $request->get('type');
        $model = $this->getModel($type);

        $item = $model->findOrFail($id);

        return response()->json($item);
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $type = $request->get('type');
        $model = $this->getModel($type);

        $data = $request->validate([
            'min' => 'numeric',
            'max' => 'numeric',
            'price' => 'numeric',
            'status' => 'string'
        ]);

        $item = $model->findOrFail($id);
        $item->update($data);

        return response()->json($item);
    }

    // Remove the specified resource from storage.
    public function destroy(Request $request, $id)
    {
        $type = $request->get('type');
        $model = $this->getModel($type);

        $item = $model->findOrFail($id);
        $item->delete();

        return response()->json(null, 204);
    }
}
