<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\category;
use App\product;
use App\client;
use App\user;
use App\order;
use Illuminate\Support\Facades\DB;


class dashboardcontroller extends Controller
{
    public function index(){

       $categories_count=category::count();
       $products_count=product::count();
       $clients_count=client::count();
       $users_count=user::whereroleis('admin')->count();
       


       $sales_data = Order::select(
        DB::raw('YEAR(created_at) as year'),
        DB::raw('MONTH(created_at) as month'),
        DB::raw('SUM(total_price) as sum')
       
    )->groupBy('month')->groupBy('year')->get();
 
       

        return view('dashboard.index',compact('categories_count','products_count','clients_count','users_count','sales_data'));
    }
}
