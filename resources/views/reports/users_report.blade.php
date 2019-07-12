@extends('layouts.master')

@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">{{__('page.reports')}}</a>
                <a class="breadcrumb-item active" href="#">{{__('page.users_report')}}</a>
            </nav>
        </div>
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-user"></i> {{__('page.users_report')}}</h4>
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
                                <th>{{__('page.username')}}</th>
                                <th>{{__('page.first_name')}}</th>
                                <th>{{__('page.last_name')}}</th>
                                <th>{{__('page.phone_number')}}</th>
                                <th>{{__('page.company')}}</th>
                                <th>{{__('page.role')}}</th>
                                <th>{{__('page.status')}}</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($data as $item)                             
                                <tr>
                                    <td class="wd-40">{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->first_name}}</td>
                                    <td>{{$item->last_name}}</td>
                                    <td>{{$item->phone_number}}</td>
                                    <td>@isset($item->company){{$item->company->name}}@endisset</td>
                                    <td>@isset($item->role->name){{$item->role->name}}@endisset</td>
                                    <td>{{$item->status}}</td>                                      
                                    {{-- <td></td>--}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                
                    <div class="clearfix mt-2">
                        <div class="float-left" style="margin: 0;">
                            <p>{{__('page.total')}} <strong style="color: red">{{ $data->total() }}</strong> {{__('page.items')}}</p>
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
