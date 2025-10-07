<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('lesson')->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $lessons = Lesson::all();
        return view('admin.quizzes.create', compact('lessons'));
    }

    public function store(Request $request)
{
    $request->validate([
        'lesson_id' => 'required|exists:lessons,id',
        'title' => 'required|string|max:255',
        'question_limit' => 'nullable|integer|min:1',
    ]);

    Quiz::create([
        'lesson_id' => $request->lesson_id,
        'title' => $request->title,
        'question_limit' => $request->question_limit,
    ]);

    return redirect()->route('admin.quizzes.index')->with('success', 'Quiz created successfully.');
}

    public function edit(Quiz $quiz)
    {
        $lessons = Lesson::all();
        return view('admin.quizzes.edit', compact('quiz', 'lessons'));
    }

    public function update(Request $request, Quiz $quiz)
{
    $request->validate([
        'lesson_id' => 'required|exists:lessons,id',
        'title' => 'required|string|max:255',
        'question_limit' => 'nullable|integer|min:1',
    ]);

    $quiz->update([
        'lesson_id' => $request->lesson_id,
        'title' => $request->title,
        'question_limit' => $request->question_limit,
    ]);

    return redirect()->route('admin.quizzes.index')->with('success', 'Quiz updated successfully.');
}
}
