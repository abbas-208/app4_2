@extends('layouts.main')

@section('title', ' - Home')

@section('content')

		<!-- Start Landing Section 1 -->
		<section class="section-gap info-area" id="landing-first-section">
			<div class="container">
				<div class="single-info row mt-40 align-items-center">
					<div class="col-lg-6 col-md-12 text-center no-padding info-left order-2 order-sm-2 order-lg-1">
						<div class="info-thumb">
							<img src="{{ asset('images/landing.jpg') }}" class="img-fluid info-img" alt="Photo by <a href='https://unsplash.com/@chelseadeeyo?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText'>Chelsea</a> on <a href='https://unsplash.com/photos/WvusC5M-TM8?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText'>Unsplash</a>">
						</div>
					</div>
					<div class="col-lg-6 col-md-12 no-padding info-right order-1 order-sm-1 order-lg-2">
						<div class="info-content">
							<h2 class="pb-30">Tassie Green Energy Trading Company (TaGET)</h2> <br>
							<p>
								TaGET provides a renewable energy (Solar and Wind) trading service in Tasmania.
								Search here to see our available renewable energy.
							</p>
							<div class="container-fluid">
								<div class="row mt-4">
									<div class="col-12 px-md-5">
										<form class="counter_form_content d-flex flex-column align-items-center justify-content-center">
											<div class="counter_form_title">Search Energy</div>

											<select name="counter_select" id="zone-select" class="counter_input counter_options reg_input mb-2">
												<option disabled selected>Choose Your Zone</option>
												@foreach ($zones as $zone =>$value)
													<option value="{{$value['id']}}" {{old ('zone') == $value['id'] ? 'selected' : ''}}>{{$value['name']}}</option>
												@endforeach
											</select>
											<select name="counter_select" id="energy-select" class="counter_input counter_options reg_input mt-1 mb-2">
												<option disabled selected>Choose Energy Type</option>
												@foreach ($energies as $energy =>$value)
													<option value="{{$value['id']}}" {{old ('energy') == $value['id'] ? 'selected' : ''}}>{{$value['type']}}</option>
												@endforeach
											</select>
											<div class="col-12">
												<span id="validationMessage"></span>
											</div>

											<button type="button" class="mt-3 counter_form_button" onclick="searchTrading()">Search</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Landing Section 1 -->

@endsection

@section('pageJS')

    <script>
		function searchTrading() {
			// Check if Zone & Energy is selected
			if ($('#zone-select').val() === null || $('#energy-select').val() === null) {
				$('#validationMessage').html('Both Zone and Energy type must be selected');
				return false;
			}
			else {
				let tradingURL = "{{ route('trading', ['zone_id' => 'Xzone_idX', 'energy_id' => 'Xenergy_idX']) }}";
				location.href = tradingURL.replace('Xzone_idX', $('#zone-select').val()).replace('&amp;', '&').replace('Xenergy_idX', $('#energy-select').val());
			}
		}
    </script>

@endsection