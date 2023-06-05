<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FirebaseService;

class RegisterController extends Controller
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

    public function create()
    {
        return view('register.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:7|max:255',
        ]);

        auth()->login(User::create($attributes));
        // Push notification admin
        $this->firebaseService->pushMessageAdmin('Haki register new account');

        return redirect('/')->with('success', 'Your account has been created.');
    }
}
