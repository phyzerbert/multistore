<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Order;

use App;

class VueController extends Controller
{
    
    public function get_products() {
        $products = Product::all();

        return response()->json($products);
    }

    public function get_product(Request $request) {
        $id = $request->get('id');

        $product = Product::find($id)->load('tax');

        return response()->json($product);
    }

    public function get_orders(Request $request) {
        $id = $request->get('id');
        $type = $request->get('type');
        // dd($request->all());
        if($type == 'purchase'){
            $item = Purchase::find($id);
        }elseif($type == 'sale'){
            $item = Sale::find($id);
        }        
        $orders = $item->orders;
        return response()->json($orders);
    }
    
}
