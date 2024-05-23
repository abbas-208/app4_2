@extends('layouts.admin')

@section('title', ' - Profile')

@section('content')

<br>
<div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <h2>User Profile</h2>
      </div>
    </div>
</div>
<br>

@if ($message = Session::get('success'))
<div class="alert alert-success" style="margin: 0 1% 1% 1%;">
    <p style="margin-bottom: 0">{{ $message }}</p>
</div>
@endif

<div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-user-tie" style="color: darkgreen"></i> &nbsp;{{ $user->name }}</h3>
                <h6>Email: {{ $user->email }}</h6>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card text-white bg-primary bg-gradient">
                            <div class="card-header">Zone</div>
                            <div class="card-body bg-light">
                              <h4 class="card-text" style="color: darkblue">
                                {{ $user->zone->name }}
                              </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-white" style="background-color: #af7ac5">
                            <div class="card-header">Trading Position</div>
                            <div class="card-body bg-light">
                              <h4 class="card-text" style="color: darkblue">
                                {{ $user->trading_position == 1 ? 'Buyer' : ($user->trading_position == 2 ? 'Seller' : 'Both Buyer & Seller') }}
                              </h4>
                            </div>
                        </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="card text-white" style="background-color: #52be80">
                            <div class="card-header">Balance</div>
                            <div class="card-body bg-light">
                              <h3 class="card-text" style="color: darkblue">
                                {{ $user->balance }} $
                              </h3>
                            </div>
                        </div>
                    </div>
                  </div>
            </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Profile Settings</h4>
            <p class="card-text"> </p>
            <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-outline-dark mt-3 profile-button">Update Profile</a><br>
            <a href="{{ route('profile\changePassword') }}" class="btn btn-outline-danger mt-3 profile-button">Change Password</a><br>
            @if(Auth::user()->trading_position != 2)
              <a href="{{ route('profile\changeBalance') }}" class="btn btn-outline-success mt-3 profile-button">Update Balance</a><br>
              <a 
                href="{{ Auth::user()->trading_position == 3 ? route('bothTradingHistory') : route('buyerTradingHistory') }}" 
                class="btn btn-outline-primary mt-3 profile-button">
                View Trading History
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
