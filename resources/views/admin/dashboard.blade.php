@extends('layouts.admin')

@section('title', ' - Dashboard')

@section('content')

    <section id="page-main-section" style="padding:1% 1% 7% 1%;">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 mb-3">
                    <h2>Market Summary</h2>
                </div>
                <hr>
                <div class="col-6">
                    <h4>Current Trading Prices</h4>
                    <table>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">Energy</th>
                                <th class="column3">Trading Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($market_prices) > 0)
                                @foreach ($market_prices as $prices)
                                    <tr>
                                        <td class="column1">{{ $prices->type }}</td>
                                        <td>$ {{ $prices->market_price }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" style="text-align: center; color:brown">
                                        <h5>Market do not have any Energy listed for sell.</h5>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-6">
                    <h4>Available Energies</h4>
                    <table>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">Energy</th>
                                <th class="column3">Total Available Volume (in kWh)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($energies) > 0)
                                @foreach ($energies as $energy)
                                    <tr>
                                        <td class="column1">{{ $energy->Energy }}</td>
                                        <td>{{ $energy->TotalAvailableVolume }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" style="text-align: center; color:brown">
                                        <h5>Market do not have any Energy listed for sell.</h5>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container-xl">
            <div class="row mt-4">
                <hr>
                <div class="col-6">
                    <h4>Trading Prices</h4>
                    <div id="trading_chart" style="width: 100%; height: 400px"></div>
                </div>
                <div class="col-6">
                    <h4>Traded Energies</h4>
                    <div id="sold_energy_chart" style="width: 100%; height: 400px"></div>
                </div>
            </div>
        </div>
        @if (Auth::user()->isServiceManager)
            <div class="container-xl">
                <div class="row mt-4">
                    <hr>
                    <div class="col-12">
                        <h4>Registered Users</h4>
                        <div id="users_chart" style="width: 100%; height: 400px"></div>
                    </div>
                </div>
            </div>
        @endif
    </section>

@endsection

@section('pageJS')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        let isServiceManager = {{ Auth::user()->isServiceManager }};

        google.charts.load('current', {
            packages: ['corechart', 'bar']
        });
        google.charts.setOnLoadCallback(drawContinuousDateChart);

        function drawContinuousDateChart() {
            var data = google.visualization.arrayToDataTable([
                <?php echo $trade_graph; ?>
            ]);

            //console.log(<?php echo $trade_graph; ?>);

            var options = {
                curveType: 'function',
                chartArea: {
                    'width': '85%',
                    'height': '70%'
                },
                legend: {
                    position: 'bottom'
                },
                pointSize: 5,
                animation: {
                    duration: 500,
                    startup: true
                }
            };

            // Create and draw the visualization.
            var chart = new google.visualization.LineChart(document.getElementById('trading_chart'));
            chart.draw(data, options);

            /**
             * Traded Energies line chart
             **/
            var data2 = google.visualization.arrayToDataTable([
                <?php echo $traded_energy; ?>
            ]);

            var options2 = {
                curveType: 'function',
                chartArea: {
                    'width': '85%',
                    'height': '70%'
                },
                legend: {
                    position: 'bottom'
                },
                pointSize: 5,
                animation: {
                    duration: 500,
                    startup: true
                }
            };

            // Create and draw the visualization.
            var chart2 = new google.visualization.LineChart(document.getElementById('sold_energy_chart'));
            chart2.draw(data2, options2);

            /**
             * Registered Users Bar chart 
             **/
            if (isServiceManager) {
                var data = google.visualization.arrayToDataTable([
                    ['Zones', 'Buyer', 'Seller', 'Both'],
                    <?php echo $userGraph; ?>
                ]);

                var options = {
                    chart: {
                        title: 'In Every Zones',
                        subtitle: '',
                        animation: {
                            duration: 500,
                            startup: true
                        }
                    },
                    bars: 'vertical' // Required for Material Bar Charts.
                };

                var chart3 = new google.charts.Bar(document.getElementById('users_chart'));

                chart3.draw(data, google.charts.Bar.convertOptions(options));
            }
        }
    </script>


@endsection
