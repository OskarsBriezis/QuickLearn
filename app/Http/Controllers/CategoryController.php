<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $categories = \App\Models\Category::latest()->paginate(10);
    return view('admin.categories.index', compact('categories'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('admin.categories.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'description' => 'nullable|string',
    ]);
    \App\Models\Category::create($data);
    return redirect()->route('admin.categories.index')->with('success', 'Category created.');
}

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Category $category)
{
    return view('admin.categories.edit', compact('category'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, \App\Models\Category $category)
{
    $data = $request->validate([
        'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        'description' => 'nullable|string',
    ]);
    $category->update($data);
    return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Category $category)
{
    $category->delete();
    return back()->with('success', 'Category deleted.');
}
}
