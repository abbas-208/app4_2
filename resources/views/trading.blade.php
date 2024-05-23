@extends('layouts.main')

@section('title', ' - Trading')

@section('content')

<section style="margin: 2% 0 15% 0">
    <div class="container">				
        <div class="row">
            <div class="col-12">
                <h2>Trading : Energy Market List</h2>
            </div>
            <div class="col-12">
                <button class="btn btn-success" id="btn-trade-energy" onclick="location.href='{{ route('login') }}'">Buy or Sell Energy</button>
            </div>
            <div class="col-12">
                <table>
                    <thead>
                        <tr class="table100-head">
                            <th class="column1">Type</th>
                            <th class="column2">Volume(kWh)</th>
                            <th class="column3">Price(per kWh)</th>
                            <th class="column4">Zone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($energy_products) > 0)
                            @foreach ($energy_products as $product)
                                <tr>
                                    <td class="column1">{{ $product->energy->type }}</td>
                                    <td>{{ $product->volume }}</td>
                                    <td>$ {{ $product->seller_price }}</td>
                                    <td>{{ $product->seller->zone->name }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" style="text-align: center; color:brown">
                                    <h5>No energy is found according to your search criteria.</h5>
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
