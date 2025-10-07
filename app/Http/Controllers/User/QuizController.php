<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('lesson')->get();
        return view('user.quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz)
    {
        $quiz->load('questions.answers');
        return view('user.quizzes.show', compact('quiz'));
    }

   public function submit(Request $request, Quiz $quiz)
{
    $userId = auth()->id();
    $total = $quiz->questions->count();
    $score = 0;

    $result = QuizResult::create([
        'quiz_id' => $quiz->id,
        'user_id' => $userId,
        'score' => 0,
        'total' => $total,
    ]);

    foreach ($quiz->questions as $question) {
        $selected = $request->input("answers.{$question->id}", []);

        // Ensure $selected is always an array
        $selected = is_array($selected) ? $selected : [$selected];

        $correctAnswers = $question->answers->where('is_correct', 1)->pluck('id')->toArray();

        // Calculate partial score for this question
        $correctCount = count(array_intersect($selected, $correctAnswers));
        $wrongCount = count(array_diff($selected, $correctAnswers));

        // Simple scoring: each correct selected adds 1, each wrong selected subtracts 1 (or 0 min)
        $questionScore = max($correctCount - $wrongCount, 0);
        $score += $questionScore;

        // Attach selected answers to pivot
        $result->answers()->attach($selected);
    }

    $result->update(['score' => $score]);

    return redirect()->route('user.quizzes.results.summary', [
    'quiz' => $quiz->id,
    'attempt' => $result->id
    ])->with('success', 'Quiz submitted successfully!');
}
    public function start (Quiz $quiz) {
        $questions = $quiz->limitedQuestions()->get();
        return view('user.quizzes.start', compact('quiz', 'questions'));
    }
}
