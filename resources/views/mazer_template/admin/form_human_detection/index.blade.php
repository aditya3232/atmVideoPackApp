@extends('mazer_template.layouts.app')
@section('title', 'Human Detections List')
@section('content')


<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>@include('mazer_template.layouts.icons.human-detection') Human Detections <small class="text-muted">List</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Human Detections List</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <button title='Advanced Filter' type="button" class="btn" style='border-radius:12px; background-color:#0000FF; color:white;' data-bs-toggle="modal" data-bs-target="#modalFilterHumanDetection"><i class="bi bi-funnel"
                        style="font-size: 13px; font-weight:bold"></i></button>
                <div class="table-responsive mt-4 mb-4" style="width: 100%;">
                    <table class="table table-hover" id="form_human_detection_client_side" style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Capture</th>
                                <th>Tid</th>
                                <th>Regional Office</th>
                                <th>KC Supervisi</th>
                                <th>Branch</th>
                                <th>Is Person</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        {{-- foreach data from $human_detection --}}
                        <tbody>
                            @foreach($human_detection as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ $data['img_url'] }}" alt="{{ $data['file_name_capture_human_detection'] }}" width="100" height="100">
                                    </td>
                                    <td>{{ $data['tid'] }}</td>
                                    <td>{{ $data['regional_office_name'] }}</td>
                                    <td>{{ $data['kc_supervisi_name'] }}</td>
                                    <td>{{ $data['branch_name'] }}</td>
                                    <td>
                                        @if($data['person'] == 0)
                                            <span class='badge bg-success mb-2' style='border-radius: 15px;'>Person</span>
                                        @else
                                            <span class='badge bg-danger mb-2' style='border-radius: 15px;'>Not Person</span>
                                        @endif
                                    </td>
                                    <td>{{ $data['date_time'] }}</td>
                                    <td>
                                        <button title="Detail Image" type="button" class="btn" style="border-radius: 12px; background-color: #0000FF; color: white;" data-bs-toggle="modal"
                                            data-bs-target="#modalDetailImage{{ $loop->index }}">
                                            <i class="bi bi-image" style="font-size: 13px; font-weight: bold"></i>
                                        </button>
                                        {{-- button download image secara langsung --}}
                                        <a href="{{ $data['img_url'] }}" download="{{ $data['file_name_capture_human_detection'] }}" title="Download Image" type="button" class="btn"
                                            style="border-radius: 12px; background-color: #0000FF; color: white;">
                                            <i class="bi bi-download" style="font-size: 13px; font-weight: bold"></i>
                                        </a>

                                        {{-- modal detail image --}}
                                        <div class="modal fade" id="modalDetailImage{{ $loop->index }}" tabindex="-1" aria-labelledby="modalDeleteUserLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center no-copy">
                                                        <div>
                                                            <i class="bi bi-image" style="font-size: 50px; font-weight: bold; color: rgba(0, 0, 255, 0.4);"></i>
                                                        </div>
                                                        <div class="mb-4 mt-2">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md">
                                                                            <img src="{{ $data['img_url'] }}" alt="{{ $data['file_name_capture_human_detection'] }}" width="100%" height="100%">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

    <!-- Modal Filter Human Detection -->
    <div class="modal fade" id="modalFilterHumanDetection" role="dialog" aria-labelledby="modalFilterLogAcceptedlLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id=""><i class="bi bi-funnel" style="font-size: 13px; font-weight:bold"></i> Filter</h5>
                </div>
                <div class="modal-body">
                    {{-- body --}}
                    <form id="form-filter-humanDetection" method="get" action="{{ route('admin.humandetection.index') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="select2-form-humanDetection-tid" class="form-label text-dark">TID</label>
                                    <select id="select2-form-humanDetection-tid" class="form-control select2-form-humanDetection-tid" name="tid_id" style="width: 300px;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="input-start-date-time-in-log-accepted" class="form-label text-dark">Start Date Time</label>
                                    <input type="datetime-local" id="input-start-date-time-in-log-accepted" class="form-control" placeholder="..." name="start_date_time">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="select2-form-humanDetection-person" class="form-label text-dark">Is Person</label>
                                    <select id="select2-form-humanDetection-person" class="form-control select2-form-humanDetection-person" name="person" style="width: 300px;">
                                        <option selected disabled value style="width: 200px" value="0"></option>
                                        <option style="width: 200px" value="0">Is Person</option>
                                        <option style="width: 200px" value="1">Not Person</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="input-end-date-time-in-log-accepted" class="form-label text-dark">End Date Time</label>
                                    <input type="datetime-local" id="input-end-date-time-in-log-accepted" class="form-control" placeholder="..." name="end_date_time">
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
                                <span class="badge bg-primary mb-2">Start Date Time: <span id="last_filter_no_card" class="badge bg-light text-black">{{ $start_date_time ?? 'N/A' }}</span></span>
                                <span class="badge bg-primary mb-2">End Date Time: <span id="last_filter_door_token" class="badge bg-light text-black">{{ $end_date_time ?? 'N/A' }}</span></span>
                                <span class="badge bg-primary mb-2">Is Person: <span id="last_filter_location_access" class="badge bg-light text-black">{{ $person ?? 'N/A' }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    </form>
                    <button id="btn-reset-filter-humanDetection" onClick="changeToLoadingFormResetFilterHumanDetection()" class="btn" style="background-color:#FFA500; color:white;">Reset</button>
                    <button type="" id="submit-filter-humanDetection" onClick="changeToLoadingFormFilterHumanDetection()" class="btn" style="background-color:#0000FF; color:white;">Filter</button>
                </div>
            </div>
        </div>
    </div>

    {{-- script delete card --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function changeToLoadingFormFilterHumanDetection() {
            var btn = document.getElementById('submit-filter-humanDetection');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            btn.disabled = true;

            // Simulating a delay of 2 seconds for demonstration purposes
            setTimeout(function () {
                // Enable the button and change the text back to "Login" after the delay
                btn.disabled = false;
                btn.innerHTML = 'Submit';

                // Submit the form
                submitFormFilterHumanDetection();
            }, 250);
        }

        function submitFormFilterHumanDetection() {
            // Get the form element
            var form = document.getElementById('form-filter-humanDetection');

            // Submit the form
            form.submit();
        }

    </script>

    <script>
        //  btn reset request to null with id='btn-reset-filter-humanDetection' and reload page
        $('#btn-reset-filter-humanDetection').on('click', function () {
            $('#select2-form-humanDetection-tid').val(null).trigger('change');
            $('#input-start-date-time-in-log-accepted').val(null);
            $('#input-end-date-time-in-log-accepted').val(null);
            $('#select2-form-humanDetection-person').val(null).trigger('change');
        });

        // changeToLoadingFormResetFilterHumanDetection
        function changeToLoadingFormResetFilterHumanDetection() {
            var btn = document.getElementById('btn-reset-filter-humanDetection');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            btn.disabled = true;

            // Simulating a delay of 2 seconds for demonstration purposes
            setTimeout(function () {
                // Enable the button and change the text back to "Login" after the delay
                btn.disabled = false;
                btn.innerHTML = 'Reset';

                // Submit the form
                $('#form-filter-humanDetection').submit();
            }, 250);
        }

    </script>

    @endsection
