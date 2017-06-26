@extends('layouts.admin')

@section('head')

@stop

@section('content')

@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif

{!! Form::open(['url' => route('admin.update-pages'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
	<div class="form-group">
		<label for="question">Home Page:</label>
		<textarea class="form-control" name="home1"><?php if(isset($results[0]->home_page)) { echo base64_decode($results[0]->home_page); } ?></textarea>
	</div>
	<div class="form-group">
		<label for="question">Home Page About Section:</label>
		<textarea class="form-control" name="home2"><?php if(isset($results[0]->home_page_about)) { echo base64_decode($results[0]->home_page_about); } ?></textarea>
	</div>
	<div class="form-group">
		<label for="question">About Page:</label>
		<textarea class="form-control" name="about-us"><?php if(isset($results[0]->about_us)) { echo base64_decode($results[0]->about_us); } ?></textarea>
	</div>
	<div class="form-group">
		<label for="question">Terms Use Page:</label>
		<textarea class="form-control" name="terms-use"><?php if(isset($results[0]->terms_use)) { echo base64_decode($results[0]->terms_use); } ?></textarea>
	</div>
	<button name="sub" type="submit" class="btn btn-primary">Submit</button>
{!! Form::close() !!}
@stop