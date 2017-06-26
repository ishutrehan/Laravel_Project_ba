@extends('layouts.main')
@section('pageTitle', 'Get Username')
@section('head')
    {!! HTML::style('/assets/css/reset.css') !!}
@stop

@section('content')
	<div class="container">
		<div class="flash-message">
	    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
	      @if(Session::has('alert-' . $msg))

	      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
	      @endif
	    @endforeach
	</div> <!-- end .flash-message -->

        {!! Form::open(['url' => url('/resetusername'), 'class' => 'form-signin' ] ) !!}

        @include('includes.status')

        <h2 class="form-signin-heading">Get Username</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email address', 'required', 'autofocus', 'id' => 'inputEmail' ]) !!}

        <br />
        <button class="btn btn-lg btn-primary btn-block" type="submit">Send me Username</button>

        {!! Form::close() !!}
	</div>
@stop