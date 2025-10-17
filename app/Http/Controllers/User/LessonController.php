<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index() {
        $userId = auth()->id();

        $lessons = Lesson::with('category')
            ->where('user_id', $userId)
            ->where('published', true)
            ->get();

        return view('user.lessons.index', compact('lessons'));
    }

    public function show(Lesson $lesson) {
        $this->authorizeLessonAccess($lesson);

        return view('user.lessons.show', compact('lesson'));
    }

    public function complete(Lesson $lesson)
    {
        $this->authorizeLessonAccess($lesson);

        $user = auth()->user();
        $user->completedLessons()->syncWithoutDetaching([$lesson->id]);

        return redirect()
            ->route('user.lessons.show', $lesson->id)
            ->with('success', 'Lesson marked as completed!');
    }

    private function authorizeLessonAccess(Lesson $lesson)
    {
        if ($lesson->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this lesson.');
        }
    }
}
