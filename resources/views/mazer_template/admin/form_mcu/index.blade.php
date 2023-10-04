@extends('mazer_template.layouts.app')
@section('title', 'Door Access')
@section('content')


<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-gear-fill"></i> Door Access <small class="text-muted">List</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Door Access List</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('admin.mcu.create') }}" title='Create Mcu' type="button" class="btn" style='border-radius:12px; background-color:#56B000; color:white;'><i class="bi bi-plus-circle"
                        style="font-size: 13px; font-weight:bold"></i></a>
                <div class="table-responsive mt-4 mb-4" style="width: 100%;">
                    <table class="table table-hover" id="form_mcu" style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Door Token</th>
                                <th>Door Name</th>
                                <th>Type Door Access</th>
                                <th>Keypad Password</th>
                                <th>Delay</th>
                                <th>Lokasi Kantor</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </section>

    {{-- modal here --}}
    <div class="modal fade" id="modalDeleteMcu" tabindex="-1" aria-labelledby="modalDeleteMcuLabel" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center no-copy">
                    <div>
                        <i class="bi bi-exclamation-circle" style="font-size: 100px; color:rgba(255, 165, 0, 0.4);"></i>
                    </div>

                    <div class="mb-4 mt-2">
                        <h2 class="text-primary">Delete Door Access!</h2>
                        <span class='badge bg-primary mb-2' style='border-radius: 12px;'>
                            <text id="data_door_token" style="font-size: 16px">
                        </span>
                        <span class='badge bg-primary mb-2' style='border-radius: 12px;'>
                            <text id="data_door_name" style="font-size: 16px">
                        </span>
                    </div>

                    <div>
                        <p>Apakah anda yakin ingin delete door access?</p>
                    </div>

                    <div>
                        <button class="btn" id="btn-delete-mcu" style="border-radius:12px; background-color:#FF0000; color:white;"> Yes, delete it!</button>
                        <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal" style="border-radius:12px;"><i class="bi bi-x-circle"></i> Cancel</button>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

{{-- script delete card --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {

        var mcuId; // Declare entryId variable in an accessible scope

        $('#modalDeleteMcu').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var mcuId = button.data('tb-mcu-id');
            var doorToken = button.data('door-token');
            var doorName = button.data('door-name');

            // Attach the entryId value to the delete button
            $('#btn-delete-mcu').data('mcu-id', mcuId);

            $('#data_door_token').text(doorToken);
            $('#data_door_name').text(doorName);
        });

        $('#btn-delete-mcu').on('click', function (event) {
            // Get the entryId value from the button's data attribute
            var mcuId = $(this).data('mcu-id');

            var action = "{{ route('admin.mcu.destroy', '') }}" + '/' + mcuId;
            console.log(action);
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                type: 'POST',
                url: action,
                data: {
                    "_token": token,
                    "_method": "DELETE" // Use method spoofing for DELETE
                },
                success: function (response) {
                    console.log('Door access berhasil dihapus!', response);

                    Swal.fire({
                        icon: 'success',
                        title: 'Door access berhasil dihapus!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    $('#modalDeleteMcu').modal('hide');
                },
                error: function (error) {

                    console.error('Door access gagal dihapus!', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Door access gagal dihapus!',
                        text: 'Silahkan refresh halaman!',
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    $('#modalDeleteMcu').modal('hide');
                }
            });
        });


    });

</script>

@endsection
