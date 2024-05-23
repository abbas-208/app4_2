@extends('layouts.admin')

@section('title', ' - Change Password')

@section('content')

<div class="container-fluid">

    <br>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">Profile</a></li>
          <li class="breadcrumb-item active" aria-current="page">Change Password</li>
        </ol>
    </nav>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pt-3"><h4>Change Password</h4></div>

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger" style="margin: 1% 1% 0 1%;">
                        <p style="margin-bottom: 0">{{ $message }}</p>
                    </div>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ route('updatePassword', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="current_password" class="form-label admin-form-label">Current Password</label>
                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password">
                            @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>

                        <div class="mb-3">
                            <label for="current_password" class="form-label admin-form-label">New Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label admin-form-label">Confirm New Password</label>
                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control">
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
