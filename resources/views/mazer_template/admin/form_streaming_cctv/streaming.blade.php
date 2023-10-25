@extends('mazer_template.layouts.app')
@section('title', 'CCTV streaming List')
@section('content')


<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>@include('mazer_template.layouts.icons.stream') CCTV <small class="text-muted">Streaming</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">CCTV streaming</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="row">
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon purple">
                                <a href="" class="">
                                    <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.device-white')->render()) }}" alt="" width="25">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">TID</h6>
                            @foreach($status_mc_detection as $data)
                                <h6 class="font-extrabold mb-0">{{ $data['tid'] }}</h6>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon blue">
                                <a href="" class="">
                                    <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.location-white')->render()) }}" alt="" width="25">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Regional Office</h6>
                            @foreach($status_mc_detection as $data)
                                <h6 class="font-extrabold mb-0">{{ $data['regional_office_name'] }}</h6>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon green">
                                <a href="" class="">
                                    <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.location-white')->render()) }}" alt="" width="25">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">KC Supervisi</h6>
                            @foreach($status_mc_detection as $data)
                                <h6 class="font-extrabold mb-0">{{ $data['kc_supervisi_name'] }}</h6>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon red">
                                <a href="" class="">
                                    <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.location-white')->render()) }}" alt="" width="25">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Branch</h6>
                            @foreach($status_mc_detection as $data)
                                <h6 class="font-extrabold mb-0">{{ $data['branch_name'] }}</h6>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mt-4 mb-4" style="width: 100%;">
                    <table class="table table-hover" id="" style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                {{-- tes --}}
                                <td style="width: 25%;">
                                    <div class="card-body px-3 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="stats-icon bg-info">
                                                    <a href="" class="">
                                                        <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.signal-white')->render()) }}" alt="" width="25">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-muted font-semibold">Status Sinyal</h6>
                                                @foreach($status_mc_detection as $data)
                                                    <h6 class="font-extrabold mb-0">{{ $data['status_signal'] }}</h6>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body px-3 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="stats-icon bg-secondary">
                                                    <a href="" class="">
                                                        <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.storage-white')->render()) }}" alt="" width="25">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-muted font-semibold">Status Penyimpanan</h6>
                                                @foreach($status_mc_detection as $data)
                                                    <h6 class="font-extrabold mb-0">{{ $data['status_storage'] }}</h6>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body px-3 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="stats-icon bg-warning">
                                                    <a href="" class="">
                                                        <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.memory-white')->render()) }}" alt="" width="25">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-muted font-semibold">Status Ram</h6>
                                                @foreach($status_mc_detection as $data)
                                                    <h6 class="font-extrabold mb-0">{{ $data['status_ram'] }}</h6>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body px-3 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="stats-icon bg-success">
                                                    <a href="" class="">
                                                        <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.cpu-white')->render()) }}" alt="" width="25">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-muted font-semibold">Status CPU</h6>
                                                @foreach($status_mc_detection as $data)
                                                    <h6 class="font-extrabold mb-0">{{ $data['status_cpu'] }}</h6>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 75%;">
                                    @foreach($status_mc_detection as $data)
                                        <iframe src="{{ env('STREAMING_CCTV_URL') . $data['tid_id'] }}" width="100%" height="500px" frameborder="0" allowfullscreen></iframe>
                                    @endforeach
                                </td>
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


@endsection
