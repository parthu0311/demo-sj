@extends('frontlayouts.master')
@section('title', 'Login | Registrations')
@section('content')

    <!--Login Register Area Start-->
    <section class="login-reister-area">
        <div class="container">
            <div class="row">


                    <div class="col-lg-6 col-md-6 col-sm-12 register-left">
                        <form action="/login" method="post" id="login_post">
                            {{ csrf_field() }}
                        <div class="login-register-form">
                            <h2>LOG IN YOUR ACCOUNT</h2>
                            <div class="login-register">
                                <div class="l-r-p left">
                                    <p>Login your account to discover all greatest</p>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <input type="text" name="email" placeholder="Please enter email" value="{{ !empty(Cookie::get('email')) ? Cookie::get('email') : '' }}">
                                <input type="password" name="password" placeholder="Please enter Password">
                                <div class="pass-link">
                                    <label>
                                        <input type="checkbox" value="1" name="remember_me">
                                        <span>Keep me logged in</span>
                                    </label>
                                    <a class="forgot-pass" href="#">Forgot your Password ?</a>
                                </div>
                                <button type="submit" class="btn c-btn" href="#">Login</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 register-right">
                        <form action="/register" method="post" id="reg_post">
                            {{ csrf_field() }}
                        <div class="login-register-form">
                            <h2>DON’T HAVE AN ACCOUNT ? REGISTER NOW</h2>
                            <div class="login-register">
                                <div class="l-r-p">
                                    <p>By creating an account with our store, you will able to move through the checkout</p>
                                    <p>process faster. Store multipule shipping addresses, view and track your orders </p>
                                    <p>in your account and more</p>
                                </div>
                                <div class="row">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <input type="text" id="first_name" name="first_name" placeholder="First Name">
                                        <input type="email" id="email" name="email" placeholder="Email">
                                        <input type="password" id="password" name="password" placeholder="password">
                                        <button type="submit" class="btn reg-c-btn">Register Now</button>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" id="last_name" name="last_name" placeholder="Last Name">
                                        <input type="text" id="mobile" name="mobile" placeholder="Mobile">
                                        <input type="password" id="re_password" name="re_password" placeholder="Re-password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                <hr>

            </div>
        </div>
    </section>
    <!--End of Login Register Area-->
    <!--Service Area Start-->
    <section class="service-area">
        <div class="container">
            <div class="row">
                <div class="single-service">
                    <div class="service-icon">
                        <div class="service-tablecell">
                            <img src="img/serv-1.png" alt="">
                        </div>
                    </div>
                    <h4>High quality</h4>
                    <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                </div>
                <div class="single-service">
                    <div class="service-icon">
                        <div class="service-tablecell">
                            <img src="img/serv-2.png" alt="">
                        </div>
                    </div>
                    <h4>Fast delivery</h4>
                    <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                </div>
                <div class="single-service">
                    <div class="service-icon">
                        <div class="service-tablecell">
                            <img src="img/serv-3.png" alt="">
                        </div>
                    </div>
                    <h4>24/7 Support</h4>
                    <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                </div>
                <div class="single-service">
                    <div class="service-icon">
                        <div class="service-tablecell">
                            <img src="img/serv-4.png" alt="">
                        </div>
                    </div>
                    <h4>14 - day returns</h4>
                    <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                </div>
                <div class="single-service">
                    <div class="service-icon">
                        <div class="service-tablecell">
                            <img src="img/serv-5.png" alt="">
                        </div>
                    </div>
                    <h4>Secure checkout</h4>
                    <p>Lorem ipsum dolor sit amet, conseetur adipiscing elit </p>
                </div>
            </div>
        </div>
    </section>
    <!--End of Service Area-->

@endsection
@push('js')
    <style type="text/css">
        .register-right input {
            border: 1px solid #c2c2c2;
            color: #000000;
            height: 38px;
            margin-bottom: 0px;
            margin-top: 20px;
            width: 100%;
            padding-left: 20px;
        }
        .reg-c-btn {
            margin-top: 20px;
        }
        .error{
            color: #ff5c5c ;
        }
        .login-reister-area form {
            border-bottom: none;
            display: block;
            overflow: hidden ;
            padding-bottom: 41px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js" type="text/javascript"></script>
    <script type="text/javascript">


        @if(session()->has('message'))
            $.confirm({
                title: 'Registration Success!',
                content: '{{ session()->get('message') }}',
                type: 'green',
                typeAnimated: true,
                boxWidth: '500px',
                useBootstrap: false,
                buttons: {
                    close: function () {
                    }
                }
            });
        @endif

        @if(session()->has('error'))
        $.confirm({
            title: 'Login Error!',
            content: '{{ session()->get('error') }}',
            type: 'red',
            typeAnimated: true,
            boxWidth: '500px',
            useBootstrap: false,
            buttons: {
                close: function () {
                }
            }
        });
        @endif


        $(document).ready(function () {
            $('form[id="reg_post"]').validate({
                rules: {
                    first_name: 'required',
                    last_name: 'required',
                    email: {
                        required: true,
                        email: true
                    },
                    mobile: 'required',
                    password: {
                        required: true,
                        minlength: 8
                    },
                    re_password: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    },

                },
                messages: {
                    first_name: 'This field is required',
                    last_name: 'This field is required',
                    email: {
                        required: 'This field is required',
                        email: 'Enter a valid Email'
                    },
                    mobile: 'Enter a valid Mobile',
                    password: {
                        required: 'Please provide a password',
                        minlength: 'Password must be at least 8 characters long'
                    },
                    re_password : 'Re-password is not same.'
                },
                submitHandler: function(form) {
                    if($("#email").val() == ""){
                        $.confirm({
                            title: 'Encountered an error!',
                            content: 'Email Id is required field.',
                            type: 'red',
                            typeAnimated: true,
                            buttons: {
                                close: function () {
                                }
                            }
                        });
                    }else {
                        form.submit();
                    }
                }
            });

        });

    </script>

@endpush