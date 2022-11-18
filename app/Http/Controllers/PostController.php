<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Validation\Rule;
use App\Services\FirebaseService;

class PostController extends Controller
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

    public function index()
    {
        return view('posts.index', [
            'posts' => Post::latest()->filter(
                        request(['search', 'category', 'author'])
                    )->paginate(18)->withQueryString()
        ]);
    }

    public function show(Post $post)
    {
        $post->incrementReadCount();

        // Push notification admin
        $this->firebaseService->pushMessageAdmin('Blog view post: ' . $post->title);

        return view('posts.show', [
            'post' => $post
        ]);
    }
}
