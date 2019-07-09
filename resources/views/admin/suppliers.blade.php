@extends('layouts.master')

@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
                <a class="breadcrumb-item active" href="#">Suppliers</a>
            </nav>
        </div><!-- br-pageheader -->
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Supplier Management</h4>
        </div>
        
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="">
                    @if ($role == 'admin')
                        <button type="button" class="btn btn-success btn-sm float-right mg-b-5" id="btn-add"><i class="icon ion-person-add mg-r-2"></i> Add New</button>
                    @endif
                </div>
                <div class="table-responsive mg-t-2">
                    <table class="table table-bordered table-colored table-primary table-hover">
                        <thead class="thead-colored thead-primary">
                            <tr class="bg-blue">
                                <th style="width:30px;">#</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>City</th>
                                <th>Address</th>
                                @if($role == 'admin')
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td class="name">{{$item->name}}</td>
                                    <td class="company" data-id="{{$item->company}}">@isset($item->company){{$item->company}}@endisset</td>
                                    <td class="email">{{$item->email}}</td>
                                    <td class="phone_number">{{$item->phone_number}}</td>
                                    <td class="city">{{$item->city}}</td>
                                    <td class="address">{{$item->address}}</td>
                                    @if($role == 'admin')
                                    <td class="py-1">
                                        <a href="#" class="btn btn-primary btn-icon rounded-circle mg-r-5 btn-edit" data-id="{{$item->id}}"><div><i class="fa fa-edit"></i></div></a>
                                        <a href="{{route('supplier.delete', $item->id)}}" class="btn btn-danger btn-icon rounded-circle mg-r-5" data-id="{{$item->id}}" onclick="return window.confirm('Are you sure?')"><div><i class="fa fa-trash-o"></i></div></a>
                                    </td>
                                    @endif
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
    @if($role == 'admin')
    <!-- The Modal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="create_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control name" type="text" name="name" placeholder="Supplier Name">
                            <span id="name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Company</label>
                            <input class="form-control company" type="text" name="company" placeholder="Company Name">
                            <span id="company_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input class="form-control email" type="email" name="email" placeholder="Email Address">
                            <span id="email_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input class="form-control phone_number" type="text" name="phone_number" placeholder="Phone Number">
                            <span id="phone_number_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <input class="form-control address" type="text" name="address" placeholder="Address">
                            <span id="address_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <input class="form-control city" type="text" name="city" placeholder="City">
                            <span id="city_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" id="btn_create" class="btn btn-primary btn-submit"><i class="fa fa-check mg-r-10"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mg-r-10"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="edit_form" method="post">
                    @csrf
                    <input type="hidden" name="id" class="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control name" type="text" name="name" placeholder="Supplier Name">
                            <span id="edit_name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Company</label>
                            <input class="form-control company" type="text" name="company" placeholder="Company Name">
                            <span id="edit_company_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input class="form-control email" type="email" name="email" placeholder="Email Address">
                            <span id="edit_email_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input class="form-control phone_number" type="text" name="phone_number" placeholder="Phone Number">
                            <span id="edit_phone_number_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <input class="form-control address" type="text" name="address" placeholder="Address">
                            <span id="edit_address_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <input class="form-control city" type="text" name="city" placeholder="City">
                            <span id="edit_city_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    </div>  
                    <div class="modal-footer">
                        <button type="button" id="btn_update" class="btn btn-primary btn-submit"><i class="fa fa-check mg-r-10"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mg-r-10"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('script')
<script>
    $(document).ready(function () {
        
        $("#btn-add").click(function(){
            $("#create_form input.form-control").val('');
            $("#create_form .invalid-feedback strong").text('');
            $("#addModal").modal();
        });

        $("#btn_create").click(function(){          
            $.ajax({
                url: "{{route('supplier.create')}}",
                type: 'post',
                dataType: 'json',
                data: $('#create_form').serialize(),
                success : function(data) {
                    if(data == 'success') {
                        alert('Created successfully.');
                        window.location.reload();
                    }
                    else if(data.message == 'The given data was invalid.') {
                        alert(data.message);
                    }
                },
                error: function(data) {
                    console.log(data.responseJSON);
                    if(data.responseJSON.message == 'The given data was invalid.') {
                        let messages = data.responseJSON.errors;
                        if(messages.name) {
                            $('#name_error strong').text(data.responseJSON.errors.name[0]);
                            $('#name_error').show();
                            $('#create_form .name').focus();
                        }
                        
                        if(messages.company) {
                            $('#company_error strong').text(data.responseJSON.errors.company[0]);
                            $('#company_error').show();
                            $('#create_form .company').focus();
                        }

                        if(messages.email) {
                            $('#email_error strong').text(data.responseJSON.errors.email[0]);
                            $('#email_error').show();
                            $('#create_form .email').focus();
                        }

                        if(messages.phone_number) {
                            $('#phone_number_error strong').text(data.responseJSON.errors.phone_number[0]);
                            $('#phone_number_error').show();
                            $('#create_form .phone_number').focus();
                        }

                        if(messages.address) {
                            $('#address_error strong').text(data.responseJSON.errors.address[0]);
                            $('#address_error').show();
                            $('#create_form .address').focus();
                        }

                        if(messages.city) {
                            $('#city_error strong').text(data.responseJSON.errors.city[0]);
                            $('#city_error').show();
                            $('#create_form .city').focus();
                        }
                    }
                }
            });
        });

        $(".btn-edit").click(function(){
            let id = $(this).data("id");
            let name = $(this).parents('tr').find(".name").text().trim();
            let company = $(this).parents('tr').find(".company").text().trim();
            let email = $(this).parents('tr').find(".email").text().trim();
            let phone_number = $(this).parents('tr').find(".phone_number").text().trim();
            let city = $(this).parents('tr').find(".city").text().trim();
            let address = $(this).parents('tr').find(".address").text().trim();

            $("#edit_form input.form-control").val('');
            $("#editModal .id").val(id);
            $("#editModal .name").val(name);
            $("#editModal .company").val(company);
            $("#editModal .email").val(email);
            $("#editModal .phone_number").val(phone_number);
            $("#editModal .city").val(city);
            $("#editModal .address").val(address);

            $("#editModal").modal();
        });

        $("#btn_update").click(function(){
            $.ajax({
                url: "{{route('supplier.edit')}}",
                type: 'post',
                dataType: 'json',
                data: $('#edit_form').serialize(),
                success : function(data) {
                    console.log(data);
                    if(data == 'success') {
                        alert('Updated successfully.');
                        window.location.reload();
                    }
                    else if(data.message == 'The given data was invalid.') {
                        alert(data.message);
                    }
                },
                error: function(data) {
                    console.log(data.responseJSON);
                    if(data.responseJSON.message == 'The given data was invalid.') {
                        let messages = data.responseJSON.errors;
                        if(messages.name) {
                            $('#edit_name_error strong').text(data.responseJSON.errors.name[0]);
                            $('#edit_name_error').show();
                            $('#edit_form .name').focus();
                        }
                        
                        if(messages.company) {
                            $('#edit_company_error strong').text(data.responseJSON.errors.company[0]);
                            $('#edit_company_error').show();
                            $('#edit_form .company').focus();
                        }

                        if(messages.email) {
                            $('#edit_email_error strong').text(data.responseJSON.errors.email[0]);
                            $('#edit_email_error').show();
                            $('#edit_form .email').focus();
                        }

                        if(messages.phone_number) {
                            $('#edit_phone_number_error strong').text(data.responseJSON.errors.phone_number[0]);
                            $('#edit_phone_number_error').show();
                            $('#edit_form .phone_number').focus();
                        }

                        if(messages.address) {
                            $('#edit_address_error strong').text(data.responseJSON.errors.address[0]);
                            $('#edit_address_error').show();
                            $('#edit_form .address').focus();
                        }

                        if(messages.city) {
                            $('#edit_city_error strong').text(data.responseJSON.errors.city[0]);
                            $('#edit_city_error').show();
                            $('#edit_form .city').focus();
                        }
                    }
                }
            });
        });

    });
</script>
@endsection
