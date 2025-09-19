<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('lessons.quizzes')->get();

        // Calculate progress for each category
        $categories->each(function ($category) {
            $completedLessons = $category->lessons->filter(function ($lesson) {
                return $lesson->quizzes->every(function ($quiz) {
                    return $quiz->results()->where('user_id', auth()->id())->exists();
                });
            });
            $category->progressPercent = $category->lessons->count()
                ? ($completedLessons->count() / $category->lessons->count()) * 100
                : 0;
        });

        return view('user.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $category->load('lessons.quizzes');

        // Calculate progress for each lesson
        $category->lessons->each(function ($lesson) {
            $completedQuizzes = $lesson->quizzes->filter(function ($quiz) {
                return $quiz->results()->where('user_id', auth()->id())->exists();
            });
            $lesson->progressPercent = $lesson->quizzes->count()
                ? ($completedQuizzes->count() / $lesson->quizzes->count()) * 100
                : 0;
        });

        return view('user.categories.show', compact('category'));
    }
}
