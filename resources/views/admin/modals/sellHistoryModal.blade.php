<div class="modal fade" id="sellHistory" tabindex="-1" aria-labelledby="sellHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="sellHistoryLabel">Transaction History</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- modal-body -->
            <div class="modal-body">
                <div class="col-12 mb-4">
                    <table>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">Date</th>
                                <th class="column3">Volume(kWh)</th>
                                <th class="column3">Seller Received Amount</th>
                                <th class="column3">Zone</th>
                            </tr>
                        </thead>
                        <tbody id="sellHistoryTableBody">

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- modal-body END -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
