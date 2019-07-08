@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/lib/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-ui/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('master/lib/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
                <a class="breadcrumb-item" href="#">Purchase</a>
                <a class="breadcrumb-item active" href="#">Add</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Add Purchase</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <form class="form-layout form-layout-1" action="{{route('purchase.save')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Purchase Date: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="date" id="purchase_date" placeholder="Purchase Date" autocomplete="off" required>
                                @error('date')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                        
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Reference Number:</label>
                                <input class="form-control" type="text" name="reference_number" placeholder="Reference Number">
                                @error('reference_number')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Store:</label>
                                <select class="form-control select2" name="store_id" data-placeholder="Select Store">
                                    <option label="Product Supplier"></option>
                                    @foreach ($stores as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach                                    
                                </select>
                            </div>
                        </div>
                    </div>                    
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Supplier:</label>
                                <select class="form-control select2-show-search" name="supplier_id" data-placeholder="Supplier">
                                    <option label="Supplier"></option>
                                    @foreach ($suppliers as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach                                    
                                </select>
                            </div>
                        </div>                        
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Attachment:</label>                                
                                <label class="custom-file wd-100p">
                                    <input type="file" name="attachment" id="file2" class="custom-file-input">
                                    <span class="custom-file-control custom-file-control-primary"></span>
                                </label>
                            </div>
                        </div>                        
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Status:</label>
                                <select class="form-control select2" name="status" data-placeholder="Status">
                                    <option label="Status"></option>
                                    <option value="0">Pending</option>
                                    <option value="1">Received</option>                                
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-b-25">
                        <div class="col-md-12">                            
                            <div>
                                <h5 class="mg-t-10" style="float:left">Order Items</h5>
                                {{-- <button type="button" class="btn btn-primary mg-b-10 add-product" style="float:right">ADD</button> --}}
                                <a href="#" class="btn btn-primary btn-icon rounded-circle mg-b-10 add-product" style="float:right"><div><i class="fa fa-plus"></i></div></a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-colored table-success" id="product_table">
                                    <thead>
                                        <tr>
                                            <th>Product Name(Code)</th>
                                            <th>Product Cost</th>
                                            <th>Quantity</th>
                                            <th>Product Tax</th>
                                            <th>Subtotal</th>
                                            <th style="width:30px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control input-sm product" name="product_id[]">
                                                    <option value="">Select a product</option>
                                                    @foreach ($products as $item)
                                                        <option value="{{$item->id}}"  
                                                            data-cost="{{$item->cost}}"   
                                                            data-taxname="{{$item->tax->name}}"
                                                            data-taxrate="{{$item->tax->rate}}"
                                                        >{{$item->name}}</option>
                                                    @endforeach                                    
                                                </select>
                                            </td>
                                            <td class="cost"></td>
                                            <td><input type="number" class="form-control input-sm quantity" name="quantity[]" placeholder="Quantity" /></td>
                                            <td class="tax"></td>
                                            <td class="subtotal"></td>
                                            <td>
                                                <a href="#" class="btn btn-warning btn-icon rounded-circle mg-t-3 remove-product"><div style="width:25px;height:25px;"><i class="fa fa-times"></i></div></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Total</td>
                                            <td class="total_quantity"></td>
                                            <td class="total_tax"></td>
                                            <td colspan="2" class="total"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Note:</label>
                                <textarea class="form-control" name="note" rows="5" placeholder="Note"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-layout-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check mg-r-2"></i>Save</button>
                        <a href="{{route('product.index')}}" class="btn btn-warning"><i class="fa fa-times mg-r-2"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>                
    </div>
@endsection

@section('script')
<script src="{{asset('master/lib/select2/js/select2.min.js')}}"></script>
<script src="{{asset('master/lib/jquery-ui/jquery-ui.js')}}"></script>
<script src="{{asset('master/lib/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.js')}}"></script>
<script>
    $(document).ready(function () {
        
        $("#purchase_date").datetimepicker({
            dateFormat: 'yy-mm-dd',
        });
        $(".expire_date").datepicker({
            dateFormat: 'yy-mm-dd',
        });

        $("#product_table .product").change(function(){
            let cost = $(this).find('option:selected').data('cost');
            let taxname = $(this).find('option:selected').data('taxname');
            let taxrate = $(this).find('option:selected').data('taxrate');
            $("#product_table .cost").text(cost);
            $("#product_table .tax").text(taxname);
            console.log(taxrate);
            $("#product_table .quantity").change(function(){
                // console.log(taxrate);
                let quantity = $(this).val();
                let subtotal = (cost*(taxrate/100) + cost)*quantity;
                console.log(subtotal);
                $("#product_table .subtotal").text(subtotal);

            });
        });

        $(".add-product").click(function(){
            // console.log($("#product_table tbody tr:first-child").html());
            let tr_data = $("#product_table tbody tr:first-child").html();
            $("#product_table tbody").append('<tr>'+tr_data+'</tr>');
        });

        $(".remove-product").click(function(){
            $(this).parents("tr").remove();
        });
        

    });
</script>
@endsection
