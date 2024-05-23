
$(document).ready(function() {

    /**
     * Create Energy Ajax
     */
    $(".createEnergy-submit").click(function(e){
        e.preventDefault();

        var _token = $("input[name='_token']").val();
        var type = $("#type").val();
        var marketPrice = $("#marketPrice").val();

        $.ajax({
            type:"POST",
            url: createEnergyURL,
            data: {_token:_token, type:type, marketPrice:marketPrice},
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    //alert(data.success);
                    loadEnergies();
                    bootstrap.Modal.getInstance($("#createEnergy")).hide();
                    $("#type").val('');
                    $("#marketPrice").val('');
                    let msg = document.getElementById('energySuccess');
                    msg.innerHTML = data.success
                    msg.style.display = 'block';
                } else {
                    printErrorMsg(data.error);
                }
            }
        });
    }); 

    /**
     * Update Energy Ajax
     */
    $(".editEnergy-submit").click(function(e){
        e.preventDefault();

        var _token = $("input[name='_token']").val();
        var id = $("#energy_id").val();
        var type = $("#typeUp").val();
        var marketPrice = $("#marketPriceUp").val();

        $.ajax({
            type:"POST",
            url: updateEnergyURL,
            data: {_token:_token, energy_id:id, typeUp:type, marketPriceUp:marketPrice},
            success: function(data) {
                console.log(data.error)
                if ($.isEmptyObject(data.error)) {
                    loadEnergies();
                    bootstrap.Modal.getInstance($("#editEnergy")).hide();
                    let msg = document.getElementById('energySuccess');
                    msg.innerHTML = data.success
                    msg.style.display = 'block';
                } else {
                    printErrorMsg(data.error);
                }
            }
        });
    }); 

    /**
     * Delete Item Ajax
     */
    $(".deleteItem-submit").click(function(e){
        e.preventDefault();

        var _token = $("input[name='_token']").val();
        var id = $("#delete_item_id").val();

        $.ajax({
            type:"POST",
            url: deleteURL,
            data: {_token:_token, item_id:id},
            success: function(data) {
                console.log(data.error)
                if ($.isEmptyObject(data.error)) {
                    loadEnergies();
                    bootstrap.Modal.getInstance($("#deleteModal")).hide();
                    let msg = document.getElementById('energySuccess');
                    msg.innerHTML = data.success
                    msg.style.display = 'block';
                } else {
                    printErrorMsg(data.error);
                }
            }
        });
    }); 

    /**
     * Update Fee Ajax
     */
    $(".editFee-submit").click(function(e){
        e.preventDefault();

        var _token = $("input[name='_token']").val();
        var id = $("#fee_id").val();
        var amount = $("#feeAmount").val();

        $.ajax({
            type:"POST",
            url: updateFeeURL,
            data: {_token:_token, fee_id:id, feeAmount:amount},
            success: function(data) {
                console.log(data.error)
                if ($.isEmptyObject(data.error)) {
                    loadCharges();
                    bootstrap.Modal.getInstance($("#editFee")).hide();
                    let msg = document.getElementById('feeSuccess');
                    msg.innerHTML = data.success
                    msg.style.display = 'block';
                } else {
                    printErrorMsg(data.error);
                }
            }
        });
    }); 
    


    /**
     * Build modal form fields error messages
     */
    function printErrorMsg (msg) {
        $.each( msg, function( key, value ) {
            console.log(key);
            $('.'+key+'_err').text(value);
        });
    }

    /**
     * Remove validation text from modal when it is opened
     */
    // var modalButtons = document.getElementsByClassName("btn");
    // for (let i = 0; i < modalButtons.length; i++) {
    //     modalButtons[i].addEventListener("click", function() {
    //         let error_text = document.getElementsByClassName('text-danger');
    //         for(let i=0; i<error_text.length; i++) {
    //             error_text[i].innerHTML = '';
    //         }
    //     });
    // }
    function removeMessages() {
        let success_msg = document.getElementsByClassName('alert-success');
        for(let i=0; i<success_msg.length; i++) {
            success_msg[i].style.display = 'none';
        }

        let error_msg = document.getElementsByClassName('text-danger');
        for(let i=0; i<error_msg.length; i++) {
            error_msg[i].innerHTML = '';
        }
    }

    /**
     * Remove previous success & error messages
     */
    $('#createEnergy').on('show.bs.modal', function(e) {
        removeMessages();
    });
    $('#editEnergy').on('show.bs.modal', function(e) {
        removeMessages();
    });
    $('#deleteModal').on('show.bs.modal', function(e) {
        removeMessages();
    });
    $('#energyHistory').on('show.bs.modal', function(e) {
        removeMessages();
        var id = e.relatedTarget.dataset.id;
        //Get Energy History Ajax 
        $.ajax({
            type:"GET",
            url: energyHistoryURL.replace(':energy_id', id),
            data: {},
            success: function(data) {
                console.log(data.success)
                $("#energyHistoryTableBody").html(data.html);
            }
        });
    });

    $('#editFee').on('show.bs.modal', function(e) {
        removeMessages();
    });
    $('#feeHistory').on('show.bs.modal', function(e) {
        removeMessages();
        var id = e.relatedTarget.dataset.id;
        //Get Fee History Ajax 
        $.ajax({
            type:"GET",
            url: feeHistoryURL.replace(':fee_id', id),
            data: {},
            success: function(data) {
                console.log(data.success)
                $("#feeHistoryTableBody").html(data.html);
            }
        });
    });

});

