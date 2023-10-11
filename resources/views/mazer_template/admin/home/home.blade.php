@extends('mazer_template.layouts.app')
@section('title', 'Dashboard')
@section('content')



<div class="page-heading">
    {{-- title --}}
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-grid-fill"></i> Atm Video Pack <small class="text-muted">Dashboard</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href=""></a>
                            <p id="current-time"></p>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- total all about --}}
    <div class="page-content">
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
                                <h6 class="text-muted font-semibold">Device Up</h6>
                                <h6 class="font-extrabold mb-0"></h6>
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
                                        <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.device-white')->render()) }}" alt="" width="25">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Device Down</h6>
                                <h6 class="font-extrabold mb-0"></h6>
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
                                        <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.cctv-white')->render()) }}" alt="" width="25">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Cctv Online</h6>
                                <h6 class="font-extrabold mb-0"></h6>
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
                                        <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.cctv-white')->render()) }}" alt="" width="25">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Cctv Offline</h6>
                                <h6 class="font-extrabold mb-0"></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</div>



@endsection
