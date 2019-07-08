<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Store;
use App\User;

use Auth;   

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        config(['site.page' => 'sale_list']);
        $data = Sale::orderBy('created_at', 'desc')->paginate(15);
        return view('sale.index', compact('data'));
    }

    public function create(Request $request){
        config(['site.page' => 'sale_create']);        
        $customers = Customer::all();
        $products = Product::all();
        $stores = Store::all();
        $users = User::where('role_id', 2)->get();
        return view('sale.create', compact('customers', 'stores', 'products', 'users'));
    }

    public function save(Request $request){
        $request->validate([
            'date'=>'required|string',
            'reference_number'=>'required|string',
            'store'=>'required',
            'customer'=>'required',
            'user'=>'required',
            'status'=>'required',
        ]);

        $data = $request->all();
        // dd($data);
        $item = new Sale();
        $item->user_id = Auth::user()->id;
        $item->biller_id = $data['user'];
        $item->timestamp = $data['date'].":00";
        $item->reference_no = $data['reference_number'];
        $item->store_id = $data['store'];
        $item->customer_id = $data['customer'];
        $item->status = $data['status'];

        if($request->has("attachment")){
            $picture = request()->file('attachment');
            $imageName = "sale_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/sale_images/'), $imageName);
            $item->attachment = 'images/uploaded/sale_images/'.$imageName;
        }
        $item->save();

        for ($i=0; $i < count($data['product_id']); $i++) { 
            Order::create([
                'product_id' => $data['product_id'][$i],
                'quantity' => $data['quantity'][$i],
                'subtotal' => $data['subtotal'][$i],
                'orderable_id' => $item->id,
                'orderable_type' => Sale::class,
            ]);
        }

        return back()->with('success', 'Created Successfully');
    }

    public function edit(Request $request, $id){    
        config(['site.page' => 'product']);    
        $product = Sale::find($id);
        $categories = Category::all();
        $taxes = Tax::all();
        $barcode_symbologies = BarcodeSymbology::all();
        $customers = Customer::all();

        return view('product.edit', compact('product', 'categories', 'taxes', 'barcode_symbologies', 'customers'));
    }

    public function detail(Request $request, $id){    
        config(['site.page' => 'sale']);    
        $sale = Sale::find($id);

        return view('sale.detail', compact('sale'));
    }

    public function update(Request $request){
        $request->validate([
            'name'=>'required|string',
            'code'=>'required|string',
            'barcode_symbology_id'=>'required',
            'category_id'=>'required',
            'unit'=>'required|string',
            'cost'=>'required|numeric',
            'price'=>'required|numeric',
        ]);
        $data = $request->all();
        $item = Sale::find($request->get("id"));
        $data['attachment'] = $item->image;

        if($request->has("image")){
            $picture = request()->file('image');
            $imageName = "sale_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/sale_images/'), $imageName);
            $data['attachment'] = 'images/uploaded/sale_images/'.$imageName;
        }
        $item->update($data);
        return back()->with('success', 'Updated Successfully');
    }

    public function delete($id){
        $item = Sale::find($id);
        $item->orders->delete();
        $item->delete();
        return back()->with("success", __('page.deleted_successfully'));
    }
}
