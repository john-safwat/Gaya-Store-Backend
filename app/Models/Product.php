<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','category','price','mainImage','description','descriptionImage','brand','quantity'];
    protected $hidden = ['created_at' , 'updated_at'];
    use HasFactory;
}
