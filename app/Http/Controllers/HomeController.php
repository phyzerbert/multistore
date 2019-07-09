<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Order;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        config(['site.page' => 'home']);
        $total_purchases = Order::where('orderable_type', Purchase::class)->sum('subtotal');
        $total_sales = Order::where('orderable_type', Sale::class)->sum('subtotal');

        $period = '';
        if($request->has('period') && $request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
            // $mod = $mod->whereBetween('timestamp', [$from, $to]);
        }

        if(isset($from) && isset($to)){
            $chart_start = Carbon::createFromFormat('Y-m-d', $from);
            $chart_end = Carbon::createFromFormat('Y-m-d', $to);
        }else{
            $chart_start = Carbon::now()->startOfMonth();
            $chart_end = Carbon::now()->endOfMonth();
        }
        
        $key_array = $purchases = $sales = $purchase_array = $sale_array = array();

        for ($dt=$chart_start; $dt < $chart_end; $dt->addDay()) {
            $key = $dt->format('Y-m-d');
            $key1 = $dt->format('M/d');
            array_push($key_array, $key1);
            $purchases = Purchase::whereDate('timestamp', $key)->pluck('id')->toArray();
            $sales = Sale::whereDate('timestamp', $key)->pluck('id')->toArray();
            $daily_purchase = Order::whereIn('orderable_id', $purchases)->sum('subtotal');
            $daily_sale = Order::whereIn('orderable_id', $sales)->sum('subtotal');
            array_push($purchase_array, $daily_purchase);
            array_push($sale_array, $daily_sale);
        }

        return view('home', compact('total_purchases', 'total_sales', 'key_array', 'purchase_array', 'sale_array', 'period'));
    }

}
