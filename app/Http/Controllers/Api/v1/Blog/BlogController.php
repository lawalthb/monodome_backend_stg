<?php

namespace App\Http\Controllers\Api\v1\Blog;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Requests\BlogRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Notifications\SendNotification;

class BlogController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;


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


    public function pendingBlog(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $blog = Blog::where('status',0)->with('comments')->where(function ($q) use ($key) {
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%")
                    ->orWhere('email', 'like', "%{$key}%");
            })->orWhere('title', 'like', "%{$key}%");
        })->latest()->paginate($perPage);

        return BlogResource::collection($blog);
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);

        return $this->success(
            [
                "post" => new BlogResource($blog),
            ],
            "Article has Successfully been posted"
        );
    }


    public function store(BlogRequest $request)
    {
        $blog = Blog::create([
            'user_id' => auth()->user()->id,
            'title'   => $request->get('title'),
            'body'   => $request->get('body'),
            'image' => $this->uploadFile('blog/', $request->file('image'))
        ]);

        $user = auth()->user();

        $message = "Your Blog article has been posted, awaiting for admin for approval";
        $user->notify(new SendNotification($user, $message));

        return $this->success(
            [
                "post" => new BlogResource($blog),
            ],
            "Article has Successfully been posted"
        );
    }


    public function update(BlogRequest $request, $id)
    {
        $blog = Blog::findOrFail($id);


        if ($request->hasFile('image') && $blog->image !== null) {
            $this->deleteFile($blog->image);
        }

        $blog->update([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            //'image'=> $this->uploadFile('blog/', $request->file('image'))
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile('blog/', $request->file('image'));
            $blog->image = $imagePath;
            $blog->save();
        }

        return $this->success(
            [
                "post" => new BlogResource($blog),
            ],
            "Article has been updated successfully"
        );
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully']);
    }


    public function getComments($blogId)
    {
        $comments = Comment::where('blog_id', $blogId)->get();
        return CommentResource::collection($comments);
    }

    // Store a new comment
    public function storeComment(CommentRequest $request)
    {
        $comment = Comment::create($request->validated());
        return new CommentResource($comment);
    }

    // Update a comment
    public function updateComment(CommentRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update($request->validated());
        return new CommentResource($comment);
    }

    // Delete a comment
    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }

}
