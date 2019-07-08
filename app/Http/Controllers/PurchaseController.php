<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Store;

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
        config(['site.page' => 'purchase']);        
        $suppliers = Supplier::all();
        $products = Product::all();
        $stores = Store::all();
        return view('purchase.create', compact('suppliers', 'stores', 'products'));
    }

    public function save(Request $request){
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
        $item = new Purchase();
        $item->name = $data['name'];
        $item->code = $data['code'];
        $item->barcode_symbology_id = $data['barcode_symbology_id'];
        $item->category_id = $data['category_id'];
        $item->unit = $data['unit'];
        $item->cost = $data['cost'];
        $item->price = $data['price'];
        $item->tax_id = $data['tax_id'];
        $item->tax_method = $data['tax_method'];
        $item->alert_quantity = $data['alert_quantity'];
        $item->supplier_id = $data['supplier_id'];
        $item->detail = $data['detail'];

        if($request->has("image")){
            $picture = request()->file('image');
            $imageName = "product_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/purchase_images/'), $imageName);
            $item->image = 'images/uploaded/purchase_images/'.$imageName;
        }
        $item->save();

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
        config(['site.page' => 'product']);    
        $product = Purchase::find($id);

        return view('product.detail', compact('product'));
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
        $item = Purchase::find($request->get("id"));
        $data['image'] = $item->image;

        if($request->has("image")){
            $picture = request()->file('image');
            $imageName = "product_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/product_images/'), $imageName);
            $data['image'] = 'images/uploaded/product_images/'.$imageName;
        }
        $item->update($data);
        return back()->with('success', 'Updated Successfully');
    }

    public function delete($id){
        $item = Purchase::find($id);
        $item->delete();
        return back()->with("success", __('page.deleted_successfully'));
    }
}
