<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class AdminCategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::paginate(50)
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store()
    {
        Category::create(array_merge($this->validateCategory(), [
            'user_id' => request()->user()->id,
            'thumbnail' => request()->file('thumbnail')->store('thumbnails')
        ]));

        return redirect('/');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(Category $category)
    {
        $attributes = $this->validateCategory($category);

        $category->update($attributes);

        return back()->with('success', 'Category Updated!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category Deleted!');
    }

    protected function validateCategory(?Category $category = null): array
    {
        $category ??= new Category();

        return request()->validate([
            'name' => 'required'
        ]);
    }
}
