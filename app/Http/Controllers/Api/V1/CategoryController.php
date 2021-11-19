<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAllCategories(Request $request){
        $categories = Category::with('descendants')->get()->toTree();
        return CategoryResource::collection($categories);
    }
}
