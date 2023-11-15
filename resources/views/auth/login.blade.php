<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <!-- In the head section of your Blade layout -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Sign in & Sign up Form</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        span {
            color: red;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form id="login-form" class="sign-in-form">
                    @csrf
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" id="login-email" placeholder="Email" name="username" />
                    </div>
                    <span id="login-emailError"></span>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="login-password" placeholder="Password" name="password" />
                    </div>
                    <span id="login-passwordError"></span>
                    <input type="submit" value="Login" class="btn solid" />
                    <p class="social-text">Or Sign in with social platforms</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </form>

                <form class="sign-up-form" id="signupForm">
                    @csrf
                    <h2 class="title">Sign up</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" id="upUsername" placeholder="Username"
                            value="{{ old('username') }}" />
                    </div>
                    <span id="usernameError"></span>

                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="upEmail" name="email" placeholder="Email" />
                    </div>
                    <span id="emailError"></span>

                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="upPassword" name="password" placeholder="Password" />
                    </div>
                    <span id="passwordError"></span>
                    <input type="submit" id="sign-up" class="btn" value="Sign up" />
                    <p class="social-text">Or Sign up with social platforms</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3 id="your">New here ?</h3>
                    <p id="signupDiscription">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
                        ex ratione. Aliquid!
                    </p>
                    <button class="btn transparent" id="sign-up-btn">
                        Sign up
                    </button>
                </div>
                <img src="img/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us ?</h3>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
                        laboriosam ad deleniti.
                    </p>
                    <button class="btn transparent" id="sign-in-btn">
                        Sign in
                    </button>
                </div>
                <img src="img/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>



    <script>
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");

        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        sign_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#signupForm').on('submit', function(a) {
                a.preventDefault(); // without  refresh 
                var upUsername = $('#upUsername').val();
                var upEmail = $('#upEmail').val();
                var upPassword = $('#upPassword').val();
                // Get the CSRF token from the meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');



                //    send ajax request to  controller register
                $.ajax({
                    url: "{{ route('register') }}",
                    method: 'post',

                    data: {
                        _token: csrfToken, // Include CSRF token in the data
                        username: upUsername,
                        email: upEmail,
                        password: upPassword
                    },
                    success: function(data) {
                        // if data save to the database successfully then run this
                        if (data.success) {
                            $('#your').text("YOU'R")
                            $('#signupDiscription').text(data.success);
                            $('#sign-up-btn').hide();
                        }


                        // Check if there are no errors in input fields
                        if ($.isEmptyObject(data.result)) {
                            // No errors, change mode to sign in
                            container.classList.remove("sign-up-mode");
                        }

                        // remove values 
                        $('#emailError').text('');
                        $('#usernameError').text('');
                        $('#passwordError').text('');

                        $('#upUsername').val('');
                        $('#upEmail').val('');
                        $('#upPassword').val('');

                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        // Clear previous error messages
                        $('#emailError').text('');
                        $('#usernameError').text('');
                        $('#passwordError').text('');

                        // set the error messages
                        if (errors) {
                            if (errors.email) {
                                $('#emailError').text(errors.email);
                            }
                            if (errors.username) {
                                $('#usernameError').text(errors.username);
                            }
                            if (errors.password) {
                                $('#passwordError').text(errors.password);
                            }
                        }

                    }
                })
            });
        });
    </script>


    {{-- login --}}
    <script>
        $(document).ready(function(e) {
            $('#login-form').on('submit', function(e) {
                e.preventDefault();
                var loginEmail = $('#login-email').val();
                var loginPassword = $('#login-password').val();
                // Get the CSRF token from the meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');


                $.ajax({
                    url: "{{ route('login') }}",
                    method: "post",
                    data: {
                        _token: csrfToken,
                        email: loginEmail,
                        password: loginPassword
                    },
                    success: function(data) {
                        $('#login-email').val('');
                        $('#login-password').val('');



                        if (data.loginId !== null && data.loginId !== undefined) {
                            // Redirect to the specified URL
                            window.location.href = data.redirect;
                        }

                        if (data.errorEmail) {
                            $('#login-emailError').text(data.errorEmail);

                            // console.log(data.error);
                        }

                        if (data.errorPassword) {
                            $('#login-emailError').text('');
                            $('#login-passwordError').text(data.errorPassword);
                        }
                        //else{
                        //     {
                        //     $('#login-emailError').text('');
                        // }
                        // }



                    },
                    error: function(xsr) {
                        var errors = xsr.responseJSON.errors;

                        $('#login-emailError').text('')
                        $('#login-passwordError').text('')



                        if (errors) {
                            if (errors.email) {
                                $('#login-emailError').text(errors.email);
                            }
                            if (errors.password) {
                                $('#login-passwordError').text(errors.password);
                            }
                        }
                    }

                })

            })
        })
    </script>

</body>

</html>
