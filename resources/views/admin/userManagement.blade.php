@extends('layouts.admin')

@section('title', ' - Manage User')

@section('content')
		
<section id="page-main-section">
    <div class="container-sm">				
        <div class="row">
            <div class="col-12">
                <h2>User Management</h2>
            </div>
            <div class="col-12 mt-2 mb-3">
                <button class="btn btn-success bg-gradient" onclick="location.href='{{ route('createUser') }}'">Create a new user</button>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success" style="margin: 0 1% 1% 1%;">
                    <p style="margin-bottom: 0">{{ $message }}</p>
                </div>
                {{ Session::forget('success') }}
            @endif
            <div class="col-12">
                <table>
                    <thead>
                        <tr class="table100-head">
                            <th class="column1">User ID</th>
                            <th class="column3">Name</th>
                            <th class="column3">Email</th>
                            <th class="column3">Position</th>
                            <th class="column3">Zone</th>
                            <th class="column3">Status</th>
                            <th class="column3">Aciton</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="column1">{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->isServiceManager == 1 ? 'Service Manager' : ($user->trading_position == 1 ? 'Buyer' : ($user->trading_position == 2 ? 'Seller' : 'Both Buyer & Seller')) }}</td>
                            <td>{{ $user->zone->name }}</td>
                            @if ($user->isServiceManager)
                                <td>{{ $user->isActivated ? 'Active' : 'Deactivated'  }}</td>
                                <td></td>
                            @else
                                <td>
                                    @if ($user->isActivated)
                                        <form method="POST" action="{{ route('deactivateUser', ['id' => $user->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-warning">Deactivate</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('activateUser', ['id' => $user->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Activate</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('deleteUser', ['id' => $user->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection

@section('pageJS')

    <script>

    </script>

@endsection