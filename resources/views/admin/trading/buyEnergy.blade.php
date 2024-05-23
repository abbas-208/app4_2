@extends('layouts.admin')

@section('title', ' - Buy Energy')

@section('content')

<br>
<nav style="--bs-breadcrumb-divider: '>'; margin-left: 1%;" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ Auth::user()->trading_position == 3 ? route('bothMarket') : route('buyerMarket') }}" style="text-decoration:none;">
                Trading: Current Market
            </a>
        </li>
      <li class="breadcrumb-item active" aria-current="page">Buy Energy</li>
    </ol>
</nav>

<section id="page-main-section">
<div class="container-fluid" style="margin: 0 3%">

    @if ($message = Session::get('error'))
        <div class="alert alert-danger" style="margin: 1% 3% 0 0;">
            <p style="margin-bottom: 0">{{ $message }}</p>
        </div>
    @endif

    <div class="row mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pt-3"><h4>Buy Energy</h4></div>

                <div class="card-body">
                    <form method="POST" action = "{{ route('storeToBuyEnergy') }}" id="buyForm">
                        @csrf
                        {{-- @method('PUT') --}}

                        <div class="mb-3">
                            <label for="type" class="form-label admin-form-label">Energy Type</label>
                            {{-- <input id="type" type="text" class="form-control" name="type" value="{{ $energyProduct->energy->type }}" disabled> --}}
                            <p>{{ $energyProduct->energy->type }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="form-label admin-form-label">Available Volume <i>(in kWh)</i></label>
                            <p>{{ $energyProduct->remaining_volume }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="form-label admin-form-label">Buy Price</label>
                            <p>$ {{ $energyProduct->seller_price }}/kWh</p>
                        </div>

                        <div class="mb-4">
                            <label for="buy_volume" class="form-label admin-form-label">Buy Volume <i>(in kWh)</i></label>
                            <input id="buy_volume" type="number" step="any" class="form-control @error('buy_volume') is-invalid @enderror" name="buy_volume" value="{{ old('buy_volume') }}">
                            @error('buy_volume')
                                <span class="invalid-feedback" id="buy_volume_error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="invalid-feedback" id="buy_volume_error" role="alert" style="display: none;">
                                <strong>Buy Volume is required</strong>
                            </span>
                        </div>

                        <div class="mb-4" id="total_price_div" style="visibility: hidden;">
                            <label class="form-label admin-form-label">Total Price</label>
                            <p><span id="total_price" style="color:brown; font-weight: 500;"></span></p>
                        </div>

                        {{-- Necessary data to process trade --}}
                        <input type="hidden" id="remaining_volume" name="remaining_volume" value="{{ $energyProduct->remaining_volume }}">
                        <input type="hidden" id="energy_product_id" name="energy_product_id" value="{{ $energyProduct->id }}">
                        <input type="hidden" id="trade_price" name="trade_price">
                        <input type="hidden" id="average_price" name="average_price">
                        <input type="hidden" id="admin_fee" name="admin_fee">
                        <input type="hidden" id="tax_rate" name="tax_rate">
                        <input type="hidden" id="seller_id" name="seller_id" value="{{ $energyProduct->seller->id }}">
                        <input type="hidden" id="energy_id" name="energy_id" value="{{ $energyProduct->energy_id }}">

                        <button type="button" class="btn btn-info" id="btn_check" onclick="check()">
                            Check
                        </button>
                        <button type="button" class="btn btn-primary" id="form_submit" style="display: none;" onclick="submitBuyForm()">
                            Confirm
                        </button>
                        <a 
                            class="btn btn-secondary float-end"
                            onclick="location.href='{{ Auth::user()->trading_position == 3 ? route('bothMarket') : route('buyerMarket') }}'">
                            Back
                        </a>
                    </form>
                </div>
                <div class="card-footer" id="card_footer" style="display: none;">
                    <h5>Summery of the Prices</h5>
                    <ul>
                        <li>Average Price: $ <span id="avg_price"></span></li>
                        <li>Price(Average Price x Buy Volume): $ <span id="price"></span></li>
                        <li>Administration fee: $ <span id="administration_fee"></span></li>
                        <li>Tax fee: $ <span id="tax"></span></li>
                        <li>Total Price(Price + Administration fee + Tax fee): <span id="total_fee" style="color:brown"></span></li>
                    </ul>
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

        function check() {
            if($("#buy_volume").val() === '') {
                document.getElementById('buy_volume_error').style.display = 'block';
            } else {
                document.getElementById('btn_check').style.display = 'none';
                document.getElementById('buy_volume_error').style.display = 'none';
                document.getElementById('buy_volume').disabled = true;
                document.getElementById('form_submit').style.display = 'block';
                document.getElementById('card_footer').style.display = 'block';

                $.ajax({
                    type:"GET",
                    url: "{{ route('ajaxGetPriceDetails', $energyProduct->energy_id) }}",
                    data: {},
                    success: function(data) {
                        $("#avg_price").html(roundUptoTwoDecimalPlaces(data.avg_price));
                        $("#average_price").val(data.avg_price);

                        let price = data.avg_price * $("#buy_volume").val();
                        $("#price").html(roundUptoTwoDecimalPlaces(price));
                        $("#volume").val($("#buy_volume").val());

                        $("#administration_fee").html(roundUptoTwoDecimalPlaces(data.admin_fee));
                        $("#admin_fee").val(data.admin_fee);

                        let tax = price * (data.tax_rate/100);
                        $("#tax").html(roundUptoTwoDecimalPlaces(tax));
                        $("#tax_rate").val(data.tax_rate);

                        let total_price = roundUptoTwoDecimalPlaces(price + data.admin_fee + tax);
                        $("#total_fee").html("$ " + total_price);
                        $("#trade_price").val(price + data.admin_fee + tax);

                        document.getElementById('total_price_div').style.visibility = 'visible';
                        $("#total_price").html("$ " + total_price);
                    }
                });
            }
        }

        function submitBuyForm() {
            document.getElementById('buy_volume').disabled = false;
            document.getElementById('buyForm').submit();
        }

        function roundUptoTwoDecimalPlaces(val) {
            return Math.round((val + Number.EPSILON) * 100) / 100
        }
    </script>

@endsection