<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\order;
use App\client;
use App\category;
class ordercontroller extends Controller
{
     public function index(request $request){

       
       $orders=order::wherehas('client',function($q) use($request){


           return  $q->where('name','like','%'.$request->search.'%');
        })->paginate(3);




       // $categories=category::all();        
        //dd( $orders-> merge($categories));
                 
        return view ('dashboard.orders.index',compact('orders'));
     }

     public function products(order $order){

      
      $products = $order->products;
      return view('dashboard.orders._products', compact('order', 'products'));

       

    }



    public function edit(order $order,client $client){
     // dd($order->id);
      //dd($client->id);
          
        $orders=$order->client->orders()->paginate(2); 
       
      $categories=category::all();
      return view('dashboard.clients.orders.edit',compact('client','categories','order','orders'));

    }

    public function destroy(order $order){

      foreach($order->products as $product)
      {

        $product->update([
            'stock'=> $product->stock + $product->pivot->quantity
         ]);


      }

      $order->delete();
      return redirect()->route('dashboard.orders.index');

       

    }



}
