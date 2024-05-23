@extends('layouts.admin')

@section('title', ' - Market')

@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success" style="margin: 2% 3% 1% 1%;">
            <p style="margin-bottom: 0">{{ $message }}</p>
        </div>
    @else
        <div class="alert alert-warning" style="margin: 2% 3% 1% 1%;">
            <p style="margin-bottom: 0; font-weight: 500;">Only Energies that are available within your zone is listed here.
            </p>
        </div>
    @endif

    <section id="page-main-section">
        <div class="container">
            <div class="row mt-1">
                <ul class="nav nav-tabs" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="ex1-tab-1" data-bs-toggle="tab" href="#ex1-tabs-1" role="tab"
                            aria-controls="ex1-tabs-1" aria-selected="true">
                            <h5>Buy Energy</h5>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex1-tab-2" data-bs-toggle="tab" href="#ex1-tabs-2" role="tab"
                            aria-controls="ex1-tabs-2" aria-selected="false">
                            <h5>Sell Energy</h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="ex1-content">
                    <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                        <div class="container mt-3">
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <table>
                                        <thead>
                                            <tr class="table100-head">
                                                <th class="column1">Type</th>
                                                <th class="column3">Available Volume(kWh)</th>
                                                <th class="column3">Seller Price</th>
                                                <th class="column4">Zone</th>
                                                <th class="column4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($buy_energy_products) > 0)
                                                @foreach ($buy_energy_products as $product)
                                                    <tr>
                                                        <td class="column1">{{ $product->energy->type }}</td>
                                                        <td>{{ $product->remaining_volume }}</td>
                                                        <td>$ {{ $product->seller_price }}</td>
                                                        <td>{{ $product->seller->zone->name }}</td>
                                                        <td>
                                                            <button class="btn btn-outline-success"
                                                                onclick="location.href='{{ Auth::user()->isActivated ? route('Market\BuyEnergy', $product->id) : route('deactivated') }}'">
                                                                Buy Energy</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" style="text-align: center; color:brown">
                                                        <h5>No energy is available for buying</h5>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                        <div class="container mt-3">
                            <div class="row">
                                <div class="col-12 mt-2 mb-3">
                                    <button class="btn btn-success bg-gradient"
                                        onclick="location.href='{{ Auth::user()->isActivated ? route('Market\SellEnergy') : route('deactivated') }}'">
                                        Sell Energy
                                    </button>
                                </div>
                                <div class="col-12">
                                    <table>
                                        <thead>
                                            <tr class="table100-head">
                                                <th class="column1">Energy</th>
                                                <th class="column3">Volume(kWh)</th>
                                                <th class="column3">Price</th>
                                                <th class="column3">Zone</th>
                                                <th class="column3">Available Volume</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($sell_energy_products) > 0)
                                                @foreach ($sell_energy_products as $product)
                                                    <tr>
                                                        <td class="column1">{{ $product->energy->type }}</td>
                                                        <td>{{ $product->volume }}</td>
                                                        <td>$ {{ $product->seller_price }}</td>
                                                        <td>{{ Auth::user()->zone->name }}</td>
                                                        <td>{{ $product->remaining_volume }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" style="text-align: center; color:brown">
                                                        <h5>You haven't listed any energy for sell!</h5>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

@endsection

@section('pageJS')

    <script>
        $(document).ready(function() {
            document.querySelector("#submenu-closed").click()
        });
    </script>

@endsection
