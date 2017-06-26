@extends('layouts.main')
@section('pageTitle', 'Edit Profile')
@section('head')
    {!! HTML::style('/assets/css/register.css') !!}
    {!! HTML::style('/assets/css/parsley.css') !!}
@stop

@section('content')
        
<div class="container"> 
        @include('includes.status')


        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
              @if(Session::has('alert-' . $msg))

              <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
              @endif
            @endforeach
        </div> <!-- end .flash-message -->


        <form accept-charset="UTF-8" action="{{route('user.update-user')}}" class="require-validation form-signin" data-cc-on-file="false" id="payment-form" method="post">
        {{ csrf_field() }}
        @include('includes.errors')
            <h4 class="form-signin-heading">Update User</h4>

            <label for="inputEmail" class="sr-only2">Email/Username*</label>
            {!! Form::email('email', $user->username, [
                'class'                         => 'form-control',
                'placeholder'                   => '',
                'required',
                'id'                            => 'inputEmail',
                'data-parsley-required-message' => 'Email address is required',
                'data-parsley-trigger'          => 'change focusout',
                'data-parsley-type'             => 'email'
            ]) !!}
            <button class="btn btn-lg btn-primary btn-block register-btn" type="submit">Update</button>
        </form>

        <form accept-charset="UTF-8" action="{{route('user.update-user-pass')}}" class="require-validation form-signin" data-cc-on-file="false" id="payment-form" method="post">
            {{ csrf_field() }}
            
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

            <button class="btn btn-lg btn-primary btn-block register-btn" type="submit">Update</button>
        </form>
        


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
            $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert-success").slideUp(500);
            });

            $(".danger").fadeTo(2000, 500).slideUp(500, function() {
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
    </script>

    {!! HTML::script('/assets/plugins/parsley.min.js') !!}

    <script src='https://www.google.com/recaptcha/api.js'></script>

@stop