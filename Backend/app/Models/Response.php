<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [];

    public function answer()
    {
        return $this->hasMany(Answer::class, 'response_id', 'id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
