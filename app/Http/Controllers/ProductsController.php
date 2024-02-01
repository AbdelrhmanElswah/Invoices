<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Products::all();
        $sections=Sections::all();
        return view('products.products',compact('products','sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Products::create([
            'product_name' => $request->Product_name,
            'section_id' => $request->section_id,
            'notes' => $request->description
        ]);
        session()->flash('Add', 'Done ');
        return redirect('/products');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        $id=Sections::where('section_name',$request->section_name)->first()->id;
        $products=Products::findOrFail($request->pro_id);
        $products->update([
            'product_name'=>$request->Product_name,
            'notes'=>$request->description,
            'section_id'=>$id,
        ]);
        session()->flash('edit', 'Updated ');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->pro_id;
        Products::find($id)->delete();
        session()->flash('delete','Deleted');
        return redirect('/products'); 
    }
}