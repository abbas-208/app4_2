@extends('layouts.admin')

@section('title', ' - Market')

@section('content')

    <section id="page-main-section">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-1">
                    <h2>Energy Market List</h2>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success" style="margin: 2% 3% 0 1%;">
                        <p style="margin-bottom: 0">{{ $message }}</p>
                    </div>
                @else
                    <div class="alert alert-warning" style="margin: 2% 3% 0 1%;">
                        <p style="margin-bottom: 0; font-weight: 500;">Only Energies that are available within your zone is
                            listed here.</p>
                    </div>
                @endif
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
                            @if (count($energy_products) > 0)
                                @foreach ($energy_products as $product)
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
    </section>

@endsection

@section('pageJS')

    <script>
        $(document).ready(function() {
            document.querySelector("#submenu-closed").click()
        });
    </script>

@endsection
