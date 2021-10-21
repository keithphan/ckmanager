<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'phone_number', 'company_id', 'user_id'];

    public function deliverAddresses(){
        return $this->hasMany(DeliverAddress::class);
    }
}
