@extends('layouts.admin')

@section('title', ' - Sell Energy')

@section('content')

<br>
<nav style="--bs-breadcrumb-divider: '>'; margin-left: 1%;" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ Auth::user()->trading_position == 3 ? route('bothMarket') : route('sellerMarket') }}" style="text-decoration:none;">
                Trading: Current Market
            </a>
        </li>
      <li class="breadcrumb-item active" aria-current="page">Sell Energy</li>
    </ol>
</nav>

<section id="page-main-section">
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pt-3"><h4>Sell Energy</h4></div>

                <div class="card-body">
                    <form method="POST" action = "{{ route('storeToSellEnergy') }}">
                        @csrf
                        {{-- @method('PUT') --}}

                        <div class="mb-3">
                            <label for="energy_id" class="form-label admin-form-label">Energy Type</label>

                            <select id="energy_id" class="form-select @error('energy_id') is-invalid @enderror" name="energy_id" value="{{ old('energy_id') }}">
                                <option selected disabled>Please select the energy type</option>
                                @foreach ($energies as $energy=>$value)
                                    <option value="{{ $value['id'] }}" {{old ('energy_id') == $value['id'] ? 'selected' : ''}}> {{ $value['type'] }} </option>
                                @endforeach
                            </select>
                            @error('energy_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="volume" class="form-label admin-form-label">Sell Volume <i>(in kWh)</i></label>
                            <input id="volume" type="number" step="any" class="form-control @error('volume') is-invalid @enderror" name="volume" value="{{ old('volume') }}">
                            @error('volume')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="seller_price" class="form-label admin-form-label">Sell Price</label>
                            <input id="seller_price" type="number" step="any" class="form-control @error('seller_price') is-invalid @enderror" name="seller_price" value="{{ old('seller_price') }}">
                            <span style="font-style: italic">
                                Note: Your price should be between +/-10% of Latest Market Price
                                <a href="" data-bs-toggle="modal" data-bs-target="#latestMarketPrice" onclick="loadLatestMarketPrices()">Click to see Latest Market Prices</a>
                            </span>
                            @error('seller_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                        <a 
                            class="btn btn-secondary float-end"
                            onclick="location.href='{{ Auth::user()->trading_position == 3 ? route('bothMarket') : route('sellerMarket') }}'">
                            Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

{{-- Latest Market Prices Modal --}}
@include('admin.modals.marketPricesModal')

@endsection

@section('pageJS')

    <script>
        $(document).ready(function() {
            document.querySelector("#submenu-closed").click()
        });

        function loadLatestMarketPrices() {
            $.ajax({
                type:"GET",
                url: "{{ route('ajaxGetEnergies', 'false') }}",
                data: {},
                success: function(data) {
                    $("#marketPriceTableBody").html(data.html);
                }
            });
        }
    </script>

@endsection