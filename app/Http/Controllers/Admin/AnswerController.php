<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index()
    {
        $answers = Answer::with('question')->get();
        return view('admin.answers.index', compact('answers'));
    }

    public function create()
    {
        $questions = Question::all();
        return view('admin.answers.create', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required|string|max:255',
            'is_correct' => 'nullable|boolean'
        ]);

        Answer::create([
            'question_id' => $request->question_id,
            'answer_text' => $request->answer_text,
            'is_correct' => $request->has('is_correct')
        ]);

        return redirect()->route('admin.answers.index')->with('success', 'Answer created successfully.');
    }

    public function edit(Answer $answer)
    {
        $questions = Question::all();
        return view('admin.answers.edit', compact('answer', 'questions'));
    }

    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required|string|max:255',
            'is_correct' => 'nullable|boolean'
        ]);

        $answer->update([
            'question_id' => $request->question_id,
            'answer_text' => $request->answer_text,
            'is_correct' => $request->has('is_correct')
        ]);

        return redirect()->route('admin.answers.index')->with('success', 'Answer updated successfully.');
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();
        return redirect()->route('admin.answers.index')->with('success', 'Answer deleted successfully.');
    }
}
