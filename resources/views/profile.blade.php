@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/lib/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
                <a class="breadcrumb-item active" href="#">Profile</a>
            </nav>
        </div>      
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="container">
                <div class="pd-t-20 pd-sm-t-30">
                    <h4 class="tx-gray-800 mg-b-5"><i class="fa fa-user-circle"></i> My Profile</h4>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-body">
                            <div class="text-center profile-image">
                                <img src="@if($user->picture){{asset($user->picture)}}@else{{asset('images/avatar128.png')}}@endif" width="75%" class="rounded-circle" alt="">
                            </div>
                            <p class="tx-info text-center mt-4">{{$user->first_name}} {{$user->last_name}}</p>
                            <p class="tx-primary text-center">{{$user->role->name}}</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-body">                        
                            <form class="form-layout form-layout-1" action="{{route('updateuser')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">UserName: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" value="{{$user->name}}" placeholder="Product Name" required>
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Phone Number: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="phone_number" value="{{$user->phone_number}}" placeholder="Phone Number" required>
                                    @error('phone_number')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">First Name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="first_name" value="{{$user->first_name}}" placeholder="First Name" required>
                                    @error('first_name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Last Name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="last_name" value="{{$user->last_name}}" placeholder="Last Name" required>
                                    @error('last_name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Company: <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="company" class="wd-100" data-placeholder="Select Company">
                                        <option label="Select Company"></option>
                                        @foreach ($companies as $item)
                                            <option value="{{$item->id}}" @if($user->company_id == $item->id) selected @endif>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('company')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Product Image:</label>                                
                                    <label class="custom-file wd-100p">
                                        <input type="file" name="picture" id="file2" class="custom-file-input" accept="image/*">
                                        <span class="custom-file-control custom-file-control-primary"></span>
                                    </label>
                                </div> 
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Password: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="password" name="password" placeholder="Password">
                                </div>
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Confirm Password: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="password" name="password_confirm" placeholder="Confirm Password">
                                </div>
                                <div class="form-layout-footer text-right mt-5">
                                    <button type="submit" class="btn btn-primary tx-20"><i class="fa fa-floppy-o mg-r-2"></i> Save</button>
                                </div>
                            </form>
                        </div>
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
