<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [ 'userId', 'name', 'phoneNumber' , 'address' , 'cardNumber' , 'shippingState' , 'shippingPrice' , 'postalCode' , 'total' ];

    use HasFactory;
}
