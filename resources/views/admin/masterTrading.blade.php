@extends('layouts.admin')

@section('title', ' - Master Trading')

@section('content')

    <div class="container-fluid">
        <div class="row mt-3">
        <div class="col-12">

            <button type="button" class="collapsible"><b>Manage Renewable energy</b></button>
            <div class="content overflow-auto">
            <div class="container-fluid">
                <div class="row">
                <div class="col-12">
                    <button id="btn-create-master" class="btn btn-primary btn-master-modal" data-bs-toggle="modal" data-bs-target="#createEnergy">
                        Create Renewable Energy
                    </button>
                </div>
                <div id="energySuccess" class="alert alert-success" style="margin: 0 1% 1% 1%; display:none;"></div>
                <div class="col-12 mb-4">
                    <table>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">Type</th>
                                <th class="column2">Market Price (per kWh)</th>
                                <th class="column3">Action</th>
                            </tr>
                        </thead>
                        <tbody id="energyTableBody">

                        </tbody>
                    </table>
                </div>
                </div>
            </div>
            </div>

            <button type="button" class="collapsible"><b>Administration fee and Tax rate</b></button>
            <div class="content overflow-auto">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div id="feeSuccess" class="alert alert-success" style="margin: 0 1% 1% 1%; display:none;"></div>
                    <div class="col-12 mb-4">
                        <table id="fees-table">
                            <thead>
                                <tr class="table100-head">
                                    <th class="column1">Fee Type</th>
                                    <th class="column2">Current Amount</th>
                                    <th class="column3">Action</th>
                                </tr>
                            </thead>
                            <tbody id="feesTableBody">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>

            <button type="button" class="collapsible"><b>Trading History</b></button>
            <div class="content overflow-auto">
            <div class="container-fluid">
                <div class="row mt-4">
                <div class="col-12 mb-4">
                    <table id="fees-table">
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">Trade ID</th>
                                <th class="column1">Date</th>
                                <th class="column1">Energy</th>
                                <th class="column1">Volume (kWh)</th>
                                <th class="column1">Trade Price</th>
                                <th class="column1">Admin Fee</th>
                                <th class="column1">Seller ID</th>
                                <th class="column1">Buyer ID</th>
                                <th class="column1">Zone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($trades) > 0)
                                @foreach ($trades as $trade)
                                    <tr>
                                        <td class="column1">{{ $trade->id }}</td>
                                        <td class="column1">{{ $trade->created_at->toDateString() }}</td>
                                        <td class="column1">{{ $trade->energy_product->energy->type }}</td>
                                        <td class="column1">{{ $trade->volume }}</td>
                                        <td class="column1">$ {{ $trade->trade_price }}</td>
                                        <td class="column1">$ {{ $trade->admin_fee }}</td>
                                        <td class="column1">{{ $trade->energy_product->seller->id }}</td>
                                        <td class="column1">{{ $trade->buyer_id }}</td>
                                        <td class="column1">{{ $trade->buyer->zone->name }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" style="text-align: center; color:brown">
                                        <h5>No Trades Yet!</h5>
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

    {{-- Create Energy Modal --}}
    @include('admin.modals.createEnergyModal')
    {{-- Edit Energy Modal --}}
    @include('admin.modals.editEnergyModal')
    {{-- Delete Modal --}}
    @include('admin.modals.deleteConfirmModal')
    {{-- Energy History Modal --}}
    @include('admin.modals.energyHistoryModal')

    {{-- Edit Fee Modal --}}
    @include('admin.modals.editFeeModal')
    {{-- Fee History Modal --}}
    @include('admin.modals.feeHistoryModal')

@endsection

@section('pageJS')

    <script>
        /** Manage Renewable energy **/
        var createEnergyURL = "{{ route('ajaxCreateEnergy') }}";
        var updateEnergyURL = "{{ route('ajaxUpdateEnergy') }}";
        var deleteURL = "{{ route('ajaxDeleteItem') }}";
        var energyHistoryURL = "{{ route('ajaxGetEnergyHistory', ':energy_id') }}";

        function loadEnergies() {
            $.ajax({
                type:"GET",
                url: "{{ route('ajaxGetEnergies', 'true') }}",
                data: {},
                success: function(data) {
                    $("#energyTableBody").html(data.html);
                }
            });
        }
        loadEnergies();

        function editEnergy(event) {
            let selectedEnergy = event.parentElement.parentElement;
            let energyType = selectedEnergy.children[0].innerHTML;
            let price = selectedEnergy.children[1].innerHTML.substr(2);
            document.getElementById('energy_id').value = event.dataset.id;
            document.getElementById('typeUp').value = energyType;
            document.getElementById('marketPriceUp').value = price;

            console.log('clicked: ' + energyType)
        }

        function deleteItem(event) {
            document.getElementById('delete_item_id').value = event.dataset.id;
            document.getElementById('deleteModalLabel').innerHTML = "Delete " + event.dataset.type;
            document.getElementById('deleteModalBody').innerHTML = "Are you sure you want to delete " + event.dataset.type + "- " + event.parentElement.parentElement.children[0].innerHTML + "?";
        }

        function historyEnergy(event) {
            document.getElementById('energyHistoryLabel').innerHTML = event.parentElement.parentElement.children[0].innerHTML + " - Market price History";
        }

        /** Administration fee and Tax rate **/
        var updateFeeURL = "{{ route('ajaxUpdateFee') }}";
        var feeHistoryURL = "{{ route('ajaxGetFeesHistory', ':fee_id') }}";

        function loadCharges() {
            $.ajax({
                type:"GET",
                url: "{{ route('ajaxGetFees') }}",
                data: {},
                success: function(data) {
                    $("#feesTableBody").html(data.html);
                }
            });
        }
        loadCharges()

        function editFee(event) {
            let selectedFee = event.parentElement.parentElement;
            let feeType = selectedFee.children[0].innerHTML;
            let amount = selectedFee.children[1].innerHTML;
            document.getElementById('fee_id').value = event.dataset.id;
            document.getElementById('feeType').value = feeType;
            document.getElementById('feeAmount').value = amount.substr(2);

            console.log('clicked: ' + feeType)
        }

        function historyFee(event) {
            document.getElementById('feeHistoryLabel').innerHTML = event.parentElement.parentElement.children[0].innerHTML + " History";
        }
    </script>
    <!-- ajax js -->
    <script src="{{ asset('js/masterTrading.js') }}"></script>

@endsection
