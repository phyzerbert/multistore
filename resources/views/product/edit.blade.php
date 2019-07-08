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
                <a class="breadcrumb-item active" href="#">Edit</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Edit Product</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <form class="form-layout form-layout-1" action="{{route('product.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$product->id}}" />
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Product Name: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="name" value="{{$product->name}}" placeholder="Product Name" required>
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Product Code: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="code" value="{{$product->code}}" placeholder="Product Code" required>
                                @error('code')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Barcode Symbology: <span class="tx-danger">*</span></label>
                                <select class="form-control select2" name="barcode_symbology_id" data-placeholder="Select Barcode Symbology" required>
                                    <option label="Select Barcode Symbology"></option>
                                    @foreach ($barcode_symbologies as $item)
                                        <option value="{{$item->id}}" @if($product->barcode_symbology_id == $item->id) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @error('barcode_symbology_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Category: <span class="tx-danger">*</span></label>
                                <select class="form-control select2" name="category_id" data-placeholder="Select Category" required>
                                    <option label="Select Category"></option>
                                    @foreach ($categories as $item)
                                        <option value="{{$item->id}}" @if($product->category_id == $item->id) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Product Unit: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="unit" value="{{$product->unit}}" placeholder="Product Unit" required>
                                @error('unit')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Product Cost: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="cost" value="{{$product->cost}}" placeholder="Product Cost" required>
                                @error('cost')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Product Price: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="price" value="{{$product->price}}" placeholder="Product Price" required>
                                @error('price')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Product Tax:</label>
                                <select class="form-control select2" name="tax_id" data-placeholder="Select Tax">
                                    <option label="Select Tax"></option>
                                    @foreach ($taxes as $item)
                                        <option value="{{$item->id}}" @if($product->tax_id == $item->id) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                 
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Tax Method:</label>
                                <select class="form-control select2" name="tax_method" data-placeholder="Select Tax Method">
                                    <option label="Select Tax Method"></option>
                                    <option value="0" @if($product->tax_method == 0) selected @endif>Inclusive</option>
                                    <option value="1" @if($product->tax_method == 1) selected @endif>Exclusive</option>
                                </select>
                            </div>
                        </div>
                    </div>                    
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Alert Quantity:</label>
                                <input class="form-control" type="text" name="alert_quantity" value="{{$product->alert_quantity}}" placeholder="Alert Quantity">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Supplier:</label>
                                <select class="form-control select2-show-search" name="supplier_id" data-placeholder="Product Supplier">
                                    <option label="Product Supplier"></option>
                                    @foreach ($suppliers as $item)
                                        <option value="{{$item->id}}" @if($product->supplier_id == $item->id) selected @endif>{{$item->name}}</option>
                                    @endforeach                                    
                                </select>
                            </div>
                        </div>                        
                        <div class="col-lg-4">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Product Image:</label>                                
                                <label class="custom-file wd-100p">
                                    <input type="file" name="image" id="file2" class="custom-file-input" accept="image/*">
                                    <span class="custom-file-control custom-file-control-primary"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Product Detail:</label>
                                <textarea class="form-control" name="detail" rows="5" placeholder="Enter address">{{$product->detail}}</textarea>
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
<script>
    $(document).ready(function () {
        

    });
</script>
@endsection
