@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/lib/jquery-ui/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/daterangepicker/daterangepicker.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="#">Report</a>
                <a class="breadcrumb-item active" href="#">Payments Report</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-credit-card"></i> Payments Report</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="">
                    @php
                        $pagesize = session('pagesize');
                        if(!$pagesize){$pagesize = 15;}
                    @endphp     
                    <form class="form-inline ml-3 float-left mb-2" action="{{route('set_pagesize')}}" method="post" id="pagesize_form">
                        @csrf
                        <label for="pagesize" class="control-label">{{__('Show')}} :</label>
                        <select class="form-control form-control-sm mx-2" name="pagesize" id="pagesize">
                            <option value="" @if($pagesize == '') selected @endif>15</option>
                            <option value="25" @if($pagesize == '25') selected @endif>25</option>
                            <option value="50" @if($pagesize == '50') selected @endif>50</option>
                            <option value="100" @if($pagesize == '100') selected @endif>100</option>
                        </select>
                    </form>
                    {{-- @include('sale.filter') --}}
                </div>
                <div class="table-responsive mg-t-2">
                    <table class="table table-bordered table-colored table-primary table-hover">
                        <thead class="thead-colored thead-primary">
                            <tr class="bg-blue">
                                <th style="width:40px;">#</th>
                                <th>Date</th>
                                <th>Referenct No</th>
                                <th>Sale Reference</th>
                                <th>Purchase Reference</th>
                                <th>Amount</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($data as $item)
                            @php
                                // $grand_total = $item->orders()->sum('subtotal');
                                // $paid = $item->payments()->sum('amount');
                            @endphp
                                <tr>
                                    <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td class="timestamp">{{date('Y-m-d H:i', strtotime($item->timestamp))}}</td>
                                    <td class="reference_no">{{$item->reference_no}}</td>
                                    <td class="sale" data-id="{{$item->paymentable_id}}">
                                        @if ($item->paymentable_type == 'App\Models\Sale')
                                            {{$item->paymentable->reference_no}}
                                        @endif                                        
                                    </td>
                                    <td class="purchase" data-id="{{$item->paymentable_id}}">
                                        @if ($item->paymentable_type == 'App\Models\Purchase')
                                            {{$item->paymentable->reference_no}}
                                        @endif  
                                    </td>
                                    <td class="amount"> {{number_format($item->amount)}} </td>
                                    <td class="type">
                                        @if ($item->paymentable_type == "App\Models\Purchase")
                                            <span class="tx-success">Sent</span>
                                        @elseif($item->paymentable_type == "App\Models\Sale")
                                            <span class="tx-info">Received</span>
                                        @endif
                                    </td>
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
<script src="{{asset('master/lib/jquery-ui/jquery-ui.js')}}"></script>
<script src="{{asset('master/lib/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.js')}}"></script>
<script src="{{asset('master/lib/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $("#payment_form input.date").datetimepicker({
            dateFormat: 'yy-mm-dd',
        });
        
        

        // $("#period").dateRangePicker({
        //     autoClose: false,
        // });

        $("#pagesize").change(function(){
            $("#pagesize_form").submit();
        });

        $("#btn-reset").click(function(){
            $("#search_company").val('');
            $("#search_store").val('');
            $("#search_supplier").val('');
            $("#search_reference_no").val('');
            $("#period").val('');
        });

    });
</script>
@endsection
