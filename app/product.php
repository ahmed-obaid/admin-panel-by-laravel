<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use LaravelLocalization;
use App;
class product extends Model
{
    protected $fillable=[
        'name_ar','name_en','desc_ar','desc_en','category_id','purchase_price',
        'sale_price','stock','image'
    ];

    protected $appends=['profit','name'];

    public function category(){
        
        return $this->belongsTo(category::class);
     
    }
      
    public function getProfitAttribute(){

        $profit=$this->sale_price - $this->purchase_price;
        $profit_percent=$profit * 100/$this->purchase_price;
        return $profit_percent;
    }

    public function orders()
    {
        return $this->belongsToMany(order::class, 'product_order')->withPivot('quantity');

    }//end of products

    public function getnameattribute(){
      
        if(LaravelLocalization::getCurrentLocale()=='ar'){
            return $this->name_ar;
        }elseif(LaravelLocalization::getCurrentLocale()=='en'){
           return $this->name_en; 
        }

        
       /* if(App::getLocale()=='ar'){
            return $this->name_ar;
        }elseif(App::getLocale()=='en'){
            return $this->name_en; 
        }
        */

    } 

}
