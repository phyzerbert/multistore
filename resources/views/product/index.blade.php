@extends('layouts.master')

@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
                <a class="breadcrumb-item" href="#">Product</a>
                <a class="breadcrumb-item active" href="#">List</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Product Management</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="">
                    @if ($role == 'admin')
                        <a href="{{route('product.create')}}" class="btn btn-success btn-sm float-right tx-white mg-b-5" id="btn-add"><i class="fa fa-plus mg-r-2"></i> Add New</a>
                    @endif
                </div>
                <div class="table-responsive mg-t-2">
                    <table class="table table-bordered table-colored table-primary table-hover">
                        <thead class="thead-colored thead-primary">
                            <tr class="bg-blue">
                                <th style="width:30px;">#</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Product Cost</th>
                                <th>Product Price</th>
                                <th>Quantity</th>
                                <th>Product Unit</th>
                                <th>Alert Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td class="code">{{$item->code}}</td>
                                    <td class="name">{{$item->name}}</td>
                                    <td class="category">{{$item->category->name}}</td>
                                    <td class="cost">{{$item->cost}}</td>
                                    <td class="price">{{$item->price}}</td>
                                    <td class="quantity">{{$item->quantity}}</td>
                                    <td class="unit">{{$item->unit}}</td>
                                    <td class="alert_quantity">{{$item->alert_quantity}}</td>
                                    <td class="py-2 dropdown" align="center">
                                        <a href="#" class="btn btn-info btn-with-icon nav-link" data-toggle="dropdown">
                                            <div class="ht-30">
                                                <span class="icon wd-30"><i class="fa fa-send"></i></span>
                                                <span class="pd-x-15">Action</span>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-header pd-l-5 pd-r-5 bd-t-1" style="min-width:9rem">
                                            <ul class="list-unstyled user-profile-nav">
                                                <li><a href="{{route('product.detail', $item->id)}}"><i class="icon ion-eye  "></i> Details</a></li>
                                                {{-- <li><a href="{{route('product.duplicate', $item->id)}}"><i class="icon ion-ios-photos-outline"></i> Duplicate</a></li> --}}
                                                @if($role == 'admin')
                                                <li><a href="{{route('product.edit', $item->id)}}"><i class="icon ion-compose"></i> Edit</a></li>
                                                <li><a href="{{route('product.delete', $item->id)}}" onclick="return window.confirm('Are you sure?')"><i class="icon ion-trash-a"></i> Delete</a></li>
                                                @endif
                                            </ul>
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

@endsection

@section('script')
<script>
    $(document).ready(function () {

    });
</script>
@endsection
