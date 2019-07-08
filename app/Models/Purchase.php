<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
 
    protected $fillable = [
        'timestamp', 'reference_no', 'store_id', 'supplier_id', 'attachment', 'note', 'status',
    ];

    public function orders()
    {
        return $this->morphMany('App\Models\Order', 'orderable');
    }

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }

    public function supplier(){
        return $this->belongsTo('App\Models\Supplier');
    }
}
