@extends('layouts.master')

@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">Report</a>
                <a class="breadcrumb-item active" href="#">Customers Report</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-user-circle-o"></i> Customers Report</h4>
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
                                <th>Company</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email Address</th>
                                <th>Total Sales</th>
                                <th>Total Amount</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($data as $item)
                                @php
                                    $sales_array = $item->sales()->pluck('id');
                                    $total_sales = $item->sales()->count();
                                    $total_amount = \App\Models\Order::whereIn('orderable_id', $sales_array)->where('orderable_type', "App\Models\Sale")->sum('subtotal');
                                    $paid = \App\Models\Payment::whereIn('paymentable_id', $sales_array)->where('paymentable_type', "App\Models\Sale")->sum('amount'); 
                                @endphp                              
                                <tr>
                                    <td class="wd-40">{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td>{{$item->company}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->phone_number}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{number_format($total_sales)}}</td>
                                    <td>{{number_format($total_amount)}}</td>                                        
                                    <td>{{number_format($paid)}}</td>
                                    <td>{{number_format($total_amount - $paid)}}</td>                                      
                                    {{-- <td></td>--}}
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
