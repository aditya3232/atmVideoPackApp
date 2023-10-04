@extends('mazer_template.layouts.app')
@section('title', 'Pair Card with Mcu and Update')
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
                <h3><i class="bi bi-gear-fill"></i> Pair Card with Mcu <small class="text-muted">Update</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.card.index') }}">Card List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pair Card with Mcu and Update</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.card.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i></a>
            </div>

            {{-- officeId --}}
            <input type="hidden" id="office_id" name="office_id" value="{{ $data->office_id }}" />
            {{-- cardId --}}
            <input type="hidden" id="card_id" name="card_id" value="{{ $data->id }}" />

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">No Card :</h4>
                        <span class='badge mb-2' style='border-radius:12px; background-color:#0000FF; color:white;'>{{ $data->no_card }}</span>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="">
                                            <h4 class="card-title">Access Mcu :</h4>
                                        </label>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="d-inline-block">
                                                    @if($get_data_tb_mcu_id->count() > 0)
                                                        @foreach($get_data_tb_mcu_id as $item)
                                                            <a data-tb-entry-id="{{ $data->id }}" data-tb-mcu-id="{{ $item->id }}" data-access="{{ $item->door_name_mcu }}" title="Delete Access" class="btn btn-sm mt-2 delete-access"
                                                                data-bs-toggle="modal" data-bs-target="#modalDeleteMcuAccess">
                                                                {{ $item->door_name_mcu }} | <i class='bi bi-trash'></i>
                                                            </a>
                                                        @endforeach
                                                    @else
                                                        <a title=" No Access" class="btn btn-sm mt-2" style="border-radius:12px; background-color:#0000FF; color:white;">No Access Mcu</a>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" row">
                                <div class="col-md-12 col-12">
                                    <label for="permissions" style="font-weight: bold;">Pilih Access:</label>
                                    <br>
                                    <form class="form" action="{{ route('admin.card.assignmcu', $data->id) }}" id="post-add-access-mcu" method="POST">
                                        @csrf
                                        <select class="form-control select2-mcu" name="mcu[]" multiple="multiple">
                                        </select>
                                        @if($errors->has('mcu'))
                                            <span class="text-danger">{{ $errors->first('mcu') }}</span>
                                        @endif

                                        <div class="d-grid gap-2 mt-4">
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
    </section>

    {{-- modal hapusnya --}}
    <div class="modal fade" id="modalDeleteMcuAccess" tabindex="-1" aria-labelledby="modalDeleteMcuAccessLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center no-copy">
                    <div>
                        <i class="bi bi-exclamation-circle" style="font-size: 100px; color:rgba(255, 165, 0, 0.4);"></i>
                    </div>

                    <div class="mb-4 mt-2">
                        <h2 class="text-primary">Delete Access Mcu!</h2>
                        <span class='badge bg-primary mb-2' style='border-radius: 12px;'>
                            <text id="data_no_card" style="font-size: 16px">
                        </span>
                    </div>

                    <div>
                        <p>Apakah anda yakin ingin delete access mcu?</p>
                    </div>

                    <div>
                        <button class="btn" id="btn-delete-mcu-access" style="border-radius:12px; background-color:#FF0000; color:white;"> Yes, delete it!</button>
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

        $('#modalDeleteMcuAccess').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var entryId = button.data('tb-entry-id');
            var mcuId = button.data('tb-mcu-id');
            var access = button.data('access');


            // Attach the entryId value to the delete button
            $('#btn-delete-mcu-access').data('entry-id', entryId);
            $('#btn-delete-mcu-access').data('mcu-id', mcuId);

            $('#data_no_card').text(access);
        });


        $('#btn-delete-mcu-access').on('click', function (event) {

            var entryId = $(this).data('entry-id');
            var mcuId = $(this).data('mcu-id');

            // console.log(entryId);
            // console.log(mcuId);

            var action = "{{ url('admin/card/deletemcu/', ['', '']) }}" + '/' + entryId + '/' + mcuId;
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
                    console.log('Access mcu berhasil dihapus!', response);

                    Swal.fire({
                        icon: 'success',
                        title: 'Access mcu berhasil dihapus!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    $('#modalDeleteMcuAccess').modal('hide');
                },
                error: function (error) {

                    console.error('Access mcu gagal dihapus!', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Access mcu gagal dihapus!',
                        text: 'Silahkan refresh halaman!',
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    $('#modalDeleteMcuAccess').modal('hide');
                }
            });
        });

        // after post id = post-add-access-mcu show sukses with swal
        $('#post-add-access-mcu').on('submit', function (event) {
            event.preventDefault();

            var action = $(this).attr('action');
            var method = $(this).attr('method');
            var data = $(this).serialize();

            $.ajax({
                type: method,
                url: action,
                data: data,
                success: function (response) {
                    console.log('Access mcu berhasil ditambahkan!', response);

                    Swal.fire({
                        icon: 'success',
                        title: 'Access mcu berhasil ditambahkan!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                },
                error: function (error) {
                    console.error('Access mcu gagal ditambahkan!', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Access mcu gagal ditambahkan!',
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
