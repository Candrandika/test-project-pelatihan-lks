<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [];

    public function respondens()
    {
        return $this->hasMany(Response::class, 'form_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'form_id', 'id');
    }

    public function domain()
    {
        return $this->hasMany(FormDomain::class, 'form_id', 'id');
    }
}
