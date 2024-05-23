<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaGET') }} @yield('title')</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- jquery cdn-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- custom style css-->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3ab8fa671d.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- Start Main -->
    <main class="d-flex flex-nowrap">

        {{-- navbar --}}
        @include('layouts.adminNavbar')


        <div class="b-example-divider b-example-vr overflow-auto" id="admin-body">
            {{-- topbar --}}
            @include('layouts.adminTopbar')

            {{-- main content --}}
            @yield('content')

        </div>
        </main>
    <!-- End Main -->

    {{-- footer --}}
    @include('layouts.footer')

    <!-- form validation js-->
    <script src="{{ asset('js/admin.js') }}"></script>

    <script>
        var createEnergyURL = "";
        var updateEnergyURL = "";
        var deleteURL = "";
        var energyHistoryURL = "";

        var updateFeeURL = "";
        var feeHistoryURL = "";

        function loadEnergies() {}
        function loadFees() {}
    </script>

    @yield('pageJS')
</body>
</html>
