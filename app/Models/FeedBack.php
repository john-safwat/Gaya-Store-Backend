<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $fillable = ['product','user','rate','comment'];

    use HasFactory;
}
