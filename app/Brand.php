<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable =[

        "title", "image"
    ];

    public function product()
    {
    	return $this->hasMany('App/Product');
    	
    }
}
