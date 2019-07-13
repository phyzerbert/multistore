<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Store;
use App\Models\StoreProduct;
use App\Models\Sale;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Category;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Supplier;
use App\User;

use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function overview_chart(Request $request){
        config(['site.page' => 'overview_chart']);

        $start_this_month = new Carbon('first day of this month');
        $end_this_month = new Carbon('last day of this month');
        
        $start_this_month = $start_this_month->format('Y-m-d');
        $end_this_month = $end_this_month->format('Y-m-d');
        
        $start_last_month = new Carbon('first day of last month');
        $end_last_month = new Carbon('last day of last month');
        
        $start_last_month = $start_last_month->format('Y-m-d');
        $end_last_month = $end_last_month->format('Y-m-d');
        
        $currentMonth = date('F');
        $return['this_month']['month_name'] = $currentMonth." ".date('Y');
        $return['last_month']['month_name'] = Date('F', strtotime($currentMonth . " last month"))." ".date('Y');

        $this_month_purchases = Purchase::whereBetween('timestamp', [$start_this_month, $end_this_month])->pluck('id')->toArray();
        $return['this_month']['purchase'] = Order::whereIn('orderable_id', $this_month_purchases)->where('orderable_type', Purchase::class)->sum('subtotal');
        $this_month_sales = Sale::whereBetween('timestamp', [$start_this_month, $end_this_month])->pluck('id')->toArray();
        $return['this_month']['sale'] = Order::whereIn('orderable_id', $this_month_sales)->where('orderable_type', Sale::class)->sum('subtotal');

        $last_month_purchases = Purchase::whereBetween('timestamp', [$start_last_month, $end_last_month])->pluck('id')->toArray();
        $return['last_month']['purchase'] = Order::whereIn('orderable_id', $last_month_purchases)->where('orderable_type', Purchase::class)->sum('subtotal');
        $last_month_sales = Sale::whereBetween('timestamp', [$start_last_month, $end_last_month])->pluck('id')->toArray();
        $return['last_month']['sale'] = Order::whereIn('orderable_id', $last_month_sales)->where('orderable_type', Sale::class)->sum('subtotal');
        
        return view('reports.overview_chart', compact('return'));
    }

    public function company_chart(Request $request){
        config(['site.page' => 'company_chart']);

        $companies = Company::all();
        $company_names = Company::pluck('name')->toArray();
        $company_purchases_array = $company_sales_array = array();
        $period = '';

        foreach ($companies as $company) {
            $mod1 = $company->purchases();
            $mod2 = $company->sales();            

            if($request->has('period') && $request->get('period') != ""){   
                $period = $request->get('period');
                $from = substr($period, 0, 10);
                $to = substr($period, 14, 10);
                $mod1 = $mod1->whereBetween('timestamp', [$from, $to]);
                $mod2 = $mod2->whereBetween('timestamp', [$from, $to]);
            }

            $company_purchases = $mod1->pluck('id');
            $company_sales = $mod2->pluck('id');

            $company_purchases_total = Order::whereIn('orderable_id', $company_purchases)->where('orderable_type', Purchase::class)->sum('subtotal');
            $company_sales_total = Order::whereIn('orderable_id', $company_sales)->where('orderable_type', Sale::class)->sum('subtotal');
            array_push($company_purchases_array, $company_purchases_total);
            array_push($company_sales_array, $company_sales_total);
        }

        return view('reports.company_chart', compact('return', 'company_names', 'company_purchases_array', 'company_sales_array', 'period'));
    }

    public function product_quantity_alert(Request $request){
        config(['site.page' => 'product_quantity_alert']);

        $data = Product::all();        

        return view('reports.product_quantity_alert', compact('data'));
    }

    public function products_report(Request $request){
        config(['site.page' => 'products_report']);

        $pagesize = session('pagesize');
        if(!$pagesize){$pagesize = 15;}
        $data = Product::paginate($pagesize);        

        return view('reports.products_report', compact('data'));
    }

    public function categories_report(Request $request){
        config(['site.page' => 'categories_report']);

        $data = Category::paginate(10);        

        return view('reports.categories_report', compact('data'));
    }

    public function sales_report(Request $request){
        config(['site.page' => 'sales_report']);

        $stores = Store::all();
        $customers = Customer::all();
        $companies = Company::all();

        $mod = new Sale();

        $company_id = $reference_no = $customer_id = $store_id = $period = '';
        if ($request->get('company_id') != ""){
            $company_id = $request->get('company_id');
            $mod = $mod->where('company_id', $company_id);
        }
        if ($request->get('reference_no') != ""){
            $reference_no = $request->get('reference_no');
            $mod = $mod->where('reference_no', 'LIKE', "%$reference_no%");
        }
        if ($request->get('customer_id') != ""){
            $customer_id = $request->get('customer_id');
            $mod = $mod->where('customer_id', $customer_id);
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
        $pagesize = session('pagesize');
        if(!$pagesize){$pagesize = 15;}
        $data = $mod->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('reports.sales_report', compact('data', 'companies', 'stores', 'customers', 'company_id', 'store_id', 'customer_id', 'reference_no', 'period'));
    }

    public function purchases_report(Request $request){
        config(['site.page' => 'purchases_report']);
        $stores = Store::all();
        $suppliers = Supplier::all();
        $companies = Company::all();

        $mod = new Purchase();
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
        $pagesize = session('pagesize');
        if(!$pagesize){$pagesize = 15;}
        $data = $mod->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('reports.purchases_report', compact('data', 'companies', 'stores', 'suppliers', 'company_id', 'store_id', 'supplier_id', 'reference_no', 'period'));
    }

    public function payments_report(Request $request){
        config(['site.page' => 'payments_report']);
        
        $mod = new Payment();
        $reference_no = $period = '';
        if ($request->get('reference_no') != ""){
            $reference_no = $request->get('reference_no');
            $mod = $mod->where('reference_no', 'LIKE', "%$reference_no%");
        }
        if ($request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
            $mod = $mod->whereBetween('timestamp', [$from, $to]);
        }
        $pagesize = session('pagesize');
        if(!$pagesize){$pagesize = 15;}
        $data = $mod->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('reports.payments_report', compact('data', 'reference_no', 'period'));
    }

    public function customers_report(Request $request){
        config(['site.page' => 'customers_report']);
        $mod = new Customer();
        $company = $name = $phone_number = '';
        if ($request->get('company') != ""){
            $company = $request->get('company');
            $mod = $mod->where('company', 'LIKE', "%$company%");
        }
        if ($request->get('name') != ""){
            $name = $request->get('name');
            $mod = $mod->where('name', 'LIKE', "%$name%");
        }
        if ($request->get('phone_number') != ""){
            $phone_number = $request->get('phone_number');
            $mod = $mod->where('phone_number', 'LIKE', "%$phone_number%");
        }
        $pagesize = session('pagesize');
        if(!$pagesize){$pagesize = 15;}
        $data = $mod->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('reports.customers_report', compact('data', 'name', 'company', 'phone_number'));
    }
    public function suppliers_report(Request $request){
        config(['site.page' => 'suppliers_report']);
        $mod = new Supplier();
        $company = $name = $phone_number = '';
        if ($request->get('company') != ""){
            $company = $request->get('company');
            $mod = $mod->where('company', 'LIKE', "%$company%");
        }
        if ($request->get('name') != ""){
            $name = $request->get('name');
            $mod = $mod->where('name', 'LIKE', "%$name%");
        }
        if ($request->get('phone_number') != ""){
            $phone_number = $request->get('phone_number');
            $mod = $mod->where('phone_number', 'LIKE', "%$phone_number%");
        }
        $pagesize = session('pagesize');
        if(!$pagesize){$pagesize = 15;}
        $data = $mod->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('reports.suppliers_report', compact('data', 'name', 'company', 'phone_number'));
    }

    public function users_report(Request $request){
        config(['site.page' => 'users_report']);
        $companies = Company::all();
        $mod = new User();
        $company_id = $name = $phone_number = '';
        if ($request->get('company_id') != ""){
            $company_id = $request->get('company_id');
            $mod = $mod->where('company_id', 'LIKE', "%$company_id%");
        }
        if ($request->get('name') != ""){
            $name = $request->get('name');
            $mod = $mod->where('name', 'LIKE', "%$name%");
        }
        if ($request->get('phone_number') != ""){
            $phone_number = $request->get('phone_number');
            $mod = $mod->where('phone_number', 'LIKE', "%$phone_number%");
        }
        $pagesize = session('pagesize');
        if(!$pagesize){$pagesize = 15;}
        $data = $mod->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('reports.users_report', compact('data', 'companies', 'name', 'company_id', 'phone_number'));
    }
    
    

    











    
    
    
    
    
    
    
    public function getTodayData($table, $where = ''){        
        $sql = "select id from ".$table." where TO_DAYS(timestamp) = TO_DAYS(now()) ".$where;
        $orderables = collect(DB::select($sql))->pluck('id')->toArray();
        $return['count'] = count($orderables);
        if($table == 'purchases'){
            $return['total'] = Order::whereIn('orderable_id', $orderables)->where('orderable_type', Purchase::class)->sum('subtotal');
        }elseif($table == 'sales'){
            $return['total'] = Order::whereIn('orderable_id', $orderables)->where('orderable_type', Sale::class)->sum('subtotal');
        }       
        return $return;
    }

    public function getWeekData($table, $where = ''){
        $sql = "select id from ".$table." where YEARWEEK(DATE_FORMAT(timestamp,'%Y-%m-%d')) = YEARWEEK(now()) ".$where;
        $orderables = collect(DB::select($sql))->pluck('id')->toArray();
        $return['count'] = count($orderables);
        if($table == 'purchases'){
            $return['total'] = Order::whereIn('orderable_id', $orderables)->where('orderable_type', Purchase::class)->sum('subtotal');
        }elseif($table == 'sales'){
            $return['total'] = Order::whereIn('orderable_id', $orderables)->where('orderable_type', Sale::class)->sum('subtotal');
        }       
        return $return;
    }

    public function getMonthData($table, $where = ''){
        $sql = "select id from ".$table." where YEARWEEK(DATE_FORMAT(timestamp,'%Y-%m-%d')) = YEARWEEK(now()) ".$where;
        $orderables = collect(DB::select($sql))->pluck('id')->toArray();
        $return['count'] = count($orderables);
        if($table == 'purchases'){
            $return['total'] = Order::whereIn('orderable_id', $orderables)->where('orderable_type', Purchase::class)->sum('subtotal');
        }elseif($table == 'sales'){
            $return['total'] = Order::whereIn('orderable_id', $orderables)->where('orderable_type', Sale::class)->sum('subtotal');
        }       
        return $return;
    }

    public function getOverallData($table, $where = ''){
        $sql = "select id from ". $table . $where;
        $orderables = collect(DB::select($sql))->pluck('id')->toArray();
        $return['count'] = count($orderables);
        if($table == 'purchases'){
            $return['total'] = Order::whereIn('orderable_id', $orderables)->where('orderable_type', Purchase::class)->sum('subtotal');
        }elseif($table == 'sales'){
            $return['total'] = Order::whereIn('orderable_id', $orderables)->where('orderable_type', Sale::class)->sum('subtotal');
        }       
        return $return;
    }
}
