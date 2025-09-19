<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $fillable = ['quiz_id', 'user_id', 'score', 'total'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Link selected answers via pivot
    public function answers()
    {
        return $this->belongsToMany(Answer::class, 'quiz_result_answers')
                    ->withTimestamps();
    }
}
