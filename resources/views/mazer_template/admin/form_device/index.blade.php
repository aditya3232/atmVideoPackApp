@extends('mazer_template.layouts.app')
@section('title', 'Devices List')
@section('content')


<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>@include('mazer_template.layouts.icons.device') Devices <small class="text-muted">List</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Devices List</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('admin.device.create') }}" title='Create User' type="button" class="btn" style='border-radius:12px; background-color:#56B000; color:white;'><i class="bi bi-plus-circle"
                        style="font-size: 13px; font-weight:bold"></i></a>
                <div class="table-responsive mt-4 mb-4" style="width: 100%;">
                    <table class="table table-hover" id="form_device" style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>TID</th>
                                <th>SN Mini PC</th>
                                <th>Regional Office</th>
                                <th>KC Supervisi</th>
                                <th>Branch</th>
                                <th>Created At</th>
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

{{-- delete device with xhr --}}
<script>
    $(document).on('click', '#delete-device', function (e) {
        e.preventDefault();
        var tbTidId = $(this).data('tb-tid-id');
        var tid = $(this).data('tid');

        Swal.fire({
            title: 'Are you sure?',
            text: 'Apakah anda yakin akan menghapus tid: ' + tid + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#56B000',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var xhr = new XMLHttpRequest();
                xhr.open('DELETE', "{{ route('admin.device.destroy', '') }}" + '/' + tbTidId, true);
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
                                    window.location.href = "{{ route('admin.device.index') }}";
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Device failed to delete.',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    } else {
                        console.error(xhr.statusText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Device failed to delete.',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                };
                xhr.onerror = function () {
                    console.error(xhr.statusText);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Device failed to delete.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                };
                xhr.send();
            }
        });
    });

</script>

{{-- delete device with jquery --}}
{{-- <script>
    $(document).on('click', '#delete-device', function (e) {
        e.preventDefault();
        var tbTidId = $(this).data('tb-tid-id');
        var tid = $(this).data('tid');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete device with Tid: ' + tid + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#56B000',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.device.destroy', '') }}" + '/' + tbTidId,
type: 'DELETE',
data: {
_token: $("input[name=_token]").val()
},
success: function (response) {
Swal.fire({
title: 'Success!',
text: 'Device has been deleted.',
icon: 'success',
confirmButtonColor: '#56B000',
}).then((result) => {
if (result.isConfirmed) {
location.reload();
}
});
}
});
}
});
});

</script> --}}

@endsection
