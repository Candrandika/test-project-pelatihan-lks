<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [];

    public function options()
    {
        return $this->hasMany(Option::class, 'question_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }
}
