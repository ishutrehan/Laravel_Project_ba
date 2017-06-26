@extends('layouts.main')

@section('pageTitle', 'Login / Register')

@section('head')

    {!! HTML::style('assets/css/register.css') !!}

    {!! HTML::style('assets/css/parsley.css') !!}

@stop



@section('content')

        

        <script src='https://js.stripe.com/v2/' type='text/javascript'></script>

        <div class="container"> 

        <div class="divd_six">

          {!! Form::open(['url' => url('login'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}





        @include('includes.status')



        <h4 class="form-signin-heading">Please sign in</h4>



        <label for="inputEmail" class="sr-only2">Username</label>

        {!! Form::text('username', null, [

            'class'                         => 'form-control',

            'placeholder'                   => '',

            'required',

            'id'                            => 'inputUsername',

            'data-parsley-required-message' => 'Username is required',

            'data-parsley-trigger'          => 'change focusout',

           

            'data-parsley-minlength'        => '2',

            'data-parsley-maxlength'        => '32'

        ]) !!}



        <label for="inputPassword" class="sr-only2">Password</label>

        {!! Form::password('password', [

            'class'                         => 'form-control',

            'placeholder'                   => '',

            'required',

            'id'                            => 'inputPassword',

            'data-parsley-required-message' => 'Password is required',

            'data-parsley-trigger'          => 'change focusout',

            'data-parsley-minlength'        => '6',

            'data-parsley-maxlength'        => '20'

        ]) !!}



        <div style="height:15px;"></div>

        <div class="row">

            <div class="col-md-12">

                <fieldset class="form-group">

                    {!! Form::checkbox('remember', 1, null, ['id' => 'remember-me']) !!}

                    <label for="remember-me">Remember me</label>

                </fieldset>

            </div>

        </div>



        <button class="btn btn-lg btn-primary btn-block login-btn" type="submit">Sign in</button>

        <p><a href="{{ url('password/reset') }}">Forgot password </a> /

        <a href="{{ route('public.getusername') }}">Forgot Username?</a></p>





        {!! Form::close() !!}



        </div>

  

 <div class="divd_six">

        <form accept-charset="UTF-8" action="{{url('register')}}" class="require-validation form-signin"

                data-cc-on-file="false"

                data-stripe-publishable-key="pk_test_ETYfMh0RAH7FAkidtf3KAxOz"

                id="payment-form" method="post">

                {{ csrf_field() }}





        @include('includes.errors')



        <h4 class="form-signin-heading">New customer registration</h4>



        <label for="inputFirstName" class="sr-only2">First name*</label>

        {!! Form::text('first_name', null, [

            'class'                         => 'form-control',

            'placeholder'                   => '',

            'required',

            'id'                            => 'inputFirstName',

            'data-parsley-required-message' => 'First name is required',

            'data-parsley-trigger'          => 'change focusout',

        ]) !!}



        <label for="inputLastName" class="sr-only2">Last name*</label>

        {!! Form::text('last_name', null, [

            'class'                         => 'form-control',

            'placeholder'                   => '',

            'required',

            'id'                            => 'inputLastName',

            'data-parsley-required-message' => 'Last name is required',

            'data-parsley-trigger'          => 'change focusout',

        ]) !!}





        <label for="inputEmail" class="sr-only2">Email address*</label>

        {!! Form::email('email', null, [

            'class'                         => 'form-control',

            'placeholder'                   => '',

            'required',

            'id'                            => 'inputEmail',

            'data-parsley-required-message' => 'Email address is required',

            'data-parsley-trigger'          => 'change focusout',

            'data-parsley-type'             => 'email'

        ]) !!}

        



        <label for="inputPassword" class="sr-only2">Password*</label>

        {!! Form::password('password', [

            'class'                         => 'form-control',

            'placeholder'                   => '',

            'required',

            'id'                            => 'inputPassword',

            'data-parsley-required-message' => 'Password is required',

            'data-parsley-trigger'          => 'change focusout',

            'data-parsley-minlength'        => '6',

            'data-parsley-maxlength'        => '20'

        ]) !!}





        <label for="inputPasswordConfirm" class="sr-only2 has-warning">Confirm Password*</label>

        {!! Form::password('password_confirmation', [

            'class'                         => 'form-control',

            'placeholder'                   => '',

            'required',

            'id'                            => 'inputPasswordConfirm',

            'data-parsley-required-message' => 'Password confirmation is required',

            'data-parsley-trigger'          => 'change focusout',

            'data-parsley-equalto'          => '#inputPassword',

            'data-parsley-equalto-message'  => 'Not same as Password',

        ]) !!}



        <label for="inputFirstName" class="sr-only2">City</label>

        {!! Form::text('city', null, [

            'class'                         => 'form-control',

            'placeholder'                   => '',

            'id'                            => 'inputCity',

            'data-parsley-required-message' => 'City is required',

            'data-parsley-trigger'          => 'change focusout',

      

        ]) !!}

        

        <label for="inputCountry" class="sr-only2">Country</label>

        {!! Form::text('country_residence', null, [

            'class'                         => 'form-control',

            'placeholder'                   => '',

            'id'                            => 'inputCountry',

            'data-parsley-required-message' => 'Country is required',

            'data-parsley-trigger'          => 'change focusout',

        ]) !!}  

       

        <div class="form-control">

          

            {!! Form::checkbox('agree', 1, null, [

                'class' => 'form-control',

                'required',

                'id'                            => 'inputAgree',

                'data-parsley-required-message' => 'Please accept terms of use.',

                'data-parsley-trigger'          => 'change focusout',

            ]) !!}

            

            <a target="_blank" href="{{route('public.terms-use')}}">I agree to 

Blood Academy terms 

and conditions</a>

        </div>

        <div class="g-recaptcha" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>



        <button class="btn btn-lg btn-primary btn-block register-btn" type="submit">Register</button>



        <p class="or-social"></p>





        </form>



</div>

</div>



@stop



@section('footer')



    <script type="text/javascript">

        window.ParsleyConfig = {

            errorsWrapper: '<div></div>',

            errorTemplate: '<span class="error-text"></span>',

            classHandler: function (el) {

                return el.$element.closest('input');

            },

            successClass: 'valid',

            errorClass: 'invalid'

        };

        $(document).ready(function(){

            $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){

                $(".alert-success").slideUp(500);

            });



            $(".danger").fadeTo(2000, 500).slideUp(500, function(){

                $(".danger").slideUp(500);

            });

        });

        $(function() {

            $('form.require-validation').bind('submit', function(e) {

                var $form         = $(e.target).closest('form'),

                    inputSelector = ['input[type=email]', 'input[type=password]',

                                     'input[type=text]', 'input[type=file]',

                                     'textarea'].join(', '),

                    $inputs       = $form.find('.required').find(inputSelector),

                    $errorMessage = $form.find('div.error'),

                    valid         = true;



                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');

                $inputs.each(function(i, el) {

                    var $input = $(el);

                    if ($input.val() === '') {

                        $input.parent().addClass('has-error');

                        $errorMessage.removeClass('hide');

                        e.preventDefault(); // cancel on first error

                    }

                });

            });

        });



        // $(function() {

        //     var $form = $("#payment-form");

        //     $form.on('submit', function(e) {

        //         if (!$form.data('cc-on-file')) {

        //             e.preventDefault();

        //             Stripe.setPublishableKey($form.data('stripe-publishable-key'));

        //             Stripe.createToken({

        //                 number: $('.card-number').val(),

        //                 cvc: $('.card-cvc').val(),

        //                 exp_month: $('.card-expiry-month').val(),

        //                 exp_year: $('.card-expiry-year').val()

        //             }, stripeResponseHandler);

        //         }

        //     });



        //     function stripeResponseHandler(status, response) {

        //         if (response.error) {

        //             $('.error')

        //                 .removeClass('hide')

        //                 .find('.alert')

        //                 .text(response.error.message);

        //         } else {

        //             // token contains id, last4, and card type

        //             var token = response['id'];

        //             // insert the token into the form so it gets submitted to the server

        //             $form.find('input[type=text]').empty();

        //             $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

        //             $form.get(0).submit();

        //         }

        //     }

        // });

    </script>



    {!! HTML::script('/assets/plugins/parsley.min.js') !!}



    <script src='https://www.google.com/recaptcha/api.js'></script>



@stop