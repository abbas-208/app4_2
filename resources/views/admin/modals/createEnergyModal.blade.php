<!-- Modal - Create Energy -->
<div class="modal fade" id="createEnergy" tabindex="-1" aria-labelledby="createEnergyLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createEnergyLabel">Create Energy</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- modal-body -->
            <div class="modal-body">
                <form>
                    @csrf
                    
                    <div class="mb-3">
                        <label for="type" class="form-label modal-form-label">Energy Type</label>
                        <input type="text" class="form-control" id="type" name="type">
                        <span class="text-danger error-text type_err"></span>
                    </div>
                    <div class="mb-3">
                        <label for="marketPrice" class="form-label modal-form-label">Market Price( per kWh )</label>
                        <input type="number" step="any" class="form-control" id="marketPrice" name="marketPrice">
                        <span class="text-danger error-text marketPrice_err"></span>
                    </div>
                    <button type="submit" class="btn btn-primary createEnergy-submit">Create</button>
                </form>
            </div>
            <!-- modal-body END -->
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal - Create Energy END -->