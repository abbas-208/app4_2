<!-- Modal - Update Energy -->
<div class="modal fade" id="editEnergy" tabindex="-1" aria-labelledby="editEnergyLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editEnergyLabel">Edit Energy</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- modal-body -->
            <div class="modal-body">
                <form>
                    @csrf
                    
                    <input type="hidden" id="energy_id" name="energy_id">
                    <div class="mb-3">
                        <label for="typeUp" class="form-label modal-form-label">Energy Type</label>
                        <input type="text" class="form-control" id="typeUp" name="typeUp">
                        <span class="text-danger error-text typeUp_err"></span>
                    </div>
                    <div class="mb-3">
                        <label for="marketPriceUp" class="form-label modal-form-label">Market Price</label>
                        <input type="number" step="any" class="form-control" id="marketPriceUp" name="marketPriceUp">
                        <span class="text-danger error-text marketPriceUp_err"></span>
                    </div>
                    <button type="submit" class="btn btn-primary editEnergy-submit">Update</button>
                </form>
            </div>
            <!-- modal-body END -->
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal - Update Energy END -->