<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Quiz;

class DashboardController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('category')->where('published', true)->get();
        $quizzes = Quiz::with('questions', 'lesson')->get();
        return view('user.index', compact('lessons', 'quizzes'));
    }
}
