<?php

namespace App\Http\Controllers\Api\v1\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;



    public function index()
{
    $posts = Blog::with('comments')->get();
    return response()->json(['posts' => $posts]);
}
}
