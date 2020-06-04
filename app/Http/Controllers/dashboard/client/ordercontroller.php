<?php

namespace App\Http\Controllers\dashboard\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\client;
use App\category;
use App\order;
use App\product;
class ordercontroller extends Controller
{
       


   public function create(client $client){
        $categories=category::all();
        $orders=$client->orders()->paginate(5);
        return view('dashboard.clients.orders.create',compact('client','categories','orders'));
   }

   public function store(client $client,request $request ){

                $request->validate([
                    'products' => 'required|array',
            ]);

            $this->attach_order($request, $client);

            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('dashboard.clients.index');
        
         

          }

  private function attach_order($request, $client)
          {
              $order = $client->orders()->create([]);
      
              $order->products()->attach($request->products);
      
              $total_price = 0;
      
              foreach ($request->products as $id => $quantity) {
      
                  $product = Product::FindOrFail($id);
                  $total_price += $product->sale_price * $quantity['quantity'];
      
                  $product->update([
                      'stock' => $product->stock - $quantity['quantity']
                  ]);
      
              }//end of foreach
      
              $order->update([
                  'total_price' => $total_price
              ]);
      
          }//end of attach order

  public function update(request $request ,  client $client,order $order){
            
            $request->validate([
                'products' => 'required|array',

            ]);



            $this->detach_order($order);
            $this->attach_order($request, $client);

            session()->flash('success', __('site.updated_succssfully'));
            return redirect()->route('dashboard.orders.index');


          }   
          
          

  private function detach_order($order){


              foreach($order->products as $product){

                $product->update([

                    'stock'=>$product->stock + $product->pivot->quantity
                ]);

                
              }

              $order->delete();

          } 
         

}
