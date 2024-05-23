@extends('layouts.main')

@section('title', ' - Login')

@section('content')
<div class="container mt-4">
        @if ($message = Session::get('success'))
            <div class="alert alert-info" style="width:50%; text-align:center; margin: auto;">
                <p style="margin-bottom: 0">{{ $message }}</p>
            </div>
            {{ Session::forget('success') }}
        @endif
    <div class="row justify-content-center mt-3 mb-5">
        <div class="col-sm-12 col-lg-8">
            <div class="reg_form">
                <div class="row fill_height">
                    <div class="col fill_height">
                        <form class="reg_form_content d-flex flex-column align-items-center justify-content-center" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="reg_form_title">Login</div>

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

                            <button type="submit" class="btn reg_form_button">
                                {{ __('Login') }}
                            </button>

                            <div class="row mt-5">
                                <div class="col-12">

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
