<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductsByCompanyAndCategory($companyId, $category){
        $com = Company::find($companyId);
        $cate = Category::where('slug', $category)->first();

        $descendants  = Category::descendantsOf($cate->id);

        $products = "";

        if($descendants->first()){
            foreach($descendants as $descendant){
                $products = Product::where([['company_id', $com->id], ['category_id', $descendant->id]])->get();
            }
        }else{
            $products = Product::where([['company_id', $com->id], ['category_id', $cate->id]])->get();
        }
        // $products = Product::where([['company_id', $com->id], ['category_id', $cate->id]])->get();

        return ProductResource::collection($products);
    }

    public function getOnSaleProducts($companyId){
        $com = Company::find($companyId);
        $products = Product::where([['company_id', $com->id], ['original_price', '>', 0]])->get();

        return ProductResource::collection($products);
    }

    public function getProductByCompanyAndCategory($companyId, $productId){
        $com = Company::find($companyId);
        $product = Product::where([['company_id', $com->id]])->find($productId);

        return new ProductResource($product);
    }
}
