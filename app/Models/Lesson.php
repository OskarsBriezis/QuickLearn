<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['category_id', 'title', 'content', 'media_url', 'published', 'user_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Change from hasOne to hasMany
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function completedByUsers()
{
    return $this->belongsToMany(User::class)->withTimestamps();
}

public function isCompletedByUser($userId)
{
    // Check if lesson is marked completed in pivot table
    return $this->completedByUsers()->where('user_id', $userId)->exists();
}

}
