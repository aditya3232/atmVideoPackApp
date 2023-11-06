@extends('mazer_template.layouts.app')
@section('title', 'Device Up List')
@section('content')

{{-- break word --}}
<style>
    .break-word {
        word-wrap: break-word;
    }

</style>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>@include('mazer_template.layouts.icons.device') Device Up <small class="text-muted">List</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Device Up List</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mt-4 mb-4" style="width: 100%;">
                    <table class="table table-hover" id="form_device_up_client_side" style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>TID</th>
                                <th>Date Modified</th>
                                <th>Status Signal</th>
                                <th>Status Storage</th>
                                <th>Status Ram</th>
                                <th>Status Cpu</th>
                                <th>Status Mini Pc</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($device_up as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data['tid'] }}</td>
                                    <td>{{ $data['date_time'] }} </td>
                                    <td class="break-word">{{ $data['status_signal'] }}</td>
                                    <td class="break-word">{{ $data['status_storage'] }}</td>
                                    <td class="break-word">{{ $data['status_ram'] }}</td>
                                    <td class="break-word">{{ $data['status_cpu'] }}</td>
                                    <td>
                                        @if($data['status_mc'] == 'online')
                                            <span class='badge bg-success mb-2' style='border-radius: 15px;'>Online</span>
                                        @else
                                            <span class='badge bg-danger mb-2' style='border-radius: 15px;'>Offline</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </section>

</div>

@endsection
