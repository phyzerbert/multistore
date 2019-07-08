@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/lib/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
                <a class="breadcrumb-item" href="#">Product</a>
                <a class="breadcrumb-item active" href="#">Detail</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Product Detail</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{asset($product->image)}}" width="100%" alt="">
                        <br><br>
                        <h5>Product Description</h5>
                        <p class="tx-black">
                            {{$product->detail}}                 
                        </p>
                    </div>
                    <div class="col-md-8">
                        <h4>Product Details</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr class="bd-0-force">
                                        <td class="wd-40p" style="text-align:right">Product Name :</td>
                                        <td class="tx-bold tx-black">{{$product->name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="wd-40p" style="text-align:right">Product Code :</td>
                                        <td class="tx-bold tx-black">{{$product->code}}</td>
                                    </tr>
                                    <tr>
                                        <td class="wd-40p" style="text-align:right">Product Category :</td>
                                        <td class="tx-bold tx-black">{{$product->category->name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="wd-40p" style="text-align:right">Product Unit :</td>
                                        <td class="tx-bold tx-black">{{$product->unit}}</td>
                                    </tr>
                                    <tr>
                                        <td class="wd-40p" style="text-align:right">Product Cost :</td>
                                        <td class="tx-bold tx-black">{{$product->cost}}</td>
                                    </tr>
                                    <tr>
                                        <td class="wd-40p" style="text-align:right">Product Price :</td>
                                        <td class="tx-bold tx-black">{{$product->price}}</td>
                                    </tr>
                                    <tr>
                                        <td class="wd-40p" style="text-align:right">Tax Rate :</td>
                                        <td class="tx-bold tx-black">{{$product->tax->name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="wd-40p" style="text-align:right">Tax Method :</td>
                                        <td class="tx-bold tx-black">
                                            @if ($product->tax_method == 0)
                                                Inclusive
                                            @elseif($product->tax_method == 1)
                                                Exclusive
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="wd-40p" style="text-align:right">Alert Quantity :</td>
                                        <td class="tx-bold tx-black">{{$product->alert_quantity}}</td>
                                    </tr>
                                    <tr>
                                        <td class="wd-40p" style="text-align:right">Supplier :</td>
                                        <td class="tx-bold tx-black">{{$product->supplier->name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="{{route('product.index')}}" class="btn btn-warning btn-with-icon btn-block mg-t-10 wd-100" style="float:right">
                            <div class="ht-40">
                                <span class="icon wd-40"><i class="fa fa-undo"></i></span>
                                <span class="pd-x-15 tx-center">Back</span>
                            </div>
                        </a>
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
