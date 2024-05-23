@extends('layouts.admin')

@section('title', ' - Trading History')

@section('content')
		
<section id="page-main-section">

    <div class="container">
        <div class="row mt-1">
            <ul class="nav nav-tabs" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="ex1-tab-1" data-bs-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">
                        <h5>Purchase History</h5>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex1-tab-2" data-bs-toggle="tab" href="#ex1-tabs-2" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">
                        <h5>Sell History</h5>
                    </a>
                </li>
              </ul>
              <div class="tab-content" id="ex1-content">
                <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                    <div class="container mt-3">				
                        <div class="row">
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
                </div>
                <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                    <div class="container mt-3">				
                        <div class="row">
                            <div class="col-12">
                                <table>
                                    <thead>
                                        <tr class="table100-head">
                                            <th class="column1">ID</th>
                                            <th class="column3">Energy</th>
                                            <th class="column3">Volume(kWh)</th>
                                            <th class="column3">Price</th>
                                            <th class="column3">Zone</th>
                                            <th class="column3">Available Volume</th>
                                            <th class="column4">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($energy_products) > 0)
                                            @foreach ($energy_products as $product)
                                                <tr>
                                                    <td class="column1">{{ $product->id }}</td>
                                                    <td>{{ $product->energy->type }}</td>
                                                    <td>{{ $product->volume }}</td>
                                                    <td>$ {{ $product->seller_price }}</td>
                                                    <td>{{ Auth::user()->zone->name }}</td>
                                                    <td>
                                                        @if ($product->remaining_volume == 0 )
                                                            Soldout
                                                        @else
                                                            {{ $product->remaining_volume }}
                                                        @endif
                                                    </td>
                                                    @if ($product->remaining_volume < $product->volume )
                                                        <td>
                                                            <button class="btn btn-primary bg-gradient" data-id="{{ $product->id }}" data-bs-toggle="modal" data-bs-target="#sellHistory">
                                                                Sell History</button>
                                                        </td>
                                                    @else
                                                        <span></span>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" style="text-align: center; color:brown">
                                                    <h5>You haven't listed any energy for sell!</h5>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
        </div>
    </div>

</section>

{{-- Sell History Modal --}}
@include('admin.modals.sellHistoryModal')

@endsection

@section('pageJS')

<script>
    $(document).ready(function() {
        document.querySelector("#submenu-closed").click()
    });

    $('#sellHistory').on('show.bs.modal', function(e) {
        let id = e.relatedTarget.dataset.id;
        console.log(id);
        let ajaxURL = "{{ route('ajaxGetSellHistory', ':energy_product_id') }}";
        //Get Sell History Ajax 
        $.ajax({
            type:"GET",
            url: ajaxURL.replace(':energy_product_id', id),
            data: {},
            success: function(data) {
                console.log(data.success)
                $("#sellHistoryTableBody").html(data.html);
            }
        });
    });
</script>

@endsection