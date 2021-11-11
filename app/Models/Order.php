<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_id', 'customer_name', 'customer_phoneNumber', 'customer_email', 'customer_address', 'shipping_fee', 'payment_method', 'total', 'status', 'description', 'company_id','user_id'];

    function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    function customer(){
        return $this->belongsTo(Customer::class);
    }
}
