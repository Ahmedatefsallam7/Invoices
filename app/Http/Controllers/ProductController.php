<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function index()
    {
        $sections=Section::get();
        $products=Product::get();
        return view('products.products',compact(['sections','products']));
    }

   
    public function create()
    {
        
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'product_name'  => 'required',
            // 'description'   => 'required',
            'section_id'    => 'required',
        ],[
            'product_name.required' =>'يرجي ادخال اسم المنتج', 
            // 'description.required'  =>'يرجي ادخال الوصف', 
            'section_id.required'   =>'يرجي ادخال اسم القسم',            
        ]);
        
        Product::create([
            'product_name'  =>$request->product_name,
            'description'   =>$request->description,
            'section_id'    =>$request->section_id,
        ]);
        
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/products');
    }

    
    public function show(Product $product)
    {
        
    }

   
    public function edit(Product $product)
    {
        
    }

   
    public function update(Request $request)
    {
        $id = Section::where('section_name',$request->section_name)->first()->id;
        $this->validate($request, [
            'product_name' => 'required',
            // 'description' => 'required',
        ],[
            'product_name.required' =>'يرجي ادخال اسم المنتج',
            // 'description.required' =>'يرجي ادخال البيان',
        ]);

        $products = Product::find($request->id);
        $products->update([
            'product_name' => $request->product_name,           
            'description' => $request->description,
            'section_id' => $id,
        ]);
        
        session()->flash('edit','تم تعديل المنتج بنجاج');
        return redirect()->back();
    }

   
    public function destroy(Request $request)
    {
        $id=$request->id;
        Product::destroy($id);        
        session()->flash('delete','تم حذف القسم بنجاج');
        return redirect()->back();
    }
}