@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/lib/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.home')}}</a>
                <a class="breadcrumb-item" href="#">{{__('page.purchase')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.detail')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-info-circle"></i> {{__('page.purchase_detail')}}</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-body tx-white-8 bg-success mg-y-10 bd-0 ht-150 purchase-card">
                            <div class="row">
                                <div class="col-3">
                                    <span class="tx-70"><i class="fa fa-plug"></i></span>
                                </div>
                                <div class="col-9">
                                    <h4 class="card-title tx-white tx-medium mg-b-10">{{__('page.supplier')}}</h4>
                                    <p class="tx-16 mg-b-3">{{__('page.name')}}: {{$purchase->supplier->name}}</p>
                                    <p class="tx-16 mg-b-3">{{__('page.email')}}: {{$purchase->supplier->email}}</p>
                                    <p class="tx-16 mg-b-3">{{__('page.phone')}}: {{$purchase->supplier->phone_number}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-body bg-teal tx-white mg-y-10 bd-0 ht-150 purchase-card">
                            <div class="row">
                                <div class="col-3">
                                    <span class="tx-70"><i class="fa fa-truck"></i></span>
                                </div>
                                <div class="col-9">
                                    <h4 class="card-title tx-white tx-medium mg-b-10">{{__('page.store')}}</h4>
                                    <p class="tx-16 mg-b-3">{{__('page.name')}}: {{$purchase->store->name}}</p>
                                    <p class="tx-16 mg-b-3">{{__('page.company')}}: {{$purchase->store->company->name}}</p>
                                    <p class="tx-16 mg-b-3"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-body bg-info tx-white-8 mg-y-10 bd-0 ht-150 purchase-card">
                            <div class="row">                                
                                <div class="col-3">
                                    <span class="tx-70"><i class="fa fa-file-text-o"></i></span>
                                </div>
                                <div class="col-9">
                                    <h4 class="card-title tx-white tx-medium mg-b-10">{{__('page.reference')}}</h4>
                                    <p class="tx-16 mg-b-3">{{__('page.number')}}: {{$purchase->reference_no}}</p>
                                    <p class="tx-16 mg-b-3">{{__('page.date')}}: {{$purchase->timestamp    }}</p>
                                    <p class="tx-16 mg-b-3">
                                        {{__('page.attachment')}}: 
                                        @if ($purchase->attachment != "")
                                            <a href="{{asset($purchase->attachment)}}" download>&nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip"></i></a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mg-t-20">
                    <div class="col-md-12 table-responsive">
                        <h5>Orders Item</h5>
                        <table class="table table-bordered table-colored table-info">
                            <thead>
                                <tr>
                                    <th class="wd-40">#</th>
                                    <th>{{__('page.product_name_code')}}</th>
                                    <th>{{__('page.product_cost')}}</th>
                                    <th>{{__('page.quantity')}}</th>
                                    <th>{{__('page.product_tax')}}</th>
                                    <th>{{__('page.subtotal')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_quantity = 0;
                                    $total_tax_rate = 0;
                                    $total_amount = 0;
                                    $paid = $purchase->payments()->sum('amount');
                                @endphp
                                @foreach ($purchase->orders as $item)
                                @php
                                    $tax = $item->product->tax->rate;
                                    $quantity = $item->quantity;
                                    $cost = $item->product->cost;
                                    $tax_rate = $cost * $tax / 100;
                                    $subtotal = $quantity*($cost + $tax_rate);

                                    $total_quantity += $quantity;
                                    $total_tax_rate += $tax_rate;
                                    $total_amount += $subtotal;
                                @endphp
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$item->product->name}} ({{$item->product->code}})</td>
                                        <td>{{$item->product->cost}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{$item->product->tax->name}}</td>
                                        <td>{{$item->subtotal}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="tx-bold" style="text-align:right">{{__('page.total')}} (COP)</td>
                                    <td>{{$total_quantity}}</td>
                                    <td>{{$total_tax_rate}}</td>
                                    <td>{{$total_amount}}</td>
                                </tr>
                            </tbody>
                            <tfoot class="tx-bold tx-black">
                                <tr>
                                    <td colspan="5" style="text-align:right">{{__('page.total_amount')}} (COP)</td>
                                    <td>{{$total_amount}}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align:right">{{__('page.paid')}} (COP)</td>
                                    <td>{{$paid}}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align:right">{{__('page.balance')}} (COP)</td>
                                    <td>{{$total_amount - $paid}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 card card-body tx-white-8 bg-success mg-l-15 bd-0 d-block" style="float:right !important;">                            
                        <h6 class="card-title tx-white tx-medium mg-b-5">{{__('page.created_by')}} {{$purchase->user->name}}</h6>
                        <h6 class="card-title tx-white tx-medium mg-y-5">{{__('page.created_at')}} {{$purchase->created_at}}</h6>
                    </div>
                </div>
            </div>
        </div>                
    </div>
@endsection

@section('script')
<script src="{{asset('master/lib/select2/js/select2.min.js')}}"></script>
<script>
    $(document).ready(function () {
        

    });
</script>
@endsection
