<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\StoreProduct;
use App\Models\Sale;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Category;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Supplier;

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

        $data = Product::paginate(10);        

        return view('reports.product_quantity_alert', compact('data'));
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
