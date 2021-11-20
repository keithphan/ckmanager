<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $guard = 'customer';

    protected $fillable = ['name', 'email', 'password', 'phone_number', 'addresses', 'company_id', 'user_id'];
    
    public function company(){
        return $this->belongsTo(Company::class);
    }

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'user_id',
    ];
}
