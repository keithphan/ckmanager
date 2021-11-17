<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('user_id', Auth::user()->id)->get();
        return view('pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->category){
            $category = Category::where('slug', $request->category)->first();
            
            if(!$category){
                abort(404);
            }

            $companies = Company::where('user_id', Auth::user()->id)->get();

            if(!$companies->first()){
                Session::flash('message', "You do not have any companies! <a href='" . route('companies.create') . "'>Create one</a>");
                Session::flash('class', 'bg-warning');
                return redirect()->back();
            }

            return view('pages.products.create', compact('category', 'companies'));
        }

        // Return to page that user can choose a category for creating product.
        $categories = Category::whereIsLeaf()->with(['ancestors'])->get();

        if(!$categories->first()){
            Session::flash('message', 'Please create at least one category!');
            Session::flash('class', 'bg-warning');
            return redirect()->back();
        }

        return view('pages.products.categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(count($request->variant_name));
        $request->validate(
            [
                'name' => 'required',
                'company_id' => 'required',
            ]
        );

        $details = $this->getDetailFieldsByCategory($request);

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'thumbnail' => $request->thumbnail,
            'gallery' => implode(' | ', $request->gallery),
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'price' => ($request->price * 100),
            'original_price' => ($request->original_price * 100),
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'details' => json_encode($details),
            'user_id' => Auth::user()->id,
            'company_id' => $request->company_id,
        ]);

        // if(count($request->variant_name) > 5){
        //     Session::flash('message', 'Only 5 variants allowed');
        //     Session::flash('class', 'bg-warning');

        //     return redirect()->back();
        // }

        // for($i = 0; $i < count($request->variant_name); $i++){
        //     if($request->variant_name[$i] != ''){
        //         $variant = Variant::create([
        //             'name' => $request->variant_name[$i],
        //             'price' => ($request->variant_price[$i]  * 100),
        //             'quantity' => $request->variant_quantity[$i],
        //             'gallery' => $request->variant_gallery[$i],
        //             'product_id' => $product->id,
        //         ]);
        //     }
        // }

        Session::flash('message', 'Create product successfully.');
        Session::flash('class', 'bg-success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where([['id', $id], ['user_id', Auth::user()->id]])->first();

        if(!$product){
            $this->isNotExisted();
            return redirect()->back();
        }

        $category = $product->category;
        $companies = Company::where('user_id', Auth::user()->id)->get();

        return view('pages.products.edit', compact('product', 'companies', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'company_id' => 'required',
            ]
        );

        $product = Product::where([['id', $id], ['user_id', Auth::user()->id]])->first();

        if(!$product){
            $this->isNotExisted();
            return redirect()->back();
        }

        $details = $this->getDetailFieldsByCategory($request);

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'thumbnail' => $request->thumbnail,
            'gallery' => implode(' | ', $request->gallery),
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'price' =>  ($request->price * 100),
            'original_price' => ($request->original_price * 100),
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'details' => json_encode($details),
            'user_id' => Auth::user()->id,
            'company_id' => $request->company_id,
        ]);

        // Update and add
        // for($i = 0; $i < count($request->variant_name); $i++){
        //     if($request->variant_name[$i] != ''){
        //         if(!empty($product->variants[$i])){
        //             $product->variants[$i]->update([
        //                 'name' => $request->variant_name[$i],
        //                 'price' => ($request->variant_price[$i]  * 100),
        //                 'quantity' => $request->variant_quantity[$i],
        //                 'gallery' => $request->variant_gallery[$i],
        //             ]);
        //         }else{
        //             Variant::create([
        //                 'name' => $request->variant_name[$i],
        //                 'price' => ($request->variant_price[$i]  * 100),
        //                 'quantity' => $request->variant_quantity[$i],
        //                 'gallery' => $request->variant_gallery[$i],
        //                 'product_id' => $product->id,
        //             ]);
        //         }
        //     }else{
        //         // if(!empty($product->variants->first())){
        //             $product->variants[$i]->delete();
        //         // }
        //     }
        // }

        Session::flash('message', 'Update product successfully.');
        Session::flash('class', 'bg-success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::find($request->id);

        if(!$product){
            $this->isNotExisted();
            return redirect()->back();
        }
        $product->delete();

        Session::flash('message', 'Deleted product successfully.');
        Session::flash('class', 'bg-success');
        return redirect()->back();
    }

    public function destroySelected(Request $request){

        if(!isset($request->itemIds)){
            Session::flash('message', 'No products selected. Please select!');
            Session::flash('class', 'bg-warning');
            return redirect()->back();
        }

        $productIds = explode(',', $request->itemIds);

        foreach($productIds as $id){
            Product::find($id)->delete();
        }

        Session::flash('message', 'Deleted products successfully.');
        Session::flash('class', 'bg-success');
        return redirect()->back();
    }

    public function isNotExisted(){
        Session::flash('message', 'Product does not exist!');
        Session::flash('class', 'bg-warning');
    }

    public function getDetailFieldsByCategory($request){
        $slug = Category::find($request->category_id)->slug;

        if(!$slug){
            abort(404);
        }

        if($slug == 'fruit' || $slug == 'vegetables'){
            return [
                'energy' => implode(' | ', $request->energy),
                'protein' => implode(' | ', $request->protein),
                'fat' => implode(' | ', $request->fat),
                'saturated' => implode(' | ', $request->saturated),
                'carbohydrate' => implode(' | ', $request->carbohydrate),
                'sugars' => implode(' | ', $request->sugars),
                'dietary_fibre' => implode(' | ', $request->dietary_fibre),
                'sodium' => implode(' | ', $request->sodium),
            ];
        }
    }
}
