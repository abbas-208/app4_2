@extends('layouts.admin')

@section('title', ' - Update Balance')

@section('content')

<div class="container-fluid">

    <br>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">Profile</a></li>
          <li class="breadcrumb-item active" aria-current="page">Update Balance</li>
        </ol>
    </nav>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pt-3"><h4>Update Balance</h4></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updateBalance', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="balance" class="form-label admin-form-label">Balance</label>
                            <input id="balance" type="number" step="any" class="form-control @error('balance') is-invalid @enderror" name="balance" value="{{ $user->balance }}">
                            @error('balance')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
