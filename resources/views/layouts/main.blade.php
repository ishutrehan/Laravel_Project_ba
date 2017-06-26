<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>@yield('pageTitle')</title>
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Karla:400,400i,700,700i|Montserrat:100,300,400,600,700,800,900" rel="stylesheet">
        <link href="{{ asset('assets/font/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
        <!-- {{ asset('assets/css/custom.css') }} -->
        <link href="{{ asset('assets/css/JiSlider.css') }}" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        
        <script src="{{ asset('assets/js/Chart.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/utils.js') }}"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <script type="text/javascript">
            var Base_Url = "<?php echo URL::to('/'); ?>";
        </script>
        <script>
            $(document).ready(function(){
                $("#click").click(function(){
                    $(".nav").slideToggle();
                });
            });
        </script>
        <script>
        $(document).ready(function(){
            $(".login_p").click(function(){
                $(".login_page").addClass("intro");
            });
            
            $("#close_lo").click(function(){
                $(".login_page").removeClass("intro");
            });
        });
        </script>
        @yield('head')
    </head>
    <style>
    #JiSlider {
    width: 100%;
    height: 430px;
    }
    </style>
    <body>
        <div class="main_wrap">
            <div class="login_page">
                <div class="ovel_about">
                    <div class="full_loginpag">
                        <span id="close_lo"><i class="fa fa-window-close" aria-hidden="true"></i></span>
                        <form action="myaccount.html">
                            <div class="dev_row">
                                <label>Username or Email Address</label>
                                <input type="text" name="" value="">
                            </div>
                            <div class="dev_row">
                                <label>Password</label>
                                <input type="text" name="" value="">
                            </div>
                            <div class="dev_row"><input type="checkbox" name="" value=""><p>Remember me</p></div>
                            <div class="dev_row"><input type="submit" name="" value="log in"><a href="#">Sign in</a></div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- header-part-start-->
            <div class="header">
                <div class="container">
                    <div class="head wp100">
                        <div class="logo"> <a href="{{ route('public.home') }}"><img src="{{ asset('assets/images/logo.png') }}" alt=""/></a> </div>
                       <span id="click"><i class="fa fa-bars" aria-hidden="true"></i></span> 
                       <div class="nav">
                            <ul>
                                @if(!Auth::check())
                                <li>
                                    <a href="{{ route('public.home') }}">Home</a>
                                </li>
                                <li class="">
                                    <a href="{{ route('public.aboutus') }}">About us</a>
                                </li>
                                <li class="">
                                    <a href="{{ route('public.terms-use') }}">Terms of use</a>
                                </li>
                                <li class="">
                                    <a href="{{ route('public.explore-page') }}">Explore</a>
                                </li>
                                <li class="">
                                    <a href="{{ route('public.contact-us') }}">contact us</a>
                                </li>                                
                                <li>
                                    <a href="{{ url('register') }}">Register</a>
                                </li>
                                <li>
                                    <a href="{{ url('login') }}">Login</a>
                                </li>
                                @else
                                @if( Auth::user()->subscription)
                                <li>
                                    <a href="{{ Auth::user()->homeUrl() }}">My Profile</a>
                                </li>
                                @endif
                                @if( Auth::user()->hasRole('user') && Auth::user()->subscription )
                                <li>
                                    <a href="{{ route('activated.protected') }}">Home Page</a>
                                </li>
                                @endif
                                @if( Auth::user()->hasRole('administrator') )
                                <li>
                                    <a href="{{ route('admin.members') }}">Members List</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.add-test') }}">Add Test</a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ url('logout') }}">Logout</a>
                                    <!-- login_p -->
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contant_part">
                @yield('content')
            </div>
            <div class="footer">
                <div class="container">
                    <div class="footer_iner wp100 center_dev">
                        <div class="foot_logo"><a href="#"><img src="{{ asset('assets/images/logo.png') }}" alt=""/></a></div>
                        
                        <div class="foot-nav">
                            <ul>
                                <li class="active"><a href="{{ route('public.home') }}">Home </a></li>
                                <li class=""><a href="{{ route('public.aboutus') }}">About us</a></li>
                                <li class=""><a href="{{ route('public.terms-use') }}">Terms of use</a></li>
                                <li class=""><a href="#">contact us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="copyright center_dev">
                    <p>© 2017 Blood-Academy. All rights reserved </p>
                </div>
            </div>
            
        </div>
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="{{ asset('assets/js/ie10-viewport-bug-workaround.js') }}"></script>
        <script src="{{ asset('assets/js/JiSlider.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>

        <script>
            $(window).load(function () {
                $('#JiSlider').JiSlider({color: '#fff', start: 2, reverse: true}).addClass('ff')
            })
            $(document).ready(function() {

                $(document).on('click', '.close', function(event) {
                    event.preventDefault();
                    $(".alert.in, .alert-success").remove()
                });

                $("#inputAgree").on('click', function(event) {
                    url = "{{route('public.terms-use')}}";
                    var win = window.open(url, '_blank');
                });

                $(".edit-sub").on('click', function(event) {
                    event.preventDefault();
                    $("#myModal").modal()
                    $("#user_id").val( $(this).attr('data-id') );
                    $("#user_date").val( $(this).attr('data-date') );
                });
                var max_fields      = 10;
                var wrapper         = $(".input_fields_wrap");
                var add_button      = $(".add_field_button");
                var x = 1;
                $(add_button).click(function(e) {
                    e.preventDefault();
                    if(x < max_fields) {
                        x++;
                        $(wrapper).append('<div class="row"><div class="col-md-8"><input type="text" class="form-control" name="multiple_opts['+x+'][option]"/></div><div class="col-md-4"><input type="checkbox" name="multiple_opts['+x+'][answer]"><a href="#" class="remove_field btn btn-primary">Remove</a></div></div>');
                    }
                });
            
                $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                })
            });
        </script>
        @yield('footer')
    </body>
</html>