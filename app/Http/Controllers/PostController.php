<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return PostResource::collection($posts);
    }
    public function show($id)
    {
        $post = Post::with('writer:id,username,email')->findOrFail($id);
        return new PostDetailResource($post);
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'news_content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $authorId = Auth::id();

        $postCreate = new Post();
        $postCreate->title = $request->title;
        $postCreate->news_content = $request->news_content;
        $postCreate->author = $authorId;
        $postCreate->created_at = now();

        $postCreate->save();

        return new PostResource($postCreate);
    }
    public function delete($id)
    {
        $postDelete = Post::find($id);

        if (!$postDelete) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $authorId = Auth::id();

        if ($postDelete->author !== $authorId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $postDelete->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
