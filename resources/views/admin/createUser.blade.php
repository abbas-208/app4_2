@extends('layouts.admin')

@section('title', ' - Create User')

@section('content')

<div class="container-fluid mb-5">
    <br>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('manageUser') }}" style="text-decoration:none;">User Management</a></li>
          <li class="breadcrumb-item active" aria-current="page">Create a new User</li>
        </ol>
    </nav>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pt-3"><h4>Create User</h4></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <input type="hidden" id="manager" name="manager" value="1">
                        <div class="mb-3">
                            <label for="name" class="form-label admin-form-label">Name</label>
                            <input  id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label admin-form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label admin-form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label admin-form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="tradingPosition" class="form-label admin-form-label">Trading Position</label>

                            <select id="tradingPosition" class="form-select @error('tradingPosition') is-invalid @enderror" name="tradingPosition" value="{{ old('tradingPosition') }}">
                                <option disabled selected>Choose Position</option>
                                <option value="1" {{old('tradingPosition') == 1 ? 'selected' : ''}}>Buyer</option>
                                <option value="2" {{old('tradingPosition') == 2 ? 'selected' : ''}}>Seller</option>
                                <option value="3" {{old('tradingPosition') == 3 ? 'selected' : ''}}>Both Buyer and Seller</option>
                                <option value="4" {{old('tradingPosition') == 4 ? 'selected' : ''}}>Service Manager</option>
                            </select>
                            @error('tradingPosition')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="zone" class="form-label admin-form-label">Zone</label>

                            <select id="zone" class="form-select @error('zone') is-invalid @enderror" name="zone" value="{{ old('zone') }}">
                                <option disabled selected>Choose Zone</option>
                                @foreach ($zones as $zone=>$value)
                                    <option value="{{ $value['id'] }}" {{old('zone') == $value['id'] ? 'selected' : ''}}> {{ $value['name'] }} </option>
                                @endforeach
                            </select>
                            @error('zone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <h5 style="color:darkblue; margin-top: 2%;">Postal Address</h5>

                        <div class="mb-3" style="padding-left: 1%;">
                            <label for="addressLine1" class="form-label admin-form-label">Address Line 1</label>

                            <input id="addressLine1" type="text" class="form-control @error('addressLine1') is-invalid @enderror" value="{{ old('addressLine1') }}" name="addressLine1" autocomplete="addressLine1" >
                            @error('addressLine1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3" style="padding-left: 1%;">
                            <label for="addressLine2" class="form-label admin-form-label">Address Line 2</label>

                            <input id="addressLine2" type="text" class="form-control mt-2" name="addressLine2" value="{{ old('addressLine2') }}">
                        </div>

                        <div class="row mb-4" style="padding: 0 1%;">
                            <div class="col-md-4">
                                <label for="inputCity" class="form-label admin-form-label">City</label>

                                <input id="inputCity" type="text" class="form-control mt-2 @error('inputCity') is-invalid @enderror" name="inputCity" value="{{ old('inputCity') }}">
                                @error('inputCity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="inputState" class="form-label admin-form-label">State</label>

                                <select id="inputState" class="form-select mt-2 @error('inputState') is-invalid @enderror" name="inputState" value="{{ old('inputState') }}">
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
                            <div class="col-md-4" style="padding-right: 0;">
                                <label for="post_code" class="form-label admin-form-label">Post Code</label>

                                <input id="post_code" type="text" class="form-control mt-2 @error('post_code') is-invalid @enderror" name="post_code" value="{{ old('post_code') }}">
                                @error('post_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Create
                        </button>
                        <a class="btn btn-secondary" onclick="location.href='{{ route('manageUser') }}'">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
