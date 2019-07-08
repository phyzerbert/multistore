<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Store;

use Auth;   

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        config(['site.page' => 'purchase_list']);
        $data = Purchase::orderBy('created_at', 'desc')->paginate(15);
        return view('purchase.index', compact('data'));
    }

    public function create(Request $request){
        config(['site.page' => 'purchase_create']);        
        $suppliers = Supplier::all();
        $products = Product::all();
        $stores = Store::all();
        return view('purchase.create', compact('suppliers', 'stores', 'products'));
    }

    public function save(Request $request){
        $request->validate([
            'date'=>'required|string',
            'reference_number'=>'required|string',
            'store'=>'required',
            'supplier'=>'required',
            'status'=>'required',
        ]);

        $data = $request->all();
        // dd($data);
        $item = new Purchase();
        $item->user_id = Auth::user()->id;  
        $item->timestamp = $data['date'].":00";
        $item->reference_no = $data['reference_number'];
        $item->store_id = $data['store'];
        $item->supplier_id = $data['supplier'];
        $item->status = $data['status'];

        if($request->has("attachment")){
            $picture = request()->file('attachment');
            $imageName = "purchase_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/purchase_images/'), $imageName);
            $item->attachment = 'images/uploaded/purchase_images/'.$imageName;
        }
        $item->save();

        for ($i=0; $i < count($data['product_id']); $i++) { 
            Order::create([
                'product_id' => $data['product_id'][$i],
                'quantity' => $data['quantity'][$i],
                'subtotal' => $data['subtotal'][$i],
                'orderable_id' => $item->id,
                'orderable_type' => Purchase::class,
            ]);
        }

        return back()->with('success', 'Created Successfully');
    }

    public function edit(Request $request, $id){    
        config(['site.page' => 'product']);    
        $product = Purchase::find($id);
        $categories = Category::all();
        $taxes = Tax::all();
        $barcode_symbologies = BarcodeSymbology::all();
        $suppliers = Supplier::all();

        return view('product.edit', compact('product', 'categories', 'taxes', 'barcode_symbologies', 'suppliers'));
    }

    public function detail(Request $request, $id){    
        config(['site.page' => 'purchase']);    
        $purchase = Purchase::find($id);

        return view('purchase.detail', compact('purchase'));
    }

    public function update(Request $request){
        $request->validate([
            'date'=>'required|string',
            'reference_number'=>'required|string',
            'store'=>'required',
            'supplier'=>'required',
            'status'=>'required',
        ]);
        $data = $request->all();
        $item = Purchase::find($request->get("id"));

        $item->user_id = Auth::user()->id;  
        $item->timestamp = $data['date'].":00";
        $item->reference_no = $data['reference_number'];
        $item->store_id = $data['store'];
        $item->customer_id = $data['customer'];
        $item->status = $data['status'];

        if($request->has("attachment")){
            $picture = request()->file('attachment');
            $imageName = "purchase_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/purchase_images/'), $imageName);
            $item->attachment = 'images/uploaded/purchase_images/'.$imageName;
        }
        $item->save;
        return back()->with('success', 'Updated Successfully');
    }

    public function delete($id){
        $item = Purchase::find($id);
        $item->orders->delete();
        $item->delete();
        return back()->with("success", __('page.deleted_successfully'));
    }
}
