<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Order;

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
    public function index()
    {
        config(['site.page' => 'home']);
        $total_purchases = Order::where('orderable_type', Purchase::class)->sum('subtotal');
        $total_sales = Order::where('orderable_type', Sale::class)->sum('subtotal');

        return view('home', compact('total_purchases', 'total_sales'));
    }
}
