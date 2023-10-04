@extends('mazer_template.layouts.app')
@section('title', 'Update Roles')
@section('content')

<style>
    .clickable-span {
        cursor: pointer;
    }

    .delete-access {
        border-radius: 12px;
        background-color: #0000FF;
        color: white;
    }

</style>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Update Roles</h3>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                {{-- <a href="{{ route('admin.roles.index') }}" type="button" class="btn btn-primary"><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i> Kembali</a> --}}
                <a href="{{ route('admin.roles.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ url('admin/roles/update/'.$role->id) }}" id="" method="POST">
                @csrf
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Nama Role</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="name">Nama Role</label>
                                            <input type="text" id="name" class="form-control" placeholder="Nama role" name="name" value="{{ old('name') ? old('name') : $role->name }}">
                                            @if($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 mt-4">
                                    {{-- <button class="btn btn-primary" type="submit">Submit</button> --}}
                                    <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;'>Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{-- Role: <span class='badge bg-primary mb-2'>{{ $role->name }}</span> --}}
                            Role : <span class='badge mb-2' style='border-radius:12px; background-color:#0000FF; color:white;'>{{ $role->name }}</span>
                        </h4>

                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="permissions" style="font-weight: bold;">Permissions:</label>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12 col-12">

                                                {{-- <div class="d-inline-block">
@if($role->permissions->count() > 0)
@foreach($role->permissions as $item)
                                                            <form action="{{ url('admin/roles/deletepermissions/' . $role->id . '/' . $item->id) }}" method="POST"
                                                class="delete-permission-form">
                                                @method('DELETE')
                                                @csrf
                                                <!-- Rest of the form -->
                                                <span class="badge bg-light-success mb-2 clickable-span delete-permission">{{ $item->name }}</span>
                                                </form>
                                                @endforeach
                                            @else
                                                <span class="badge bg-light-success">No permissions</span>
                                                @endif
                                            </div> --}}

                                            <div class="d-inline-block">
                                                @if($role->permissions->count() > 0)
                                                    @foreach($role->permissions as $item)
                                                        <a data-role-id="{{ $role->id }}" data-permission-id="{{ $item->id }}" data-permission-name="{{ $item->name }}" title="Delete Permission" class="btn btn-sm mt-2 delete-access"
                                                            data-bs-toggle="modal" data-bs-target="#modalDeletePermissionFromRole">
                                                            {{ $item->name }} | <i class='bi bi-trash'></i>
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <a title=" No Access" class="btn btn-sm mt-2" style="border-radius:12px; background-color:#0000FF; color:white;">No Permissions</a>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="permissions" style="font-weight: bold;">Pilih Permissions:</label>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <form class="form" action="{{ route('admin.roles.assignpermissions', $role->id) }}" id="post-add-permission-to-role" method="POST">
                                                @csrf
                                                <select class="form-control select2-permissions" name="permissions[]" multiple="multiple">
                                                </select>
                                                @if($errors->has('permissions'))
                                                    <span class="text-danger">{{ $errors->first('permissions') }}</span>
                                                @endif

                                                <div class="d-grid gap-2 mt-4">
                                                    {{-- <button class="btn btn-primary" type="submit">Submit</button> --}}
                                                    <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;'>Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</div>
</section>
{{-- modal hapusnya --}}
<div class="modal fade" id="modalDeletePermissionFromRole" tabindex="-1" aria-labelledby="modalDeletePermissionFromRoleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body text-center no-copy">
                <div>
                    <i class="bi bi-exclamation-circle" style="font-size: 100px; color:rgba(255, 165, 0, 0.4);"></i>
                </div>

                <div class="mb-4 mt-2">
                    <h2 class="text-primary">Delete Permissions!</h2>
                    <span class='badge bg-primary mb-2' style='border-radius: 12px;'>
                        <text id="data_permission" style="font-size: 16px">
                    </span>
                </div>

                <div>
                    <p>Apakah anda yakin ingin delete permission?</p>
                </div>

                <div>
                    <button class="btn" id="btn-delete-permission-from-role" style="border-radius:12px; background-color:#FF0000; color:white;"> Yes, delete it!</button>
                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal" style="border-radius:12px;"><i class="bi bi-x-circle"></i> Cancel</button>
                </div>

            </div>

        </div>
    </div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {

        $('#modalDeletePermissionFromRole').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var roleId = button.data('role-id');
            var permissionId = button.data('permission-id');
            var permissionName = button.data('permission-name');


            // Attach the roleId & permissionId value to the delete button 
            $('#btn-delete-permission-from-role').data('role-id', roleId);
            $('#btn-delete-permission-from-role').data('permission-id', permissionId);

            $('#data_permission').text(permissionName);
        });


        $('#btn-delete-permission-from-role').on('click', function (event) {

            var roleId = $(this).data('role-id');
            var permissionId = $(this).data('permission-id');

            // console.log(roleId);
            // console.log(permissionId);

            var action = "{{ url('admin/roles/deletepermissions/', ['', '']) }}" + '/' + roleId + '/' + permissionId;
            // console.log(action);
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                type: 'POST',
                url: action,
                data: {
                    "_token": token,
                    "_method": "DELETE" // Use method spoofing for DELETE
                },
                success: function (response) {
                    console.log('Permission berhasil dihapus!', response);

                    Swal.fire({
                        icon: 'success',
                        title: 'Permission berhasil dihapus!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    $('#modalDeletePermissionFromRole').modal('hide');
                },
                error: function (error) {

                    console.error('Permission gagal dihapus!', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Permission gagal dihapus!',
                        text: 'Silahkan refresh halaman!',
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    $('#modalDeletePermissionFromRole').modal('hide');
                }
            });
        });

        // after post id = post-add-permission-to-role show sukses with swal
        $('#post-add-permission-to-role').on('submit', function (event) {
            event.preventDefault();

            var action = $(this).attr('action');
            var method = $(this).attr('method');
            var data = $(this).serialize();

            $.ajax({
                type: method,
                url: action,
                data: data,
                success: function (response) {
                    console.log('Permission berhasil ditambahkan!', response);

                    Swal.fire({
                        icon: 'success',
                        title: 'Permission berhasil ditambahkan!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                },
                error: function (error) {
                    console.error('Permission gagal ditambahkan!', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Permission gagal ditambahkan!',
                        text: 'Silahkan refresh halaman!',
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            });
        });

    });

</script>

@endsection
