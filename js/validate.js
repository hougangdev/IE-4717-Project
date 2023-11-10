document.addEventListener("DOMContentLoaded", function() {
    
    var registerForm = document.getElementById('form_user');

    registerForm.addEventListener('submit', function(event) {
        var username = document.getElementById('registration_input_name').value;
        var email = document.getElementById('registration_input_email').value;
        var password = document.getElementById('registration_input_password').value;
        var address = document.getElementById('registration_input_address').value;
        var postal = document.getElementById('registration_input_postal').value;

        var errorFlag = false;

        if (!validateUsername(username)) {
            displayError('error_name', 'Invalid username.');
            errorFlag = true;
        } else {
            clearError('error_name');
        }

        if (!validateEmail(email)) {
            displayError('error_email', 'Invalid email format. Correct format is: localpart@domain.com');
            errorFlag = true;
        } else {
            clearError('error_email');
        }

        if (!validatePassword(password)) {
            displayError('error_password', 'Password must be at least 8 characters.');
            errorFlag = true;
        } else {
            clearError('error_password');
        }

        if (!validateAddress(address)) {
            displayError('error_address', 'Invalid address.');
            errorFlag = true;
        } else {
            clearError('error_address');
        }

        if (!validatePostal(postal)) {
            displayError('error_postal', 'Postal must be 6 digits.');
            errorFlag = true;
        } else {
            clearError('error_postal');
        }

        if (errorFlag) {
            event.preventDefault();
        }
    });

    function validateUsername(username) {
        return true;
    }

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email.toLowerCase());
    }

    function validatePassword(password) {
        return password.length >= 8;
    }

    function validateAddress(address) {
        return true;
    }

    function validatePostal(postal) {
        // This regular expression matches exactly 6 digits
        var regex = /^\d{6}$/;
        return regex.test(postal);
    }

    function displayError(elementId, message) {
        document.getElementById(elementId).innerText = message;
    }

    function clearError(elementId) {
        document.getElementById(elementId).innerText = '';
    }

});
