<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;

class BlogController extends Controller
{


    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $blog = Blog::with('comments')->where(function ($q) use ($key) {
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%")
                    ->orWhere('email', 'like', "%{$key}%");
            })->orWhere('title', 'like', "%{$key}%");
        })->latest()->paginate($perPage);

        return BlogResource::collection($blog);
    }

}
