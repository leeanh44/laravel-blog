<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::paginate(50)
        ]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(User $user)
    {
        $attributes = $this->validateUser($user);

        $user->update($attributes);

        return back()->with('success', 'User Updated!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User Deleted!');
    }

    protected function validateUser(?User $user = null): array
    {
        $user ??= new User();

        return request()->validate([
            'username' => 'required',
            'name' => 'required',
            'email' => 'required'
        ]);
    }
}
