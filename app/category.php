<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $fillable=[
        'name_ar','name_en','desc_ar','desc_en',
    ];
    public function products(){
        return $this->hasmany(product::class);
    }
}
