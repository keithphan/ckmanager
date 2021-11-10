<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'phone_number', 'addresses', 'company_id', 'user_id'];
    
    public function company(){
        return $this->belongsTo(Company::class);
    }
}
