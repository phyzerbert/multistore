<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    


    public function orders()
    {
        return $this->morphMany('App\Models\Order', 'orderable');
    }
}
