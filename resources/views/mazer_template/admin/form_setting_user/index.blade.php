@extends('mazer_template.layouts.app')
@section('title', 'Setting User Door Access')
@section('content')

<style>
    .no-copy {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

</style>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-gear-fill"></i> Setting User Door Access <small class="text-muted">List</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Setting User Door Access List</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <button title='Advanced Filter' type="button" class="btn" style='border-radius:12px; background-color:#0000FF; color:white;' data-bs-toggle="modal" data-bs-target="#modalFilterSettingMcu"><i class="bi bi-funnel"
                        style="font-size: 13px; font-weight:bold"></i></button>
                <div class="table-responsive mt-4 mb-4" style="width: 100%;">
                    {{-- <table class="table table-striped table-bordered" id="form_setting_user" style="border-collapse: collapse; width: 100%; table-layout: fixed; margin-bottom:20px;"> --}}
                    <table class="table table-hover" id="form_setting_user" style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Card</th>
                                <th>Username</th>
                                <th>Status Pekerja</th>
                                <th>Status User</th>
                                <th>Lokasi Kantor User</th>
                                <th>Lokasi Kantor yang Dikunjungi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </section>

    {{-- modal block user --}}
    <div class="modal fade" id="modalBlockUser" tabindex="-1" aria-labelledby="modalBlockUserLabel" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center no-copy">
                    <div>
                        <i class="bi bi-exclamation-circle" style="font-size: 100px; color:rgba(255, 165, 0, 0.4);"></i>
                    </div>

                    <div class="mb-4 mt-2">
                        <h2 class="text-primary">Block User!</h2>
                        <span class='badge bg-primary mb-2' style='border-radius: 12px;'>
                            <text id="user_name_modal" style="font-size: 16px">
                        </span>
                    </div>

                    <div>
                        <p>Apakah anda yakin ingin block user?</p>
                    </div>

                    <form action="{{ url('admin/settinguser/blockuser') }}" method="post" id="formModalBlockUser">
                        @csrf
                        @method('post')
                        <div>
                            <button type="submit" class="btn" style="border-radius:12px; background-color:#FFA500; color:white;"> Yes, block it!</button>
                            <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal" style="border-radius:12px;"><i class="bi bi-x-circle"></i> Cancel</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    {{-- modal unblock user --}}
    <div class="modal fade" id="modalUnblockUser" tabindex="-1" aria-labelledby="modalUnblockUserLabel" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center no-copy">
                    <div>
                        <i class="bi bi-exclamation-circle" style="font-size: 100px; color:rgba(255, 165, 0, 0.4);"></i>
                    </div>

                    <div class="mb-4 mt-2">
                        <h2 class="text-primary">Unblock User!</h2>
                        <span class='badge bg-primary mb-2' style='border-radius: 12px;'>
                            <text id="user_name_modal_unblock" style="font-size: 16px">
                        </span>
                    </div>

                    <div>
                        <p>Apakah anda yakin ingin unblock user?</p>
                    </div>

                    <form action="{{ url('admin/settinguser/unblockuser') }}" method="post" id="formModalUnblockUser">
                        @csrf
                        @method('post')
                        <div>
                            <button type="submit" class="btn" style="border-radius:12px; background-color:#56B000; color:white;"> Yes, unblock it!</button>
                            <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal" style="border-radius:12px;"><i class="bi bi-x-circle"></i> Cancel</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    {{-- modal filter setting user mcu --}}
    <div class="modal fade" id="modalFilterSettingMcu" role="dialog" aria-labelledby="modalFilterSettingMculLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="tidAllocationModalLabel"><i class="bi bi-funnel" style="font-size: 13px; font-weight:bold"></i> Advanced Filter</h5>
                </div>
                <div class="modal-body">
                    {{-- body --}}
                    <form id="form-filter-setting-user-mcu" method="" action="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="select2-entry-in-setting-user" class="form-label text-dark">No Card</label>
                                    <select id="select2-entry-in-setting-user" class="form-control select2-entry-in-setting-user" name="filter_no_card" style="width: 300px;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="select2-username-card-in-setting-user" class="form-label text-dark">Username</label>
                                    <select id="select2-username-card-in-setting-user" class="form-control select2-username-card-in-setting-user" name="filter_username" style="width: 300px;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="select2-status-pekerja-in-setting-user" class="form-label text-dark">Status Pekerja</label>
                                    <select id="select2-status-pekerja-in-setting-user" class="form-control select2-status-pekerja-in-setting-user" name="filter_status_pekerja" style="width: 300px;">
                                        <option selected disabled value style="width: 200px" value="0"></option>
                                        <option style="width: 200px" value="Karyawan Kantor">Karyawan Kantor</option>
                                        <option style="width: 200px" value="Keamanan">Keamanan</option>
                                        <option style="width: 200px" value="VIP">VIP</option>
                                        <option style="width: 200px" value="Visitor">Visitor</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="select2-status-user-in-setting-user" class="form-label text-dark">Status User</label>
                                    <select id="select2-status-user-in-setting-user" class="form-control select2-status-user-in-setting-user" name="filter_status_user" style="width: 300px;">
                                        <option selected disabled value style="width: 200px" value="0"></option>
                                        <option style="width: 200px" value="0">Active</option>
                                        <option style="width: 200px" value="1">Not Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="select2-office-in-setting-user" class="form-label text-dark">Lokasi Kantor User</label>
                                    <select id="select2-office-in-setting-user" class="form-control select2-office-in-setting-user" name="filter_lokasi_kantor_user" style="width: 300px;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="select2-office-dikunjungi-in-setting-user" class="form-label text-dark">Lokasi Kantor Yang Dikunjungi</label>
                                    <select id="select2-office-dikunjungi-in-setting-user" class="form-control select2-office-in-setting-user" name="filter_lokasi_kantor_yang_dikunjungi" style="width: 300px;">
                                    </select>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-body">
                    <div class="row ml">
                        <div class="col-md">
                            <div class="form-group mb-0">
                                <label for="" class="form-label text-dark">Last Filter</label>
                                <br>
                                <span class="badge bg-primary mb-2">No Card: <span id="last_fitler_no_card" class="badge bg-light text-black"></span></span>
                                <span class="badge bg-primary mb-2">Username: <span id="last_filter_username" class="badge bg-light text-black"></span></span>
                                <span class="badge bg-primary mb-2">Status Pekerja: <span id="last_filter_status_pekerja" class="badge bg-light text-black"></span></span>
                                <span class="badge bg-primary mb-2">Status User: <span id="last_filter_status_user" class="badge bg-light text-black"></span></span>
                                <span class="badge bg-primary mb-2">Lokasi Kantor User: <span id="last_filter_lokasi_kantor_user" class="badge bg-light text-black"></span></span>
                                <span class="badge bg-primary mb-2">Lokasi Kantor Yang Dikunjungi: <span id="last_filter_lokasi_kantor_yang_dikunjungi" class="badge bg-light text-black"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    </form>
                    <button id="btn-reset-filter-setting-user-mcu" class="btn" style="background-color:#FFA500; color:white;">Reset</button>
                    <button type="" id="btn-filter-setting-user-mcu" class="btn" style="background-color:#0000FF; color:white;">Filter</button>
                </div>
            </div>
        </div>
    </div>


</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- block user --}}
<script>
    $(document).ready(function () {
        // Step 2: Add event listener to form submission
        $('#formModalBlockUser').on('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            var form = $(this);
            var action = form.attr('action');
            var formData = form.serialize(); // Get the form data as a query string

            // Step 3: Send the form data using AJAX
            $.ajax({
                type: 'POST',
                url: action,
                data: formData,
                success: function (response) {
                    // Handle the response here (e.g., show a success message)
                    console.log('User berhasil di block!', response);
                    // show sweet alert after reload page
                    Swal.fire({
                        icon: 'success',
                        title: 'User berhasil di block!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // reload page after 2 second
                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    // For example, to close the modal:
                    $('#modalBlockUser').modal('hide');
                },
                error: function (error) {
                    // Handle the error here (e.g., show an error message)
                    console.error('Block user gagal!', error);
                    // show sweet alert fail
                    Swal.fire({
                        icon: 'error',
                        title: 'Block user gagal!',
                        text: 'Silahkan refresh halaman!',
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    $('#modalBlockUser').modal('hide');
                }
            });
        });

        $('#modalBlockUser').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('user-id');
            var userName = button.data('user-name');
            var form = $('#formModalBlockUser');
            var action = form.attr('action');

            var tes = form.attr('action', action + '/' + userId)
            // Set the value of the input field for data-user-name
            $('#user_name_modal').text(userName);
        });
    });

</script>

{{-- unblock user --}}
<script>
    $(document).ready(function () {
        $('#formModalUnblockUser').on('submit', function (event) {
            event.preventDefault();

            var form = $(this);
            var action = form.attr('action');
            var formData = form.serialize();


            $.ajax({
                type: 'POST',
                url: action,
                data: formData,
                success: function (response) {
                    console.log('User berhasil di unblock!', response);

                    Swal.fire({
                        icon: 'success',
                        title: 'User berhasil di unblock!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    $('#modalUnblockUser').modal('hide');
                },
                error: function (error) {

                    console.error('Unblock user gagal!', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Unblock user gagal!',
                        text: 'Silahkan refresh halaman!',
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    $('#modalUnblockUser').modal('hide');
                }
            });
        });

        $('#modalUnblockUser').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('user-id');
            var userName = button.data('user-name');
            var form = $('#formModalUnblockUser');
            var action = form.attr('action');

            var tes = form.attr('action', action + '/' + userId)

            $('#user_name_modal_unblock').text(userName);
        });
    });

</script>



@endsection
