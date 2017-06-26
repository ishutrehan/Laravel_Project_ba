@extends('layouts.main')

@section('head')
    {!! HTML::style('/assets/css/register.css') !!}
    {!! HTML::style('/assets/css/parsley.css') !!}
@stop

@section('content')
        
        <script src='https://js.stripe.com/v2/' type='text/javascript'></script>

        <!-- {!! Form::open(['url' => url('register'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!} -->
        <form accept-charset="UTF-8" action="{{url('register')}}" class="require-validation form-signin"
                data-cc-on-file="false"
                data-stripe-publishable-key="pk_test_ETYfMh0RAH7FAkidtf3KAxOz"
                id="payment-form" method="post">
                {{ csrf_field() }}


        @include('includes.errors')

        <h2 class="form-signin-heading">Please register</h2>

        <label for="inputEmail" class="sr-only">Email address</label>
        {!! Form::email('email', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Email address',
            'required',
            'id'                            => 'inputEmail',
            'data-parsley-required-message' => 'Email is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'email'
        ]) !!}

        <label for="inputFirstName" class="sr-only">Name</label>
        {!! Form::text('first_name', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Name',
            'required',
            'id'                            => 'inputFirstName',
            'data-parsley-required-message' => 'Name is required',
            'data-parsley-trigger'          => 'change focusout',
        ]) !!}

        <label for="inputFirstName" class="sr-only">Username</label>
        {!! Form::text('username', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Username',
            'required',
            'id'                            => 'inputUsername',
            'data-parsley-required-message' => 'Username is required',
            'data-parsley-trigger'          => 'change focusout',
        ]) !!}

        <label for="inputFirstName" class="sr-only">City</label>
        {!! Form::text('city', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'City',
            'required',
            'id'                            => 'inputCity',
            'data-parsley-required-message' => 'City is required',
            'data-parsley-trigger'          => 'change focusout',
      
        ]) !!}
        
        <label for="inputCurrenthospital" class="sr-only">Current hospital</label>
        {!! Form::text('current_hospital', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Current hospital',
            'id'                            => 'inputCurrenthospital',
            'data-parsley-required-message' => 'Current hospital is required',
            'data-parsley-trigger'          => 'change focusout',
    
        ]) !!}

        <label for="inputCountryresidence" class="sr-only">Country of residence</label>
        {!! Form::text('country_residence', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Country of residence',
            'id'                            => 'inputCountryresidence',
            'data-parsley-required-message' => 'Country of residence is required',
            'data-parsley-trigger'          => 'change focusout',
        ]) !!}

        <label for="inputHaematology" class="sr-only">Haematology trainee/ scientist</label>
        {!! Form::text('haematology', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Haematology trainee/ scientist',
            'id'                            => 'inputHaematology',
            'data-parsley-required-message' => 'Haematology trainee/ scientist is required',
            'data-parsley-trigger'          => 'change focusout'
        ]) !!}


        <label for="inputPassword" class="sr-only">Password</label>
        {!! Form::password('password', [
            'class'                         => 'form-control',
            'placeholder'                   => 'Password',
            'required',
            'id'                            => 'inputPassword',
            'data-parsley-required-message' => 'Password is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-minlength'        => '6',
            'data-parsley-maxlength'        => '20'
        ]) !!}


        <label for="inputPasswordConfirm" class="sr-only has-warning">Confirm Password</label>
        {!! Form::password('password_confirmation', [
            'class'                         => 'form-control',
            'placeholder'                   => 'Password confirmation',
            'required',
            'id'                            => 'inputPasswordConfirm',
            'data-parsley-required-message' => 'Password confirmation is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-equalto'          => '#inputPassword',
            'data-parsley-equalto-message'  => 'Not same as Password',
        ]) !!}
        
        <h3>Payment</h3><hr>
        
        <div class='form-control'>
            <div class='col-xs-12 form-group required'>
                <label class='control-label'>Name on Card</label> <input
                    class='form-control' size='4' type='text' required>
            </div>
        </div>
        <div class='form-control'>
            <div class='col-xs-12 form-group card required'>
                <label class='control-label'>Card Number</label> <input
                    autocomplete='off' class='form-control card-number' size='20'
                    type='text' required>
            </div>
        </div>
        <div class='form-control'>
            <div class='col-xs-4 form-group cvc required'>
                <label class='control-label'>CVC</label> <input autocomplete='off'
                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                    type='text' required>
            </div>
            <div class='col-xs-4 form-group expiration required'>
                <label class='control-label'>Expiration</label> <input
                    class='form-control card-expiry-month' placeholder='MM' size='2'
                    type='text' required>
            </div>
            <div class='col-xs-4 form-group expiration required'>
                <label class='control-label'> </label> <input
                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                    type='text' required>
                    Total: <span class='amount'>$300</span>
            </div>
        </div>
        <!--  <div class='form-control'>
            <div class='col-md-12 form-group'>
                <button class='form-control btn btn-primary submit-button'
                    type='submit' style="margin-top: 10px;">Pay »</button>
            </div>
        </div> -->
               <!--  <div class='form-control'>
                    <div class='col-md-12 error form-group hide'>
                        <div class='alert-danger alert'>Please correct the errors and try
                            again.</div>
                    </div>
                </div> -->
            
        
        <div class="form-control">
            <label for="inputPasswordConfirm" class="sr-only has-warning">Terms of use</label>
            {!! Form::checkbox('agree', 1, null, [
                'class' => 'form-control',
                'required',
                'id'                            => 'inputAgree',
                'data-parsley-required-message' => 'Please accept terms of use.',
                'data-parsley-trigger'          => 'change focusout',
            ]) !!}
            
            <a target="_blank" href="{{route('public.terms-use')}}">Terms of use</a>
        </div>
        <div class="g-recaptcha" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>

        <button class="btn btn-lg btn-primary btn-block register-btn" type="submit">Register</button>

        <p class="or-social"></p>

        <!-- @include('partials.socials') -->

        </form>
        @if ((Session::has('success-message')))
        <div class="alert alert-success col-md-12">{{
            Session::get('success-message') }}</div>
        @endif @if ((Session::has('fail-message')))
        <div class="alert alert-danger col-md-12">{{
            Session::get('fail-message') }}</div>
        @endif


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

        $(function() {
            var $form = $("#payment-form");
            $form.on('submit', function(e) {
                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }
            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        });
    </script>

    {!! HTML::script('/assets/plugins/parsley.min.js') !!}

    <script src='https://www.google.com/recaptcha/api.js'></script>

@stop