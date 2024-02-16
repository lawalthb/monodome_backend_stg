<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {   
        $categories = Category::all();

        if($categories){

            return CategoryResource::collection($categories);
        }else{
            return response()->json("No categories", 404);
        }
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return new CategoryResource($category);
    }

    public function show(Category $category)
    {

        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json("Deleted", 204);
    }

    public function setStatus(Request $request, $id){
        
        $blog =  Category::find($id);
        $blog->status = $request->status;
        if($blog->save()){

            return new CategoryResource($blog);
        }else{
            return response()->json(['message' => 'Unable to change Blog status'],404);

        }
    }
}


