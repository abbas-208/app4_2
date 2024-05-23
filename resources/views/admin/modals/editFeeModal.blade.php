<!-- Modal - Update Fee -->
<div class="modal fade" id="editFee" tabindex="-1" aria-labelledby="editFeeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editFeeLabel">Edit Fee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- modal-body -->
            <div class="modal-body">
                <form>
                    @csrf
                    
                    <input type="hidden" id="fee_id" name="fee_id">
                    <div class="mb-3">
                        <label for="feeType" class="form-label modal-form-label">Fee Type</label>
                        <input type="text" class="form-control" id="feeType" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="feeAmount" class="form-label modal-form-label">Amount</label>
                        <input type="number" step="any" class="form-control" id="feeAmount" name="feeAmount">
                        <span class="text-danger error-text feeAmount_err"></span>
                    </div>
                    <button type="submit" class="btn btn-primary editFee-submit">Update</button>
                </form>
            </div>
            <!-- modal-body END -->
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal - Update Fee END -->