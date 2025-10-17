<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\Quiz;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $categoriesCount = Category::where('user_id', $userId)->count();
        $lessonsCount = Lesson::where('user_id', $userId)->count();
        $quizzesCount = Quiz::where('user_id', $userId)->count();

        $recentLessons = Lesson::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'categoriesCount',
            'lessonsCount',
            'quizzesCount',
            'recentLessons'
        ));
    }
}
