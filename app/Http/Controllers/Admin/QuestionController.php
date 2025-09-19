<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
{
    $quizzes = Quiz::withCount('questions')->get();

    $questionsQuery = Question::with('quiz', 'answers');

    if ($request->quiz_id) {
        $questionsQuery->where('quiz_id', $request->quiz_id);
    }

    $questions = $questionsQuery->get();

    return view('admin.questions.index', compact('quizzes', 'questions'));
}





    public function create()
    {
        $quizzes = Quiz::all(); // dropdown to assign a question to a quiz
        return view('admin.questions.create', compact('quizzes'));
    }

    public function store(Request $request)
{
    $request->validate([
        'quiz_id' => 'required|exists:quizzes,id',
        'questions' => 'required|array|min:1',
        'questions.*.text' => 'required|string|max:255',
        'questions.*.answers' => 'required|array|min:2',
        'questions.*.answers.*.text' => 'required|string|max:255',
    ]);

    foreach ($request->questions as $qData) {
        // Save question
        $question = Question::create([
            'quiz_id' => $request->quiz_id,
            'question_text' => $qData['text'],
        ]);

        // Save answers
        foreach ($qData['answers'] as $answer) {
            \App\Models\Answer::create([
                'question_id' => $question->id,
                'text' => $answer['text'],
                'is_correct' => isset($answer['is_correct']) ? 1 : 0,
            ]);
        }
    }

    return redirect()->route('admin.questions.index')
        ->with('success', 'Questions and answers created successfully.');
}



    public function edit(Question $question)
{
    $quizzes = Quiz::all();
    $question->load('answers'); // Eager load answers
    return view('admin.questions.edit', compact('question', 'quizzes'));
}

    public function update(Request $request, Question $question)
{
    $request->validate([
        'quiz_id' => 'required|exists:quizzes,id',
        'question_text' => 'required|string|max:255',
        'answers' => 'required|array|min:2',
        'answers.*.text' => 'required|string|max:255',
    ]);

    // Update question
    $question->update([
        'quiz_id' => $request->quiz_id,
        'question_text' => $request->question_text,
    ]);

    // Delete old answers (simpler)
    $question->answers()->delete();

    foreach ($request->answers as $answer) {
        \App\Models\Answer::create([
            'question_id' => $question->id,
            'text' => $answer['text'],
            'is_correct' => isset($answer['is_correct']) ? 1 : 0,
        ]);
    }

    return redirect()->route('admin.questions.index')
        ->with('success', 'Question updated successfully.');
}



    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully.');
    }

    public function show(Question $question)
{
    $question->load('answers'); // eager load answers
    return view('admin.questions.show', compact('question'));
}


public function destroyAll(Request $request)
{
    $quizId = $request->quiz_id;

    if (!$quizId) {
        return redirect()->route('admin.questions.index')->with('success', 'No quiz selected.');
    }

    Question::where('quiz_id', $quizId)->delete();

    return redirect()->route('admin.questions.index', ['quiz_id' => $quizId])
                     ->with('success', 'All questions for the selected quiz have been deleted.');
}

}
