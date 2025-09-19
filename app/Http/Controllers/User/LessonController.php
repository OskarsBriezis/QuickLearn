<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index() {
    $lessons = Lesson::with('category')->where('published', true)->get();
    return view('user.lessons.index', compact('lessons'));
}

public function show(Lesson $lesson) {
    return view('user.lessons.show', compact('lesson'));
}

public function complete(Lesson $lesson)
{
    $user = auth()->user();

    // Attach lesson to completed list (many-to-many pivot)
    $user->completedLessons()->syncWithoutDetaching([$lesson->id]);

    return redirect()->route('user.lessons.show', $lesson->id)
                     ->with('success', 'Lesson marked as completed!');
}


}
