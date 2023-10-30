@extends('mazer_template.layouts.app')
@section('title', 'download playbacks List')
@section('content')


<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>@include('mazer_template.layouts.icons.playback') download playbacks <small class="text-muted">List</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">download playbacks List</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if(!empty($download_playback))
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <button title='Advanced Filter' type="button" class="btn" style='border-radius:12px; background-color:#0000FF; color:white;' data-bs-toggle="modal" data-bs-target="#modalFilterDownloadPlayback"><i class="bi bi-funnel"
                            style="font-size: 13px; font-weight:bold"></i></button>

                    <div class="table-responsive mt-4 mb-4" style="width: 100%;">
                        <table class="table table-hover" id="form_download_playback_client_side" style="border-collapse: collapse; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($download_playback as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data['filename'] }}</td>
                                        <td>
                                            <a href="{{ $data['url'] }}" class="btn btn-primary btn-sm" title="Download"><i class="bi bi-download"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </section>
    @endif

    @if(empty($download_playback))
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <button title="Advanced Filter" type="button" class="btn" style="border-radius: 12px; background-color: #0000FF; color: white;" data-bs-toggle="modal" data-bs-target="#modalFilterDownloadPlayback">
                        <i class="bi bi-funnel" style="font-size: 13px; font-weight: bold;"></i>
                    </button>
                    <div class="alert alert-warning mt-3 text-center" role="alert" style="background-color: #ffeeba; border-color: #ffc107; color: #856404; font-size: 20px">
                        <div>
                            <i class="bi bi-exclamation-circle" style="font-size: 100px; color:rgba(255, 165, 0, 0.4);"></i>
                        </div>
                        <strong>Data tidak ditemukan!</strong> Silahkan filter data yang ingin anda download.
                    </div>
                </div>
            </div>
        </section>
    @endif



    <!-- Modal Filter Human Detection -->
    <div class="modal fade" id="modalFilterDownloadPlayback" role="dialog" aria-labelledby="modalFilterDownloadPlaybackLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id=""><i class="bi bi-funnel" style="font-size: 13px; font-weight:bold"></i> Filter</h5>
                </div>
                <div class="modal-body">
                    {{-- body --}}
                    <form id="form-filter-downloadPlayback" method="get" action="{{ route('admin.downloadplayback.index') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="select2-form-downloadPlayback-tid" class="form-label text-dark">TID</label>
                                    <select id="select2-form-downloadPlayback-tid" class="form-control select2-form-downloadPlayback-tid" name="tid" style="width: 300px;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="input-folder-date" class="form-label text-dark">Date</label>
                                    <input type="date" id="input-folder-date" class="form-control" placeholder="YYYY-MM-DD" name="folder_date">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="input-starthour-date" class="form-label text-dark">Start Hour</label>
                                    <input type="time" id="input-starthour-date" class="form-control" name="starthour_date" style="width: 372px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="input-endhour" class="form-label text-dark">End Hour</label>
                                    <input type="time" id="input-endhour" class="form-control" name="endhour" style="width: 372px;">
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
                                <span class="badge bg-primary mb-2">TID: <span id="" class="badge bg-light text-black">{{ $tid ?? 'N/A' }}</span></span>
                                <span class="badge bg-primary mb-2">Date: <span id="last_filter_no_card" class="badge bg-light text-black">{{ $folder_date ?? 'N/A' }}</span></span>
                                <span class="badge bg-primary mb-2">Start Hour: <span id="last_filter_door_token" class="badge bg-light text-black">{{ $starthour_date ?? 'N/A' }}</span></span>
                                <span class="badge bg-primary mb-2">End Hour: <span id="last_filter_location_access" class="badge bg-light text-black">{{ $endhour ?? 'N/A' }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    </form>
                    <button id="btn-reset-filter-downloadPlayback" onClick="changeToLoadingFormResetFilterDownloadPlayback()" class="btn" style="background-color:#FFA500; color:white;">Reset</button>
                    <button type="" id="submit-filter-downloadPlayback" onClick="changeToLoadingFormFilterDownloadPlayback()" class="btn" style="background-color:#0000FF; color:white;">Filter</button>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- script delete card --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function changeToLoadingFormFilterDownloadPlayback() {
        var btn = document.getElementById('submit-filter-downloadPlayback');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Submit';

            // Submit the form
            submitFormFilterDownloadPlayback();
        }, 250);
    }

    function submitFormFilterDownloadPlayback() {
        // Get the form element
        var form = document.getElementById('form-filter-downloadPlayback');

        // Submit the form
        form.submit();
    }

</script>

<script>
    //  btn reset request to null with id='btn-reset-filter-downloadPlayback' and reload page
    $('#btn-reset-filter-downloadPlayback').on('click', function () {
        $('#select2-form-downloadPlayback-tid').val(null).trigger('change');
        $('#input-folder-date').val(null);
        $('#input-starthour-date').val(null);
        $('#input-endhour').val(null).trigger('change');
    });

    // changeToLoadingFormResetFilterHumanDetection
    function changeToLoadingFormResetFilterHumanDetection() {
        var btn = document.getElementById('btn-reset-filter-downloadPlayback');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Reset';

            // Submit the form
            $('#form-filter-downladPlayback').submit();
        }, 250);
    }

</script>



@endsection
