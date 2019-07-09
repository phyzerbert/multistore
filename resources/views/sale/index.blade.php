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
                <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
                <a class="breadcrumb-item" href="#">Sales</a>
                <a class="breadcrumb-item active" href="#">List</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Sales List</h4>
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
                    <form class="form-inline ml-3 float-left" action="{{route('set_pagesize')}}" method="post" id="pagesize_form">
                        @csrf
                        <label for="pagesize" class="control-label">{{__('Show')}} :</label>
                        <select class="form-control form-control-sm mx-2" name="pagesize" id="pagesize">
                            <option value="" @if($pagesize == '') selected @endif>15</option>
                            <option value="25" @if($pagesize == '25') selected @endif>25</option>
                            <option value="50" @if($pagesize == '50') selected @endif>50</option>
                            <option value="100" @if($pagesize == '100') selected @endif>100</option>
                        </select>
                    </form>
                    @include('sale.filter')
                    <a href="{{route('sale.create')}}" class="btn btn-success btn-sm float-right mg-b-5" id="btn-add"><i class="fa fa-plus mg-r-2"></i> Add New</a>
                </div>
                <div class="table-responsive mg-t-2">
                    <table class="table table-bordered table-colored table-primary table-hover">
                        <thead class="thead-colored thead-primary">
                            <tr class="bg-blue">
                                <th style="width:40px;">#</th>
                                <th>Date</th>
                                <th>Referenct No</th>
                                <th>User</th>
                                <th>Customer</th>
                                <th>Sale Status</th>
                                <th>Grand Total</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                {{-- <th>Payment Status</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($data as $item)
                            @php
                                $grand_total = $item->orders()->sum('subtotal');
                                $paid = $item->payments()->sum('amount');
                            @endphp
                                <tr>
                                    <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td class="timestamp">{{date('Y-m-d H:i', strtotime($item->timestamp))}}</td>
                                    <td class="reference_no">{{$item->reference_no}}</td>
                                    <td class="user">{{$item->biller->name}}</td>
                                    <td class="customer" data-id="{{$item->customer_id}}">{{$item->customer->name}}</td>
                                    <td class="status">
                                        @if ($item->status == 1)
                                            <span class="tx-success">Received</span>
                                        @elseif($item->status == 0)
                                            <span class="tx-info">Pending</span>
                                        @endif
                                    </td>
                                    <td class="grand_total"> {{number_format($grand_total)}} </td>
                                    <td class="paid"> {{ number_format($paid) }} </td>
                                    <td> {{number_format($grand_total - $paid)}} </td>
                                    {{-- <td></td> --}}
                                    <td class="py-2" align="center">
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-info btn-with-icon nav-link" data-toggle="dropdown">
                                                <div class="ht-30">
                                                    <span class="icon wd-30"><i class="fa fa-send"></i></span>
                                                    <span class="pd-x-15">Action</span>
                                                </div>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-header action-dropdown bd-t-1">
                                                <ul class="list-unstyled user-profile-nav">
                                                    <li><a href="{{route('sale.detail', $item->id)}}"><i class="icon ion-eye  "></i> Details</a></li>
                                                    <li><a href="{{route('payment.index', ['sale', $item->id])}}"><i class="icon ion-cash"></i> Payment List</a></li>
                                                    <li><a href="#" data-id="{{$item->id}}" class="btn-add-payment"><i class="icon ion-cash"></i> Add Payment</a></li>
                                                    @if($role == 'admin')
                                                        <li><a href="{{route('sale.edit', $item->id)}}"><i class="icon ion-compose"></i> Edit</a></li>
                                                        <li><a href="{{route('sale.delete', $item->id)}}" onclick="return window.confirm('Are you sure?')"><i class="icon ion-trash-a"></i> Delete</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
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

    <!-- The Modal -->
    <div class="modal fade" id="paymentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Payment</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('payment.create')}}" id="payment_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="type" name="type" value="sale" />
                    <input type="hidden" class="paymentable_id" name="paymentable_id" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <input class="form-control date" type="text" name="date" autocomplete="off" value="{{date('Y-m-d H:i')}}" placeholder="Date">
                        </div>                        
                        <div class="form-group">
                            <label class="control-label">Reference No</label>
                            <input class="form-control reference_no" type="text" name="reference_no" placeholder="Reference Number">
                        </div>                                                
                        <div class="form-group">
                            <label class="control-label">Amount</label>
                            <input class="form-control amount" type="text" name="amount" placeholder="Amount">
                        </div>                                               
                        <div class="form-group">
                            <label class="control-label">Attachment</label>
                            <label class="custom-file wd-100p">
                                <input type="file" name="attachment" id="file2" class="custom-file-input">
                                <span class="custom-file-control custom-file-control-primary"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Note</label>
                            <textarea class="form-control note" type="text" name="note" placeholder="Note"></textarea>
                        </div> 
                    </div>    
                    <div class="modal-footer">
                        <button type="submit" id="btn_create" class="btn btn-primary btn-submit"><i class="fa fa-check mg-r-10"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mg-r-10"></i>&nbsp;Close</button>
                    </div>
                </form>
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
        
        $(".btn-add-payment").click(function(){
            // $("#payment_form input.form-control").val('');
            let id = $(this).data('id');
            $("#payment_form .paymentable_id").val(id);
            $("#paymentModal").modal();
        });

        $("#period").dateRangePicker({
            autoClose: false,
        });

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
