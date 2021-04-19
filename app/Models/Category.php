<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Category extends Model
{
    use HasFactory;


    public function getQuestionsCountAttribute($value)
    {
        return Question::where(['category_id'=>$this->id])->count();
    }
}
