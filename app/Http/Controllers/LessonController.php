<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $lessons = \App\Models\Lesson::with('category')->latest()->paginate(10);
    return view('admin.lessons.index', compact('lessons'));
}

public function create()
{
    $categories = \App\Models\Category::orderBy('name')->get();
    return view('admin.lessons.create', compact('categories'));
}

public function store(\Illuminate\Http\Request $request)
{
    $data = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title'       => 'required|string|max:255',
        'content'     => 'required|string',
        'media_url'   => 'nullable|url',
        'published'   => 'nullable|boolean',
    ]);
    $data['published'] = $request->boolean('published');
    \App\Models\Lesson::create($data);
    return redirect()->route('admin.lessons.index')->with('success', 'Lesson created.');
}

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Lesson $lesson)
{
    $categories = \App\Models\Category::orderBy('name')->get();
    return view('admin.lessons.edit', compact('lesson', 'categories'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, \App\Models\Lesson $lesson)
{
    $data = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title'       => 'required|string|max:255',
        'content'     => 'required|string',
        'media_url'   => 'nullable|url',
        'published'   => 'nullable|boolean',
    ]);
    $data['published'] = $request->boolean('published');
    $lesson->update($data);
    return redirect()->route('admin.lessons.index')->with('success', 'Lesson updated.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Lesson $lesson)
{
    $lesson->delete();
    return back()->with('success', 'Lesson deleted.');
}
}
