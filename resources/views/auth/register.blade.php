@extends('layouts.main')

@section('title', ' - Register')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-5 mt-2">

        <div class="col-sm-12 col-lg-8">
            <div class="reg_form">
                <div class="row fill_height">
                    <div class="col fill_height">
                        <form class="reg_form_content d-flex flex-column align-items-center justify-content-center" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="reg_form_title">Registration</div>
                            <div class="col-12">
                                <b><span id="validationMessage"></span></b>
                            </div>

                            <input type="hidden" id="manager" name="manager" value="0">

                            <input  id="name" type="text" placeholder="Name" class="form-control reg_input reg_name @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <input id="email" type="email" placeholder="Email" class="form-control reg_input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <input id="password" type="password" placeholder="Password" class="form-control reg_input @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <input id="password-confirm" type="password" name="password_confirmation" class="reg_input" placeholder="Confirm Password">

                            <select id="tradingPosition" class="counter_input counter_options reg_input @error('tradingPosition') is-invalid @enderror" name="tradingPosition" value="{{ old('tradingPosition') }}">
                                <option disabled selected>Choose Trading Position</option>
                                <option value="1" {{old('tradingPosition') == 1 ? 'selected' : ''}}>Buyer</option>
                                <option value="2" {{old('tradingPosition') == 2 ? 'selected' : ''}}>Seller</option>
                                <option value="3" {{old('tradingPosition') == 3 ? 'selected' : ''}}>Both Buyer and Seller</option>
                            </select>
                            @error('tradingPosition')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <select id="zone" class="counter_input counter_options reg_input @error('zone') is-invalid @enderror" name="zone" value="{{ old('zone') }}">
                                <option disabled selected>Choose Your Zone</option>
                                @foreach ($zones as $zone =>$value)
                                    <option value="{{$value['id']}}" {{old('zone') == $value['id'] ? 'selected' : ''}}>{{$value['name']}}</option>
                                @endforeach
                            </select>
                            @error('zone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="row" id="postal-address">
                                <div class="col-12">
                                    <label for="inputAddress" class="form-label" id="postal-address-label">Postal Address</label>
                                    <input id="addressLine1" type="text" class="form-control reg_input @error('addressLine1') is-invalid @enderror" value="{{ old('addressLine1') }}" placeholder="Address Line 1" name="addressLine1" autocomplete="addressLine1" >
                                    @error('addressLine1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <input id="addressLine2" type="text" class="form-control reg_input mt-2" placeholder="Address Line 2" value="{{ old('addressLine2') }}" name="addressLine2">
                                </div>
                                <div class="col-12 address-inline">
                                    <div class="row">
                                        <div class="col-md-5 inline-input">
                                            <input id="inputCity" type="text" class="form-control reg_input mt-2 @error('inputCity') is-invalid @enderror" name="inputCity" value="{{ old('inputCity') }}" placeholder="City">
                                            @error('inputCity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 inline-input">
                                            <select id="inputState" class="counter_input counter_options reg_input mt-2 @error('inputState') is-invalid @enderror" name="inputState" value="{{ old('inputState') }}">
                                                <option disabled selected>State</option>
                                                <option value="Queensland" {{old('inputState') == 'Queensland' ? 'selected' : ''}}>Queensland</option>
                                                <option value="ACT" {{old('inputState') == 'ACT' ? 'selected' : ''}}>ACT</option>
                                                <option value="NT" {{old('inputState') == 'NT' ? 'selected' : ''}}>NT</option>
                                                <option value="Tasmania" {{old('inputState') == 'Tasmania' ? 'selected' : ''}}>Tasmania</option>
                                                <option value="Victoria" {{old('inputState') == 'Victoria' ? 'selected' : ''}}>Victoria</option>
                                                <option value="WT" {{old('inputState') == 'WT' ? 'selected' : ''}}>WT</option>
                                                <option value="NSW" {{old('inputState') == 'NSW' ? 'selected' : ''}}>NSW</option>
                                            </select>
                                            @error('inputState')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 inline-input" style="padding-right: 0;">
                                            <input id="post_code" type="text" class="form-control reg_input mt-2 @error('post_code') is-invalid @enderror" name="post_code"  placeholder="Post" value="{{ old('post_code') }}">
                                            @error('post_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="reg_checkbox mt-3">
                                <input class="reg_check" type="checkbox" id="termsAndConditions" required>
                                <small> I accept the <a href="#">terms & condition</a> of <strong><i>TaGET</i></strong> to the specifics.</small>
                            </div>
                            <button type="submit" class="reg_form_button">Register</button>
                            <div ><small>Already have an account? <a href="{{ route('login') }}">Log in</a></small></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
