@extends('layouts.master')

@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
                <a class="breadcrumb-item" href="#">Settings</a>
                <a class="breadcrumb-item active" href="#">Category</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="ion icon-git-network"></i> Category Management</h4>
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
                                <th>Image</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Alert Quantity</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($data as $item)
                                @php
                                    $quantity = \App\Models\StoreProduct::where('product_id', $item->id)->sum('quantity');
                                @endphp
                                @if ($item->alert_quantity >= $quantity)                                
                                    <tr>
                                        <td class="wd-40">{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="image py-1 wd-60"><img src="{{asset($item->image)}}" class="wd-40 ht-40 rounded-circle" alt=""></td>
                                        <td>{{$item->code}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$quantity}}</td>
                                        <td>{{$item->alert_quantity}}</td>                                        
                                    </tr>
                                @endif
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
