<x-app-layout>
    <section class="section">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">Encounter Statistik -
                            <form action="" method="GET" class="d-inline">
                                <div class="dropdown d-inline">
                                    <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month">
                                        {{ \Carbon\Carbon::createFromFormat('m', request('month', date('m')))->format('F') }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-sm">
                                        <li class="dropdown-title">Select Month</li>
                                        @for($m=1; $m<=12; $m++) <li>
                                            <button type="submit" name="month" value="{{ $m }}" class="dropdown-item {{ request('month', date('m')) == $m ? 'active' : '' }}">
                                                {{ \Carbon\Carbon::createFromFormat('m', $m)->format('F') }}
                                            </button>
                                            </li>
                                            @endfor
                                    </ul>
                                </div>
                            </form>
                        </div>
                        <div class="card-stats-items">
                            @foreach($statusEncounter as $status => $item)
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$item ??''}}</div>
                                <div class="card-stats-item-label">{{ $status ??'' }}</div>
                            </div>
                            @endforeach
                            <div class="card-stats-item">
                                @php
                                $textClass = $persencentageEncounter > 50 ? 'text-primary' : 'text-danger';
                                $icon = $persencentageEncounter > 50 ? 'up' : 'down';
                                @endphp
                                <div class="card-stats-item-count {{ $textClass}}">
                                    <i class="fas fa-caret-{{ $icon ?? ''}}"></i>{{ $persencentageEncounter}} %
                                </div>
                                <div class="card-stats-item-label">finished</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Encounter</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlahEncounterPerMonth ?? ''}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="balance-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-hospital-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Encounter</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalEncounterPerWeek ?? ''}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="sales-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-diagnoses"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Condition</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalConditionPerWeek ?? ''}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="section-header">
                <h1>Dashboard</h1> --}}
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-hospital-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Encounter</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalEncounter ?? ''}}
                            <p class="text-sm text-muted" style="font-size: 11px;">last update : {{$lastUpdatedEncounter->format('d-m-Y')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-diagnoses"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Condition</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalCondition ?? ''}}
                            <br>
                            <p class="text-sm text-muted" style="font-size: 11px;">last update : {{$lastUpdatedCondition->format('d-m-Y')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Observation</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalObservation ?? ''}}
                            <p class="text-sm text-muted" style="font-size: 11px;">last update : {{$lastUpdatedObservation->format('d-m-Y')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Online Users</h4>
                        </div>
                        <div class="card-body">
                            47
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Statistik Kunjungan</h4>
                        <div class="card-header-action">
                            <div class="btn-group">
                                <a href="#" class="btn btn-primary">Pekan</a>
                                {{-- <a href="#" class="btn">Month</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="182"></canvas>
                        <div class="statistic-details mt-sm-4">
                            @foreach($statusEncounter as $status => $item)
                            <div class="statistic-details-item">
                                @if($status == 'finished')
                                @php
                                $textClass = $persencentageEncounter > 50 ? 'text-primary' : 'text-danger';
                                $icon = $persencentageEncounter > 50 ? 'up' : 'down';
                                @endphp
                                <span class="text-muted"><span class="{{$textClass ?? ''}}"><i class="fas fa-caret-{{$icon}}"></i></span> {{$persencentageEncounter}} %</span>
                                @endif
                                <div class="detail-value">{{ $item}}</div>
                                <div class="detail-name">{{ $status }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Aktivitas Terbaru</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach($scheduleLogs as $schedule)
                            <li class="media">
                                {{-- <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-1.png" alt="avatar"> --}}
                                <div class="media-body">
                                    <div class="float-right text-primary">{{ $schedule->last_run_at->locale('id')->diffForHumans() }}</div>
                                    <div class="media-title">{{$schedule->command_name ?? ''}}</div>
                                    <span class="text-small text-muted">{{$schedule->description ?? ''}}.</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <div class="text-center pt-1 pb-1">
                            <a href="#" class="btn btn-primary btn-lg btn-round">
                                Lihat Semua
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <h2 class="section-title"> --}}
        {{-- <div class="col-12 col-md-4">
            <form action="{{ route('satu-sehat.dashboard') }}" method="POST">
        @csrf
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar"></i>
                    </div>
                </div>
                <input type="text" name="daterange" class="form-control daterange-cus" value="{{ old('daterange', $daterange) }}">
            </div>
        </div>
        </form>
        </div> --}}
        {{-- </h2> --}}

        {{--
        @if (isset($logs))
        <div class="row">
            @foreach($logs as $resource => $total)
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{{ $resource }}</h4>
        </div>
        <div class="card-body">
            <p>Total <code class="large-number">{{$total}}</code></p>
        </div>
        </div>
        </div>
        @endforeach
        </div>
        @endif --}}
        </div>
    </section>

    @push('css-libraries')
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/selectric/public/selectric.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/select2/dist/css/select2.min.css') }}" />
    <style>
        .large-number {
            font-size: 1.5em;
            /* Adjust the size as needed */
            font-weight: bold;
            /* Optional: make the number bold */
        }

    </style>
    @endpush

    @push('js-libraries')
    <script src="{{ asset('stisla/node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('stisla/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/selectric/public/jquery.selectric.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('stisla/assets/js/page/modules-datatables.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    @include('sweetalert::alert')
    @endpush

    @push('js-spesific')

    {{-- <script src="{{ asset('stisla/assets/js/page/index-0.js')}}"></script> --}}
    <script>
        var statistics_chart = document.getElementById("myChart").getContext('2d');

        var myChart = new Chart(statistics_chart, {
            type: 'line'
            , data: {
                labels: @json($chartDataEncounter['days'])
                , datasets: [{
                    label: 'Jumlah'
                    , data: @json($chartDataEncounter['totals'])
                    , borderWidth: 5
                    , borderColor: '#6777ef'
                    , backgroundColor: 'transparent'
                    , pointBackgroundColor: '#fff'
                    , pointBorderColor: '#6777ef'
                    , pointRadius: 4
                }]
            }
            , options: {
                legend: {
                    display: false
                }
                , scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                            , drawBorder: false
                        , }
                        , ticks: {
                            stepSize: 150
                        }
                    }]
                    , xAxes: [{
                        gridLines: {
                            color: '#fbfbfb'
                            , lineWidth: 2
                        }
                    }]
                }
            , }
        });

    </script>
    <script>
        $(document).ready(function() {
            $('.daterange-cus').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                }
                , drops: 'down'
                , opens: 'right'
            });

            $('.daterange-cus').on('apply.daterangepicker', function(ev, picker) {
                this.form.submit();
            });
        });

    </script>

    <script>
        var balance_chart = document.getElementById("balance-chart").getContext('2d');

        var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
        balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
        balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

        var myChart = new Chart(balance_chart, {
            type: 'line'
            , data: {
                labels: @json($chartDataEncounter['days'])
                , datasets: [{
                    label: 'Encounter'
                    , data: @json($chartDataEncounter['totals'])
                    , backgroundColor: balance_chart_bg_color
                    , borderWidth: 3
                    , borderColor: 'rgba(63,82,227,1)'
                    , pointBorderWidth: 0
                    , pointBorderColor: 'transparent'
                    , pointRadius: 3
                    , pointBackgroundColor: 'transparent'
                    , pointHoverBackgroundColor: 'rgba(63,82,227,1)'
                , }]
            }
            , options: {
                layout: {
                    padding: {
                        bottom: -1
                        , left: -1
                    }
                }
                , legend: {
                    display: false
                }
                , scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                            , drawBorder: false
                        , }
                        , ticks: {
                            beginAtZero: true
                            , display: false
                        }
                    }]
                    , xAxes: [{
                        gridLines: {
                            drawBorder: false
                            , display: false
                        , }
                        , ticks: {
                            display: false
                        }
                    }]
                }
            , }
        });

    </script>

    <script>
        var sales_chart = document.getElementById("sales-chart").getContext('2d');

        var sales_chart_bg_color = sales_chart.createLinearGradient(0, 0, 0, 80);
        balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
        balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

        var myChart = new Chart(sales_chart, {
            type: 'line'
            , data: {
                labels: @json($chartDataCondition['days'])
                , datasets: [{
                    label: 'condition'
                    , data: @json($chartDataCondition['totals'])
                    , borderWidth: 2
                    , backgroundColor: balance_chart_bg_color
                    , borderWidth: 3
                    , borderColor: 'rgba(63,82,227,1)'
                    , pointBorderWidth: 0
                    , pointBorderColor: 'transparent'
                    , pointRadius: 3
                    , pointBackgroundColor: 'transparent'
                    , pointHoverBackgroundColor: 'rgba(63,82,227,1)'
                , }]
            }
            , options: {
                layout: {
                    padding: {
                        bottom: -1
                        , left: -1
                    }
                }
                , legend: {
                    display: false
                }
                , scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                            , drawBorder: false
                        , }
                        , ticks: {
                            beginAtZero: true
                            , display: false
                        }
                    }]
                    , xAxes: [{
                        gridLines: {
                            drawBorder: false
                            , display: false
                        , }
                        , ticks: {
                            display: false
                        }
                    }]
                }
            , }
        });

        $("#products-carousel").owlCarousel({
            items: 3
            , margin: 10
            , autoplay: true
            , autoplayTimeout: 5000
            , loop: true
            , responsive: {
                0: {
                    items: 2
                }
                , 768: {
                    items: 2
                }
                , 1200: {
                    items: 3
                }
            }
        });

    </script>


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var daterangeInput = document.querySelector('.daterange-cus');

            daterangeInput.addEventListener('change', function() {
                this.form.submit();
            });
        });

    </> --}}

    @endpush
</x-app-layout>
