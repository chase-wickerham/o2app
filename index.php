<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Redirect to the dashboard
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Php Application Login</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>

<body>
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <img class="logo justify-content-center text-center col-md-12" src="applogo.png">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="login-wrap p-4 p-md-5">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-user-o"></span>
                        </div>
                        <h3 id="formTitleText" class="text-center mb-4">
                            <span id="headsigninText">SIGN IN</span>
                            <span id="headregisterText" style="display:none;">REGISTER</span>
                        </h3>

                        <!-- Login Form -->
                        <form action="#" id="loginForm" class="login-form">
                            <div class="form-group">
                                <input type="text" class="form-control rounded-left" placeholder="Email address" id="email" name="email" required>
                            </div>
                            <div class="form-group d-flex">
                                <input type="password" class="form-control rounded-left" placeholder="Password" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
                            </div>
                        </form>

                        <!-- Registration Form -->
                        <form action="#" id="registerForm" class="register-form" style="display:none;">
                            <div class="form-group">
                                <input type="text" class="form-control rounded-left" placeholder="Email address" id="reg_email" name="reg_email" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control rounded-left" placeholder="Password" id="reg_password" name="reg_password" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control rounded-left" placeholder="Confirm Password" id="reg_confirm_password" name="reg_confirm_password" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-success rounded submit px-3">Register</button>
                            </div>
                        </form>

                        <a href="#" id="toggleForm" style="float:right;">
                            <span id="signupText">Sign Up</span>
                            <span id="alreadyuserText" style="display:none;">Already a User?</span>
                        </a>

                        <div id="success-alert" class="alert alert-success" role="alert" style="display:none;"></div>
                        <div id="error-alert" class="alert alert-danger" role="alert" style="display:none;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="message"></div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            function toggleForms() {
                $('#loginForm, #registerForm, #signupText, #alreadyuserText, #headsigninText, #headregisterText').toggle();
            }

            // Toggle between login and register forms
            $('#toggleForm').click(function(e) {
                e.preventDefault();
                toggleForms();
            });

            // Registration form submission
            $('#registerForm').submit(function(e) {
                e.preventDefault();

                let email = $('#reg_email').val();
                let password = $('#reg_password').val();
                let confirmPassword = $('#reg_confirm_password').val();

                if (password !== confirmPassword) {
                    alert("Passwords do not match!");
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "register.php",
                    data: {
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        if (response === "success") {
                            $('#success-alert').text('Registration successful! Please log in.').show();
                            $('#error-alert').hide();
                            $('#registerForm')[0].reset();
                            toggleForms();
                        } else {
                            $('#error-alert').text(response).show();
                            $('#success-alert').hide();
                        }

                        setTimeout(function() {
                            $('#success-alert, #error-alert').fadeOut('slow');
                        }, 5000);
                    }
                });
            });

            // Login form submission
            $('#loginForm').submit(function(e) {
                e.preventDefault();

                let email = $('#email').val();
                let password = $('#password').val();

                $.ajax({
                    type: "POST",
                    url: "login.php",
                    data: {
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        if (response === "success") {
                            location.href = "dashboard.php";
                        } else {
                            $('#error-alert').text(response).show();
                            $('#success-alert').hide();
                        }

                        setTimeout(function() {
                            $('#success-alert, #error-alert').fadeOut('slow');
                        }, 5000);
                    }
                });
            });
        });
    </script>
</body>

</html>
