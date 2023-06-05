<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\FirebaseService;

class PostCommentsController extends Controller
{
    /**
     * @var FirebaseService
     */
    protected $firebaseService;

    /**
     * @param FirebaseService $firebaseService
     */
    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function store(Post $post)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $post->comments()->create([
            'user_id' => request()->user()->id,
            'body' => request('body')
        ]);
        // Push notification admin
        $this->firebaseService->pushMessageAdmin('Haki new comment post');

        return back();
    }
}
