<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'unit', 'thumbnail', 'gallery', 'quantity', 'price', 'original_price', 'short_description', 'long_description', 'details', 'user_id', 'company_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
