@extends('layouts.admin')

@section('title', ' - Inactive')

@section('content')

<section id="page-main-section">
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pt-3"><h4 style="color: red">Access Restricted <i class="fa fa-exclamation-circle"></i></h4></div>
                <br>
                <div class="card-body">
                    <h5>Your account is deactivated by the Service Manager.</h5>
                    <h5>Contact <i>TaGET</i> for details.</h5>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@endsection

@section('pageJS')

    <script>
        $(document).ready(function() {
            document.querySelector("#submenu-closed").click()
        });
    </script>

@endsection