@extends('layouts.master')

@section('content')
    <div class="br-mainpanel">
        <div class="br-pageheader pd-y-15 pd-l-20">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
                <a class="breadcrumb-item active" href="#">Users</a>
            </nav>
        </div><!-- br-pageheader -->
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">User Management</h4>
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
                                <th class="wd-40">#</th>
                                <th>Userame</th>
                                <th>Company</th>
                                <th>Role</th>
                                <th>Phone Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td class="username">{{$item->name}}</td>
                                    <td class="company" data-id="{{$item->company_id}}">@isset($item->company->name){{$item->company->name}}@endisset</td>
                                    <td class="role" data-id="{{$item->role_id}}">{{$item->role->name}}</td>
                                    <td class="phone">{{$item->phone_number}}</td>
                                    <td class="py-1">
                                        <a href="#" class="btn btn-primary btn-icon rounded-circle mg-r-5 btn-edit" data-id="{{$item->id}}"><div><i class="fa fa-edit"></i></div></a>
                                        <a href="{{route('user.delete', $item->id)}}" class="btn btn-danger btn-icon rounded-circle mg-r-5" data-id="{{$item->id}}" onclick="return window.confirm('Are you sure?')"><div><i class="fa fa-trash-o"></i></div></a>
                                        {{-- <a href="#" class="btn bg-blue btn-icon rounded-round btn-edit"  data-popup="tooltip" title="Edit" data-placement="top"><i class="icon-pencil7"></i></a> --}}
                                        {{-- <a href="{{route('user.delete', $item->id)}}" class="btn bg-danger text-pink-800 btn-icon rounded-round ml-2" data-popup="tooltip" title="Delete" data-placement="top" onclick="return window.confirm('Are you sure?')"><i class="icon-trash"></i></a> --}}
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
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New User</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="create_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Username</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Username">
                            <span id="name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input class="form-control" type="text" name="phone_number" id="phone" placeholder="Phone Number">
                            <span id="phone_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                            <span id="role_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>                        
                        <div class="form-group">
                            <label class="control-label">Company</label>
                            <select name="company_id" id="company_id" class="form-control">
                                <option value="">Select Company</option>
                                @foreach ($companies as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                    
                                @endforeach
                            </select>
                            <span id="company_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group password-field">
                            <label class="control-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            <span id="password_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>    
                        <div class="form-group password-field">
                            <label class="control-label">Password Confirm</label>
                            <input type="password" name="password_confirmation" id="confirmpassword" class="form-control" placeholder="Password Confirm">
                            <span id="confirmpassword_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" id="btn_create" class="btn btn-primary btn-submit"><i class="icon-paperplane"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close2"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="edit_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" class="id" />                    
                        <div class="form-group">
                            <label class="control-label">Username</label>
                            <input class="form-control name" type="text" name="name" placeholder="Username">
                            <span id="edit_name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input class="form-control phone_number" type="text" name="phone_number" placeholder="Phone Number">
                            <span id="edit_phone_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>                        
                        <div class="form-group">
                            <label class="control-label">Company</label>
                            <select name="company_id" class="form-control company">
                                <option value="">Select Company</option>
                                @foreach ($companies as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                    
                                @endforeach
                            </select>
                            <span id="edit_company_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group password-field">
                            <label class="control-label">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="New Password">
                            <span id="edit_password_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>    
                        <div class="form-group password-field">
                            <label class="control-label">Password Confirm</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirm">
                            <span id="edit_confirmpassword_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" id="btn_update" class="btn btn-primary btn-submit"><i class="fa fa-check-circle-o"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                url: "{{route('user.create')}}",
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
                            $('#create_form #name').focus();
                        }
                        
                        if(messages.role) {
                            $('#role_error strong').text(data.responseJSON.errors.role[0]);
                            $('#role_error').show();
                            $('#create_form #role').focus();
                        }

                        if(messages.password) {
                            $('#password_error strong').text(data.responseJSON.errors.password[0]);
                            $('#password_error').show();
                            $('#create_form #password').focus();
                        }

                        if(messages.phone_number) {
                            $('#phone_error strong').text(data.responseJSON.errors.phone_number[0]);
                            $('#phone_error').show();
                            $('#create_form #phone').focus();
                        }
                    }
                }
            });
        });

        $(".btn-edit").click(function(){
            let user_id = $(this).attr("data-id");
            let username = $(this).parents('tr').find(".username").text().trim();
            let company = $(this).parents('tr').find(".company").data('id');
            let phone = $(this).parents('tr').find(".phone").text().trim();

            $("#edit_form input.form-control").val('');
            $("#edit_form .id").val(user_id);
            $("#edit_form .name").val(username);
            $("#edit_form .company").val(company);
            $("#edit_form .phone_number").val(phone);

            $("#editModal").modal();
        });

        $("#btn_update").click(function(){
            $.ajax({
                url: "{{route('user.edit')}}",
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
                            $('#edit_form #edit_name').focus();
                        }

                        if(messages.password) {
                            $('#edit_password_error strong').text(data.responseJSON.errors.password[0]);
                            $('#edit_password_error').show();
                            $('#edit_form #edit_password').focus();
                        }

                        if(messages.phone) {
                            $('#edit_phone_error strong').text(data.responseJSON.errors.phone[0]);
                            $('#edit_phone_error').show();
                            $('#edit_form #edit_phone').focus();
                        }
                    }
                }
            });
        });

    });
</script>
@endsection
