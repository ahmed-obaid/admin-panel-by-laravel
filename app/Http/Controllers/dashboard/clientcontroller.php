<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\rule;
use App\client ;
class clientcontroller extends Controller
{
    public function index(request $request){
       
        $clients= client::when($request->search,function($q)use($request){

                  return $q->where('name','like','%'.$request->search .'%' )
                     ->orwhere('phone','like','%'.$request->search .'%')
                     ->orwhere('address','like','%'.$request->search .'%');

        })->latest()->paginate(5);
         
             return view('dashboard.clients.index',compact('clients'));
    }

    public function create(){

       
        return view('dashboard.clients.create');
    }

    public function store(request $request){
       // dd($request->all());
        $request->validate([
               'name'=>'required|unique:clients',
              
              // 'phone'=>'required|array|min:1',
               'phone.0'=>'required',
               'address'=>'required',
        ]);        
 
       $client=client::create($request->all());      
       session()->flash('success',__('site.added_successfully'));
         return redirect()->route('dashboard.clients.index');
        
     }

     public function edit(client $client){
        
       
        return view('dashboard.clients.edit',compact('client'));
    }

    
    public function update(request $request,client $client){
        
        $request->validate([
            'name'=>['required', Rule::unique('clients')->ignore($client->id)],
            'phone.0'=>'required',  
            'address'=>'required',
                          
        ]);   
        
       $client->update($request->all());      
       
       session()->flash('success',__('site.updated_successfully'));
         return redirect()->route('dashboard.clients.index');
        
     }


     public function destroy(client $client){

          
        $client->delete();
        
       
       
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.clients.index');
     }
}
