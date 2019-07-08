<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name', 'company_id',
    ];

    public function company(){
        return $this->belongsTo('App\Models\Company');
    }

    public function products(){
        return $this->belongsToMany('App\Models\Product');
    }
}
