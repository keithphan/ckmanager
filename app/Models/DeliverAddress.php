<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverAddress extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'address', 'is_default'];
}
