
<!-- Modal - Delete Energy -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- modal-body -->
            <div class="modal-body" id="deleteModalBody">
            </div>
            <!-- modal-body END -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form>
                    @csrf
                    
                    <input type="hidden" id="delete_item_id" name="delete_item_id">
                    <button type="submit" class="btn btn-primary deleteItem-submit">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal - Delete Energy END -->