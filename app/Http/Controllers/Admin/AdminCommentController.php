<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Http\Controllers\Controller;

class AdminCommentController extends Controller
{
    public function index()
    {
        return view('admin.comments.index', [
            'comments' => Comment::with(['author:id,name', 'post:id,slug,title'])->paginate(50)
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Comment Deleted!');
    }
}
