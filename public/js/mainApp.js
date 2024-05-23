$(document).ready( () => {
    //When we submit the form with class = "reg_form_content". It will validate the fields.
    // $('.reg_form_content').on('submit', () => {
    //     //Check the Name fields
    //     if ($('#name').val() === "") {
    //         $('#validationMessage').html('Please enter your name');
    //         return false;
    //     }
    //     // Check Email is not empty
    //     else if ($('#email').val() === "") {
    //         $('#validationMessage').html('Please enter the email');
    //         return false;
    //     }
    //     // Check for valid Email
    //     else if (!validateEmail($('#email').val())) {
    //         $('#validationMessage').html('Please enter a valid email address');
    //         return false;
    //     }
    //     // Check Password is not empty
    //     else if ($('#password').val() === "") {
    //         $('#validationMessage').html('Please enter your password');
    //         return false;
    //     }
    //     //Check for valid Password
    //     else if (!validatePassword($('#password').val())) {
    //         $('#validationMessage').html('Password must contain<br> - minimum 5 to maximum 10 characters<br> - at least 1 number<br> - at least 2 uppercase letters<br> - and 1 special character');
    //         return false;
    //     }
    //     // Check whether the retyped password matches the password
    //     else if ($('#password').val() !== $('#confirm_password').val()) {
    //         $('#validationMessage').html('Confirm Password does not match with the Password');
    //         return false;
    //     }
    //     // Check if Trading position is selected
    //     else if ($('#tradingPosition').val() === "Choose Trading Position") {
    //         $('#validationMessage').html('Please select your Trading Position');
    //         return false;
    //     }
    //     // Check if Zone is selected
    //     else if ($('#zone').val() === "Choose Your Zone") {
    //         $('#validationMessage').html('Please select your Zone');
    //         return false;
    //     }
    //     // Check Address
    //     else if ($('#inputAddress1').val().concat($('#inputAddress2').val()) === "" ||  $('#inputCity').val() === "" || $('#inputState').val() === "State" || $('#inputZip').val() === "") {
    //         $('#validationMessage').html('Postal address is not complete');
    //         return false;
    //     }
    //     // Check whether a user agreed or not
    //     else if (!$('#termsAndConditions').is(':checked')) {
    //         $('#validationMessage').html('You need to agree the terms and conditions');
    //         return false;
    //     }
    //     // When the form is successfully submitted, create an alert message
    //     else {
    //         alert("Your form has been successfully submitted");
    //     }
    // })

})

function validateEmail(email_text) {
    var email = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return email.test( email_text );
}

function validatePassword(password_text) {
    var password = /(?=^.{5,10}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=(.*[A-Z]){2}).*$/;
    return password.test( password_text );
}

