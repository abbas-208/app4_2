@extends('layouts.admin')

@section('title', ' - Market')

@section('content')

    <section id="page-main-section">
        <div class="container-sm">
            <div class="row">
                <div class="col-12">
                    <h2>Energy Market List</h2>
                </div>
                <div class="col-12 mt-2 mb-3">
                    <button class="btn btn-success bg-gradient"
                        onclick="location.href='{{ Auth::user()->isActivated ? route('Market\SellEnergy') : route('deactivated') }}'">
                        Sell Energy
                    </button>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" style="margin: 0 1% 1% 1%;">
                        <p style="margin-bottom: 0">{{ $message }}</p>
                    </div>
                @endif
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
                            @if (count($energy_products) > 0)
                                @foreach ($energy_products as $product)
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
    </section>

@endsection

@section('pageJS')

    <script>
        $(document).ready(function() {
            document.querySelector("#submenu-closed").click()
        });
    </script>

@endsection
