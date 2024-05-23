@extends('layouts.admin')

@section('title', ' - Trading History')

@section('content')
		
<section id="page-main-section">
    <div class="container-sm">				
        <div class="row">
            <div class="col-12 mb-4">
                <h2>Energy Purchase History</h2>
            </div>
            <div class="col-12">
                <table>
                    <thead>
                        <tr class="table100-head">
                            <th class="column1">Type</th>
                            <th class="column3">Volume(kWh)</th>
                            <th class="column3">Price</th>
                            <th class="column4">Zone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($trades) > 0)
                            @foreach ($trades as $trade)
                                <tr>
                                    <td class="column1">{{ $trade->energy_product->energy->type }}</td>
                                    <td>{{ $trade->volume }}</td>
                                    <td>$ {{ $trade->trade_price }}</td>
                                    <td>{{ Auth::user()->zone->name }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" style="text-align: center; color:brown">
                                    <h5>You have not purchased any energy yet!</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="container mb-5">
    <div class="row col-2" style="margin: auto;">
        <button type="button" class="btn btn-success bg-gradient" onclick="downloadPDF()">Export to PDF</button>
    </div>
</div>

@endsection

@section('pageJS')

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            document.querySelector("#submenu-closed").click()
        });

        function downloadPDF() {
            const element = document.getElementById('page-main-section');
            // Choose the element and save the PDF for your user.
            let options = 
            {
                filename: 'Trading History ' + new Date().toLocaleDateString(),
                html2canvas: { scale: 4 }
            };
            html2pdf().set(options).from(element).save();
        }
    </script>

@endsection