<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['productId' , "userId"];
    protected $hidden = ['created_at' , 'updated_at'];
    use HasFactory;
}
