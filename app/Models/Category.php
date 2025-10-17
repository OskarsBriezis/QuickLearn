<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'user_id'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

}

