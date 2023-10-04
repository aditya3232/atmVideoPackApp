@extends('mazer_template.layouts.app')
@section('title', 'Dashboard')
@section('content')



<div class="page-heading">
    {{-- title --}}
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-grid-fill"></i> Gatewatch Apps <small class="text-muted">Dashboard</small></h3>
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
                                    <a href="" class="mt-2"><i class="bi bi-file-earmark-ruled-fill"></i></a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Log Accept</h6>
                                <h6 class="font-extrabold mb-0">{{ $count_log_accept }}</h6>
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
                                    <a href="" class="mt-2"><i class="bi bi-file-earmark-ruled-fill"></i></a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Log reject</h6>
                                <h6 class="font-extrabold mb-0">{{ $count_log_reject }}</h6>
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
                                    <a href="" class="mt-2"><i class="bi bi-people-fill"></i></a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">User Door Access Active</h6>
                                <h6 class="font-extrabold mb-0">{{ $count_user_active }}</h6>
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
                                    <a href="" class="mt-2"><i class="bi bi-people-fill"></i></a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">User Door Access Not Active</h6>
                                <h6 class="font-extrabold mb-0">{{ $count_user_no_active }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- tabel total 2 --}}
    <div class="page-content">
        <section class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon" style="background-color:chocolate">
                                    <a href="" class="mt-2"><i class="bi bi-building"></i></a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Office</h6>
                                <h6 class="font-extrabold mb-0">{{ $count_office }}</h6>
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
                                <div class="stats-icon" style="background-color:blueviolet">
                                    <a href="" class="mt-2"><i class="bi bi-credit-card-2-back-fill"></i></a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Card</h6>
                                <h6 class="font-extrabold mb-0">{{ $count_card }}</h6>
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
                                <div class="stats-icon" style="background-color: coral">
                                    <a href="" class="mt-2"><i class="bi bi-door-open-fill"></i></a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Door Access</h6>
                                <h6 class="font-extrabold mb-0">{{ $count_mcu }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- tabel total card mcu in office --}}
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h4>Detail Total Card & Door Access in Office</h4>
                <div class="table-responsive mt-4 mb-4" style="width: 100%;">
                    <table class="table table-hover" id="total_card_mcu" style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Office Name</th>
                                <th>Total Card</th>
                                <th>Total Door Access</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-body">
            </div>
        </div> --}}

    </section>
</div>



@endsection
