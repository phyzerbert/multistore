@extends('layouts.master')

@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.reports')}}</a>
                <a class="breadcrumb-item active" href="#">Categories Report</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-code-fork"></i> {{__('page.category_report')}}</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="table-responsive mg-t-2">
                    <table class="table table-bordered table-colored table-primary table-hover">
                        <thead class="thead-colored thead-primary">
                            <tr class="bg-blue">
                                <th class="wd-40">#</th>
                                <th>{{__('page.category_name')}}</th>
                                <th>{{__('page.purchased')}}</th>
                                <th>{{__('page.sold')}}</th>
                                <th>{{__('page.purchased_amount')}}</th>
                                <th>{{__('page.sold_amount')}}</th>
                                <th>{{__('page.profit_loss')}}</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($data as $item)
                                @php
                                    $product_array = $item->products()->pluck('id');
                                    $purchased_quantity = \App\Models\Order::whereIn('product_id', $product_array)->where('orderable_type', "App\Models\Purchase")->sum('quantity');
                                    $sold_quantity = \App\Models\Order::whereIn('product_id', $product_array)->where('orderable_type', "App\Models\Sale")->sum('quantity');                                    
                                    $purchased_amount = \App\Models\Order::whereIn('product_id', $product_array)->where('orderable_type', "App\Models\Purchase")->sum('subtotal');
                                    $sold_amount = \App\Models\Order::whereIn('product_id', $product_array)->where('orderable_type', "App\Models\Sale")->sum('subtotal');
                                @endphp                              
                                <tr>
                                    <td class="wd-40">{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{number_format($purchased_quantity)}}</td>
                                    <td>{{number_format($sold_quantity)}}</td>                                        
                                    <td>{{number_format($purchased_amount)}}</td>
                                    <td>{{number_format($sold_amount)}}</td>                                      
                                    <td>{{number_format($sold_amount - $purchased_amount)}}</td>                                      
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                
                    <div class="clearfix mt-2">
                        <div class="float-left" style="margin: 0;">
                            <p>Total <strong style="color: red">{{ $data->total() }}</strong> Items</p>
                        </div>
                        <div class="float-right" style="margin: 0;">
                            {!! $data->appends([])->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        
    });
</script>
@endsection
