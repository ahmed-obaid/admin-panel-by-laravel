<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
   protected $fillable=[
       'name','phone','address'
   ];

   protected $casts=[
       'phone'=>'array'
   ];

   public function orders()
   {
       return $this->hasmany(order::class);

   }

}
