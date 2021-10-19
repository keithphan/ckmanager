<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('ancestors')->defaultOrder()->get();

        return view('pages.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
            ],
        );
        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if($request->parent_id && $request->parent_id != 'None' && $request->parent_id != 'none'){
            $parent = Category::where('id', $request->parent_id)->first();
            $parent->appendNode($category);
        }

        Session::flash('message', 'Create category successfully.');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::get(['id', 'name']);

        $category = Category::find($id);

        if(!$category){
            $this->isNotExisted();
            return redirect()->back();
        }

        return view('pages.categories.edit', compact('category', 'categories'));
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
            ],
        );

        $category = Category::find($id);

        if($category){
            $category->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            if($request->parent_id && $request->parent_id != 'None' && $request->parent_id != 'none'){
                $parent = Category::where('id', $request->parent_id)->first();
                $parent->appendNode($category);
            }else{
                $category->makeRoot()->save();;
            }
            Session::flash('message', 'Update brand successfully.');
            Session::flash('class', 'bg-success');
        }else{
            $this->isNotExisted();
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category = Category::find($request->id);

        if($category){
            $category->delete();
            Session::flash('message', 'Deleted category.');
            Session::flash('class', 'bg-danger');
        }else{
            $this->isNotExisted();
        }

        return redirect()->back();
    }

    public function destroySelected(Request $request){

        if(!isset($request->itemIds)){
            Session::flash('message', 'No categories selected. Please select!');
            Session::flash('class', 'bg-warning');
            return redirect()->back();
        }
        $categoryIds = explode(',', $request->itemIds);


        foreach($categoryIds as $id){
            $category = Category::find($id);
            if($category){
                $category->delete();
            }
        }

        Session::flash('message', 'Deleted categories.');
        Session::flash('class', 'bg-danger');
        return redirect()->back();
    }

    public function isNotExisted(){
        Session::flash('message', 'Category does not exist!');
        Session::flash('class', 'bg-warning');
    }
}
