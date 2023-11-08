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
            <form class="form" action="{{ url('admin/roles/update/'.$role->id) }}" id="form-update-role-name" method="POST" onsubmit="return false;">
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
                                    <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-update-role-name"
                                        onClick="changeToLoadingFormUpdateRoleName()">Update</button>
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
                                                <div class="d-inline-block">
                                                    @if($role->permissions->count() > 0)
                                                        @foreach($role->permissions as $item)
                                                            <a data-role-id="{{ $role->id }}" data-permission-id="{{ $item->id }}" data-permission-name="{{ $item->name }}" title="Delete Permission"
                                                                class="btn btn-sm mt-2 delete-access" id="delete-permission-role">
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
                                                        <button class="align-items-center col-12 btn btn-lg" type="submit" id="submit-update-permission-role" onClick="changeToLoadingFormUpdatePermissionsRole()"
                                                            style='border-radius:12px; background-color:#56B000; color:white;'>Update</button>
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

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function changeToLoadingFormUpdateRoleName() {
        var btn = document.getElementById('submit-update-role-name');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Submit';

            // Submit the form
            submitFormUpdateRoleName();
        }, 2000);
    }

    function submitFormUpdateRoleName() {
        // Get the form element
        var form = document.getElementById('form-update-role-name');

        // Create a new FormData object
        var formData = new FormData(form);

        // Send the form data using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.errors) {
                    // Handle validation errors
                    var errorMessages = Object.values(response.errors).join('<br>');
                    Swal.fire({
                        title: 'Validation Error',
                        html: errorMessages, // Gunakan html untuk mengaktifkan baris baru (\n)
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                } else {
                    // Handle a successful response
                    console.log(response.message);
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = window.location.href;
                        }
                    });
                }
            } else {
                // Handle errors
                console.error(xhr.statusText);
                Swal.fire({
                    title: 'Error!',
                    text: 'Role name failed to update.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        };
        xhr.onerror = function () {
            console.error(xhr.statusText);
        };
        xhr.send(formData);
    }

</script>

{{-- mencegah enter form --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var form = document.getElementById("form-update-role-name");

        form.addEventListener("keydown", function (event) {
            if (event.key === "Enter" && !event.shiftKey) {
                event.preventDefault();
                // Mencegah pengguna menekan Enter tanpa klik tombol submit
            }
        });
    });

</script>

{{-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ --}}

<script>
    $(document).on('click', '#delete-permission-role', function (e) {
        e.preventDefault();

        var roleId = $(this).data('role-id');
        var permissionId = $(this).data('permission-id');
        var permissionName = $(this).data('permission-name');

        Swal.fire({
            title: 'Are you sure?',
            text: 'Apakah anda yakin akan menghapus permission: ' + permissionName + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#56B000',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', "{{ url('admin/roles/deletepermissions/', ['', '']) }}" + '/' + roleId + '/' + permissionId, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', $("input[name=_token]").val());
                xhr.setRequestHeader('X-HTTP-Method-Override', 'DELETE'); // Menggunakan spoofing DELETE
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            // Handle a successful response
                            console.log(response.message);
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload(); // Reload the page after successful deletion
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Permission failed to delete.',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    } else {
                        console.error(xhr.statusText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Permission failed to delete.',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }

                };
                xhr.onerror = function () {
                    console.error(xhr.statusText);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Permission failed to delete.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                };
                xhr.send();
            }
        });
    });

</script>

<script>
    // fungsi post with loading
    function changeToLoadingFormUpdatePermissionsRole() {
        var btn = document.getElementById('submit-update-permission-role');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Submit';

            // Submit the form
            submitFormUpdatePermissionsRole();
        }, 2000);
    }

    function submitFormUpdatePermissionsRole() {
        // Get the form element
        var form = document.getElementById('post-add-permission-to-role');

        // Create a new FormData object
        var formData = new FormData(form);

        // Send the form data using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.errors) {
                    // Handle validation errors
                    var errorMessages = Object.values(response.errors).join('<br>');
                    Swal.fire({
                        title: 'Validation Error',
                        html: errorMessages, // Gunakan html untuk mengaktifkan baris baru (\n)
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                } else {
                    // Handle a successful response
                    console.log(response.message);
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = window.location.href;
                        }
                    });
                }
            } else {
                // Handle errors
                console.error(xhr.statusText);
                Swal.fire({
                    title: 'Error!',
                    text: 'Role failed to update.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        };
        xhr.onerror = function () {
            console.error(xhr.statusText);
        };
        xhr.send(formData);
    }

</script>

@endsection
