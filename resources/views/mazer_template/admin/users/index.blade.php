@extends('mazer_template.layouts.app')
@section('title', 'Users List')
@section('content')


<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-people-fill"></i> Users <small class="text-muted">List</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users List</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('admin.users.create') }}" title='Create User' type="button" class="btn" style='border-radius:12px; background-color:#56B000; color:white;'><i class="bi bi-plus-circle"
                        style="font-size: 13px; font-weight:bold"></i></a>
                <div class="table-responsive mt-4 mb-4" style="width: 100%;">
                    <table class="table table-hover" id="users" style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </section>

</div>

{{-- script delete card --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).on('click', '#delete-user', function (e) {
        e.preventDefault();
        var tbUserId = $(this).data('tb-user-id');
        var username = $(this).data('username');

        Swal.fire({
            title: 'Are you sure?',
            text: 'Apakah anda yakin akan menghapus user: ' + username + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#56B000',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var xhr = new XMLHttpRequest();
                xhr.open('DELETE', "{{ route('admin.users.destroy', '') }}" + '/' + tbUserId, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', $("input[name=_token]").val());
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#56B000',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Ganti location.reload() dengan window.location.href
                                    window.location.href = "{{ route('admin.users.index') }}";
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'User failed to delete.',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    } else {
                        console.error(xhr.statusText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'User failed to delete.',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                };
                xhr.onerror = function () {
                    console.error(xhr.statusText);
                    Swal.fire({
                        title: 'Error!',
                        text: 'User failed to delete.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                };
                xhr.send();
            }
        });
    });

</script>

@endsection
