<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Company;
use App\Models\Store;

use Auth;   

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        config(['site.page' => 'purchase_list']);
        $user = Auth::user();
        $stores = Store::all();
        $suppliers = Supplier::all();
        $companies = Company::all();

        $mod = new Purchase();
        if($user->role->slug == 'user'){
            $mod = $user->company->purchases();
            $stores = $user->company->stores;
        }
        $company_id = $reference_no = $supplier_id = $store_id = $period = '';
        if ($request->get('company_id') != ""){
            $company_id = $request->get('company_id');
            $mod = $mod->where('company_id', $company_id);
        }
        if ($request->get('reference_no') != ""){
            $reference_no = $request->get('reference_no');
            $mod = $mod->where('reference_no', 'LIKE', "%$reference_no%");
        }
        if ($request->get('supplier_id') != ""){
            $supplier_id = $request->get('supplier_id');
            $mod = $mod->where('supplier_id', $supplier_id);
        }
        if ($request->get('store_id') != ""){
            $store_id = $request->get('store_id');
            $mod = $mod->where('store_id', $store_id);
        }
        if ($request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
            $mod = $mod->whereBetween('timestamp', [$from, $to]);
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(15);
        return view('purchase.index', compact('data', 'companies', 'stores', 'suppliers', 'company_id', 'store_id', 'supplier_id', 'reference_no', 'period'));
    }

    public function create(Request $request){
        config(['site.page' => 'purchase_create']);   
        $user = Auth::user();  
        $suppliers = Supplier::all();
        $products = Product::all();
        $stores = Store::all();
        if($user->role->slug == 'user'){
            $stores = $user->company->stores;
        }
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
        $store = Store::find($data['store']);
        $item->company_id = $store->company_id;
        $item->supplier_id = $data['supplier'];
        $item->status = $data['status'];
        $item->note = $data['note'];

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
        $user = Auth::user();   
        $purchase = Purchase::find($id);        
        $suppliers = Supplier::all();
        $products = Product::all();
        $stores = Store::all();
        if($user->role->slug == 'user'){
            $stores = $user->company->stores;
        }

        return view('purchase.edit', compact('purchase', 'suppliers', 'stores', 'products'));
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
        // dd($data);
        $item = Purchase::find($request->get("id"));

        $item->user_id = Auth::user()->id;  
        $item->timestamp = $data['date'].":00";
        $item->reference_no = $data['reference_number'];
        $item->store_id = $data['store'];
        $store = Store::find($data['store']);
        $item->company_id = $store->company_id;
        $item->supplier_id = $data['supplier'];
        $item->status = $data['status'];
        $item->note = $data['note'];

        if($request->has("attachment")){
            $picture = request()->file('attachment');
            $imageName = "purchase_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/purchase_images/'), $imageName);
            $item->attachment = 'images/uploaded/purchase_images/'.$imageName;
        }
        $item->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function delete($id){
        $item = Purchase::find($id);
        $item->orders()->delete();
        $item->delete();
        return back()->with("success", __('page.deleted_successfully'));
    }
}
