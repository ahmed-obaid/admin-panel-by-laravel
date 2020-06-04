<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\rule;
use App\category;

class categorycontroller extends Controller
{
    public function index(request $request){

        $categories= category::when($request->search,function($q) use($request){

            return $q->where(function($query)use($request){
     
                 return $query->where('name_ar','like','%'.$request->search .'%')
                            ->orwhere('name_en','like','%'.$request->search .'%');
                           
     
                });
            })->latest()->paginate(5);
            
            
          
             return view('dashboard.categories.index',compact('categories'));
    }

    public function create(){

       
        return view('dashboard.categories.create');
    }

    public function store(request $request){
        
        $request->validate([
               'name_ar'=>'required|unique:categories',
               'name_en'=>'required|unique:categories',
               'desc_ar'=>'required',
               'desc_en'=>'required',
        ]);        
 
       $user=category::create($request->all());      
       session()->flash('success',__('site.added_successfully'));
         return redirect()->route('dashboard.categories.index');
        
     }

     public function edit(category $category){
        
       
        return view('dashboard.categories.edit',compact('category'));
    }

    
    public function update(request $request,category $category){
        
        $request->validate([
            'name_ar'=>['required', Rule::unique('categories')->ignore($category->id)],
            'name_en'=>['required', Rule::unique('categories')->ignore($category->id)],
            'desc_ar'=>'required',
            'desc_en'=>'required',              
        ]);   
        
       $category ->update($request->all());      
       
       session()->flash('success',__('site.updated_successfully'));
         return redirect()->route('dashboard.categories.index');
        
     }


     public function destroy(category $category){

          
        $category->delete();
        
       
       
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
     }

}
