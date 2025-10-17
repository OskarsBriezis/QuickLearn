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
        $userId = auth()->id();

        $quizzes = Quiz::with('lesson')
            ->where('user_id', $userId)
            ->get();

        return view('user.quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz)
    {
        $this->authorizeQuizAccess($quiz);

        $quiz->load('questions.answers');
        return view('user.quizzes.show', compact('quiz'));
    }

    public function start(Quiz $quiz)
    {
        $this->authorizeQuizAccess($quiz);

        $questions = $quiz->limitedQuestions()->get();
        return view('user.quizzes.start', compact('quiz', 'questions'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $this->authorizeQuizAccess($quiz);

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
            $selected = is_array($selected) ? $selected : [$selected];

            $correctAnswers = $question->answers->where('is_correct', 1)->pluck('id')->toArray();

            $correctCount = count(array_intersect($selected, $correctAnswers));
            $wrongCount = count(array_diff($selected, $correctAnswers));
            $questionScore = max($correctCount - $wrongCount, 0);
            $score += $questionScore;

            $result->answers()->attach($selected);
        }

        $result->update(['score' => $score]);

        return redirect()->route('user.quizzes.results.summary', [
            'quiz' => $quiz->id,
            'attempt' => $result->id
        ])->with('success', 'Quiz submitted successfully!');
    }

    private function authorizeQuizAccess(Quiz $quiz)
    {
        if ($quiz->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this quiz.');
        }
    }
}
