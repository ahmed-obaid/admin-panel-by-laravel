<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\rule;
use Intervention\Image\Facades\Image;  
use App\product;
use App\category;

class productcontroller extends Controller
{


    public function index(request $request){
        $categories=category::all();
        $products= product::when($request->search,function($q) use($request){     
     
                 return $q->where('name_ar','like','%'.$request->search .'%');
                            
                }) ->when($request->category_id,function($query)use($request){

                    return $query->where('category_id', $request->category_id);
                })->latest()->paginate(5);                                   
          
             return view('dashboard.products.index',compact('products','categories'));
    }


    public function create(){

       $categories=category::all();
        return view('dashboard.products.create',compact('categories'));
    }

    public function store(request $request){
        
        $request->validate([
               'name_ar'=>'required',
               'name_en'=>'required',
               'desc_ar'=>'required',
               'desc_en'=>'required',
               'category_id'=>'required',
               'purchase_price'=>'required|numeric',
               'sale_price'=>'required|numeric',
                
               'stock'=>'required|numeric',
        ]); 

        $request_data=$request->except('image') ;
        if($request->image)
       {
           $imagename=$request->image->hashname() ;

              Image::make($request->image)->resize(300, null, function ($constraint)
            {               
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_images/'.$imagename));
            $request_data['image']=$imagename;
       }
 
       $product=product::create($request_data);      
       session()->flash('success',__('site.added_successfully'));
         return redirect()->route('dashboard.products.index');
        
     }

     public function edit(product $product){
        
        $categories=category::all();
        return view('dashboard.products.edit',compact('product','categories'));
    }

    
    public function update(request $request,product $product){
        
        $request->validate([
            'name_ar'=>'required' ,
            'name_en'=>'required',
            'desc_ar'=>'required',
            'desc_en'=>'required', 
            'category_id'=>'required',
            'purchase_price'=>'required|numeric',
            'sale_price'=>'required|numeric',
           
            'stock'=>'required|numeric',          
        ]); 
        $request_data=$request->except('image');
       
        if($request->image)
       {
           $imagename=$request->image->hashname();
           if($product->image !='default.jpg'){

            $image=public_path('uploads/products_images').'/'.$product->image;
             unlink($image);

           }

              Image::make($request->image)->resize(300, null, function ($constraint)
            {               
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_images/'.$imagename));
            $request_data['image']=$imagename;
       }
        
       $product ->update($request_data); 
           
       
       session()->flash('success',__('site.updated_successfully'));
         return redirect()->route('dashboard.products.index');
        
     }


     public function destroy(product $product){

          
        $product->delete();
        if($product->image !='default.jpg')
        {
          $image=public_path('uploads/products_images').'/'.$product->image;
           unlink($image);

        }
       
       
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
     }

}
