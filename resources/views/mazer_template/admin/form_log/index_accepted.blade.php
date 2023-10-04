@extends('mazer_template.layouts.app')
@section('title', 'Daftar Log Cards')
@section('content')


<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-file-earmark-ruled-fill"></i> Log Cards <small class="text-muted">List</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Log Cards List</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <button title='Advanced Filter' type="button" class="btn" style='border-radius:12px; background-color:#0000FF; color:white;' data-bs-toggle="modal" data-bs-target="#modalFilterLogAccepted"><i class="bi bi-funnel"
                        style="font-size: 13px; font-weight:bold"></i></button>
                <div class="table-responsive mt-4 mb-4" style="width: 100%;">
                    <table class="table table-hover" id="form_log_accepted" style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username Card</th>
                                <th>No Card</th>
                                <th>Door Token</th>
                                <th>Location Access</th>
                                <th>Log Status</th>
                                <th>Date Time</th>
                            </tr>
                        </thead>
                    </table>
                    <br>
                    <h4>tes minio</h4>
                    <img src="http://localhost:9000/gatewatch-app/cctv-capture/645af65568387-TesCard2-2023-09-22-21-46-32-616.jpg" alt="">
                </div>
            </div>
        </div>

    </section>

    <!-- Modal Filter Log Accepted -->
    <div class="modal fade" id="modalFilterLogAccepted" role="dialog" aria-labelledby="modalFilterLogAcceptedlLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id=""><i class="bi bi-funnel" style="font-size: 13px; font-weight:bold"></i> Advanced Filter</h5>
                </div>
                <div class="modal-body">
                    {{-- body --}}
                    <form id="form-filter-log-accepted" method="" action="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="select2-username-mcu-in-log-accepted" class="form-label text-dark">Username Card</label>
                                    <select id="select2-username-mcu-in-log-accepted" class="form-control select2-username-mcu-in-log-accepted" name="filter_username_card" style="width: 300px;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="select2-entry-in-log-accepted" class="form-label text-dark">No Card</label>
                                    <select id="select2-entry-in-log-accepted" class="form-control select2-entry-in-log-accepted" name="filter_no_card" style="width: 300px;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="select2-door-token-in-log-accepted" class="form-label text-dark">Door Token</label>
                                    <select id="select2-door-token-in-log-accepted" class="form-control select2-door-token-in-log-accepted" name="filter_door_token" style="width: 300px;">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="select2-office-in-log-accepted" class="form-label text-dark">Location Access</label>
                                    <select id="select2-office-in-log-accepted" class="form-control select2-office-in-log-accepted" name="filter_location_access" style="width: 300px;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="input-start-date-time-in-log-accepted" class="form-label text-dark">Start Date Time</label>
                                    <input type="datetime-local" id="input-start-date-time-in-log-accepted" class="form-control" placeholder="..." name="filter_start_date_time">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="input-end-date-time-in-log-accepted" class="form-label text-dark">End Date Time</label>
                                    <input type="datetime-local" id="input-end-date-time-in-log-accepted" class="form-control" placeholder="..." name="filter_end_date_time">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="select2-log-status-in-log-accepted" class="form-label text-dark">Log Status</label>
                                    <select id="select2-log-status-in-log-accepted" class="form-control select2-log-status-in-log-accepted" name="filter_log_status" style="width: 300px;">
                                        <option selected disabled value style="width: 200px" value="0"></option>
                                        <option style="width: 200px" value="0">Accepted</option>
                                        <option style="width: 200px" value="1">Rejected</option>
                                        <option style="width: 200px" value="2">New card</option>
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
                                <span class="badge bg-primary mb-2">Username Card: <span id="last_fitler_username_card" class="badge bg-light text-black"></span></span>
                                <span class="badge bg-primary mb-2">No Card: <span id="last_filter_no_card" class="badge bg-light text-black"></span></span>
                                <span class="badge bg-primary mb-2">Door Token: <span id="last_filter_door_token" class="badge bg-light text-black"></span></span>
                                <span class="badge bg-primary mb-2">Location Access: <span id="last_filter_location_access" class="badge bg-light text-black"></span></span>
                                <span class="badge bg-primary mb-2">Start Date Time: <span id="last_filter_start_date_time" class="badge bg-light text-black"></span></span>
                                <span class="badge bg-primary mb-2">End Date Time: <span id="last_filter_end_date_time" class="badge bg-light text-black"></span></span>
                                <span class="badge bg-primary mb-2">Log Status: <span id="last_filter_log_status" class="badge bg-light text-black"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    </form>
                    <button id="btn-reset-filter-log-accepted" class="btn" style="background-color:#FFA500; color:white;">Reset</button>
                    <button type="" id="btn-filter-log-accepted" class="btn" style="background-color:#0000FF; color:white;">Filter</button>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection
