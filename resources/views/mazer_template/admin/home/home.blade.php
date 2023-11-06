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

    <div class="page-content">

        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body px-2 py-4-5">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="stats-icon" style="background-color: rgba(75, 192, 192, 0.6)">
                                            <a href="{{ route('admin.getdatatabledeviceup') }}" target="_blank" class="">
                                                <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.device-white')->render()) }}" alt="" width="25">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <h6 class="text-muted font-semibold">Total Device Up</h6>
                                        <h6 class="font-extrabold mb-0">{{ $onlineCount }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body px-2 py-4-5">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="stats-icon" style="background-color: rgba(255, 99, 132, 0.6)">
                                            <a href="{{ route('admin.getdatatabledevicedown') }}" target="_blank" class="">
                                                <img src="data:image/svg+xml;base64,{{ base64_encode(view('mazer_template.layouts.icons.device-white')->render()) }}" alt="" width="25">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <h6 class="text-muted font-semibold">Total Device Down</h6>
                                        <h6 class="font-extrabold mb-0">{{ $offlineCount }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Total Device Up / Down</h4>
                    </div>
                    <div class="card-body">
                        <div class="col-12 col-lg-12">
                            <div class="row">
                                <div class="text-center">
                                    <div id="chart-profile-visit">
                                        <canvas id="deviceChart" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>

</div>

<script>
    const ctx = document.getElementById('deviceChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Device Up', 'Device Down'],
            datasets: [{
                label: 'Total Device Up / Down',
                data: [0, 0], // Initialize with default values
                backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                borderWidth: 1,
                borderColor: '#777',
                hoverBorderWidth: 3,
                hoverBorderColor: '#000'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Profile Visit',
                fontSize: 25
            },
            legend: {
                display: true,
                position: 'right',
                labels: {
                    fontColor: '#000'
                }
            },
            layout: {
                padding: {
                    left: 50,
                    right: 0,
                    bottom: 0,
                    top: 0
                }
            },
            tooltips: {
                enabled: true,
            }
        }
    });

    // Fetch data from the server
    fetch('/admin/getdeviceupanddown')
        .then(response => response.json())
        .then(data => {
            const onlineCount = data.onlineCount;
            const offlineCount = data.offlineCount;
            const total = onlineCount + offlineCount;
            const onlinePercentage = ((onlineCount / total) * 100).toFixed(2);
            const offlinePercentage = ((offlineCount / total) * 100).toFixed(2);

            // Update chart data and labels with the fetched data
            myChart.data.datasets[0].data = [onlineCount, offlineCount];
            myChart.data.labels = [`${onlinePercentage}% Device Up`, `${offlinePercentage}% Device Down`];
            myChart.update();
        })
        .catch(error => console.error(error));

</script>

@endsection
