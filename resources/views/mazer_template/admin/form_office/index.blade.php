@extends('mazer_template.layouts.app')
@section('title', 'Office List')
@section('content')


<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-stack"></i> Office <small class="text-muted">List</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Office List</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('admin.office.create') }}" title='Create Mcu' type="button" class="btn" style='border-radius:12px; background-color:#56B000; color:white;'><i class="bi bi-plus-circle"
                        style="font-size: 13px; font-weight:bold"></i></a>
                <div class="table-responsive mt-4 mb-4" style="width: 100%;">
                    <table class="table table-hover" id="form_office" style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kantor</th>
                                <th>Alamat</th>
                                <th>Kode Pos</th>
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
    <div class="modal fade" id="modalDeleteOffice" tabindex="-1" aria-labelledby="modalDeleteOfficeLabel" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center no-copy">
                    <div>
                        <i class="bi bi-exclamation-circle" style="font-size: 100px; color:rgba(255, 165, 0, 0.4);"></i>
                    </div>

                    <div class="mb-4 mt-2">
                        <h2 class="text-primary">Delete Office!</h2>
                        <span class='badge bg-primary mb-2' style='border-radius: 12px;'>
                            <text id="data_office_name" style="font-size: 16px">
                        </span>
                    </div>

                    <div>
                        <p>Apakah anda yakin ingin delete office?</p>
                    </div>

                    <div>
                        <button class="btn" id="btn-delete-office" style="border-radius:12px; background-color:#FF0000; color:white;"> Yes, delete it!</button>
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

        var officeId; // Declare entryId variable in an accessible scope

        $('#modalDeleteOffice').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var officeId = button.data('tb-office-id');
            var officeName = button.data('office-name');

            // Attach the entryId value to the delete button
            $('#btn-delete-office').data('office-id', officeId);

            $('#data_office_name').text(officeName);
        });

        $('#btn-delete-office').on('click', function (event) {
            // Get the entryId value from the button's data attribute
            var officeId = $(this).data('office-id');

            var action = "{{ route('admin.office.destroy', '') }}" + '/' + officeId;
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
                    console.log('Office berhasil dihapus!', response);

                    Swal.fire({
                        icon: 'success',
                        title: 'Office berhasil dihapus!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    $('#modalDeleteOffice').modal('hide');
                },
                error: function (error) {

                    console.error('Office gagal dihapus!', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Office gagal dihapus!',
                        text: 'Silahkan refresh halaman!',
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    $('#modalDeleteOffice').modal('hide');
                }
            });
        });


    });

</script>


@endsection
