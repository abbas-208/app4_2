@extends('layouts.admin')

@section('title', ' - Profile')

@section('content')

<div class="container-fluid">
    <br>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('profile.index') }}" style="text-decoration:none;">Profile</a></li>
          <li class="breadcrumb-item active" aria-current="page">Update Profile</li>
        </ol>
    </nav>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pt-3"><h4>Update User Profile</h4></div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success" style="margin: 1% 1% 0 1%;">
                        <p style="margin-bottom: 0">{{ $message }}</p>
                    </div>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label admin-form-label">Name</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label admin-form-label">Email Address</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="tradingPosition" class="form-label admin-form-label">Trading Position</label>

                            <select id="tradingPosition" class="form-select @error('tradingPosition') is-invalid @enderror" name="tradingPosition">
                                <option disabled>Choose Trading Position</option>
                                <option value="1" {{ $user->trading_position == 1 ? 'selected' : '' }}>Buyer</option>
                                <option value="2" {{ $user->trading_position == 2 ? 'selected' : '' }}>Seller</option>
                                <option value="3" {{ $user->trading_position == 3 ? 'selected' : '' }}>Both Buyer and Seller</option>
                            </select>
                            @error('tradingPosition')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="zone" class="form-label admin-form-label">Zone</label>

                            <select id="zone" class="form-select @error('zone') is-invalid @enderror" name="zone">
                                <option disabled>Choose Your Zone</option>
                                @foreach ($zones as $zone=>$value)
                                    <option value="{{ $value['id'] }}" {{ $user->zone->id == $value['id'] ? 'selected' : ''}}> {{ $value['name'] }} </option>
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

                            <input id="addressLine1" type="text" class="form-control @error('addressLine1') is-invalid @enderror" name="addressLine1" value="{{ $user->address_line_1 }}">
                            @error('addressLine1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3" style="padding-left: 1%;">
                            <label for="addressLine2" class="form-label admin-form-label">Address Line 2</label>

                            <input id="addressLine2" type="text" class="form-control @error('addressLine2') is-invalid @enderror" name="addressLine2" value="{{ $user->address_line_2 }}">
                            @error('addressLine2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-4" style="padding: 0 1%;">
                            <div class="col-md-4">
                                <label for="inputCity" class="form-label admin-form-label">City</label>

                                <input id="inputCity" type="text" class="form-control @error('inputCity') is-invalid @enderror" name="inputCity" value="{{ $user->city }}">
                                @error('inputCity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="inputState" class="form-label admin-form-label">State</label>

                                <select id="inputState" class="form-select @error('inputState') is-invalid @enderror" name="inputState">
                                    <option disabled>State</option>
                                    <option value="Queensland" {{ $user->state == 'Queensland' ? 'selected' : '' }}>Queensland</option>
                                    <option value="ACT" {{ $user->state == 'ACT' ? 'selected' : '' }}>ACT</option>
                                    <option value="NT" {{ $user->state == 'NT' ? 'selected' : '' }}>NT</option>
                                    <option value="Tasmania" {{ $user->state == 'Tasmania' ? 'selected' : '' }}>Tasmania</option>
                                    <option value="Victoria" {{ $user->state == 'Victoria' ? 'selected' : '' }}>Victoria</option>
                                    <option value="WT" {{ $user->state == 'WT' ? 'selected' : '' }}>WT</option>
                                    <option value="NSW" {{ $user->state == 'NSW' ? 'selected' : '' }}>NSW</option>
                                </select>
                                @error('inputState')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4" style="padding-right: 0;">
                                <label for="post_code" class="form-label admin-form-label">Post Code</label>

                                <input id="post_code" type="text" class="form-control @error('post_code') is-invalid @enderror" name="post_code" value="{{ $user->post_code }}">
                                @error('post_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                        <a class="btn btn-secondary" onclick="location.href='{{ route('profile.index') }}'">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
