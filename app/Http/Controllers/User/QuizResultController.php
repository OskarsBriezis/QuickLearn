<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizResult;

class QuizResultController extends Controller
{
    // 1️⃣ All categories with attempted quizzes
    public function historyCategories()
    {
        $userId = auth()->id();

        $categories = Category::whereHas('lessons.quizzes.results', fn($q) => $q->where('user_id', $userId))->get();

        return view('user.results.history.history_categories', compact('categories'));
    }

    // 2️⃣ Quizzes attempted in a specific category
    public function historyQuizzes(Category $category)
    {
        $userId = auth()->id();

        $quizzes = QuizResult::with('quiz')
            ->where('user_id', $userId)
            ->whereHas('quiz.lesson', fn($q) => $q->where('category_id', $category->id))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.results.history.history_quizzes', compact('category', 'quizzes'));
    }

    // 3️⃣ Single quiz attempt
    public function show(Quiz $quiz, $attemptId)
{
    $userId = auth()->id();

    // Load the specific attempt
    $result = QuizResult::where('id', $attemptId)
        ->where('quiz_id', $quiz->id)
        ->where('user_id', $userId)
        ->firstOrFail();

    // Load questions and answers
    $quiz->load('questions.answers');

    // Calculate total points for the quiz
    $totalPoints = $quiz->questions->sum('points');

    // Calculate earned points
    $earnedPoints = 0;
    foreach ($quiz->questions as $question) {
        $userAnswers = $result->answers->where('question_id', $question->id)->pluck('answer_id')->toArray();
        $correctAnswers = $question->answers->where('is_correct', 1)->pluck('id')->toArray();

        // User must select exactly all correct answers to earn the points
        if (collect($userAnswers)->sort()->values()->toArray() === collect($correctAnswers)->sort()->values()->toArray()) {
            $earnedPoints += $question->points;
        }
    }

    // Attach scores to result for the view
    $result->total = $totalPoints;
    $result->score = $earnedPoints;

    return view('user.results.history.show', compact('quiz', 'result'));
}

    public function summary(Quiz $quiz, $attemptId)
    {
        $userId = auth()->id();

        // Load the specific attempt
        $result = QuizResult::where('id', $attemptId)
            ->where('quiz_id', $quiz->id)
            ->where('user_id', $userId)
            ->firstOrFail();

        // Load questions and answers
        $quiz->load('questions.answers');

        return view('user.results.summary', compact('quiz', 'result'));
    }

}
