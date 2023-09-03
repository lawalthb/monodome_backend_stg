<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Requests\OfficeRequest;
use App\Http\Requests\OfficeResource;

class OfficeController extends Controller
{
    use ApiStatusTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $offices = Office::where(function ($q) use ($key) {
            $q->where('name', 'like', "%{$key}%")
                ->orWhere('address', 'like', "%{$key}%");
        })->with(['agent', 'country', 'state'])
            ->latest()
            ->paginate($perPage);

        return OfficeResource::collection($offices);
    }

    public function show($id)
    {
        $office = Office::with(['agent', 'country', 'state'])->find($id);

        if (!$office) {
            return $this->error(null, 'Office not found', 404);
        }

        return $this->success(
            [
                'office' => new OfficeResource($office),
            ],
            'Retrieved Successfully'
        );
    }

    public function store(OfficeRequest $request)
    {
        $validatedData = $request->validated();

        $office = Office::create($validatedData);

        return $this->success(
            [
                'office' => new OfficeResource($office),
            ],
            'Created Successfully'
        );
    }

    public function update(OfficeRequest $request, $id)
    {
        $office = Office::find($id);

        if (!$office) {
            return $this->error(null, 'Office not found', 404);
        }

        $office->update($request->validated());

        return $this->success(
            [
                'office' => new OfficeResource($office),
            ],
            'Updated Successfully'
        );
    }

    public function destroy($id)
    {
        $office = Office::find($id);

        if (!$office) {
            return $this->error(null, 'Office not found', 404);
        }

        $office->delete();

        return $this->success(null, 'Deleted Successfully');
    }


}
