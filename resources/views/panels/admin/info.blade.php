@extends('layouts.admin')

@section('head')

@stop

@section('content')

@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif

{!! Form::open(['url' => route('admin.update-info'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
	<div class="form-group">
		<label for="question">MCQs, EMQs:</label>
		<textarea class="form-control" name="mcq_emq"><?php if(isset($results[0]->mcq_emq)) { echo base64_decode($results[0]->mcq_emq); } ?></textarea>
	</div>
	<div class="form-group">
		<label for="question">Essay questions:</label>
		<textarea class="form-control" name="essay"><?php if(isset($results[0]->essay)) { echo base64_decode($results[0]->essay); } ?></textarea>
	</div>
	<div class="form-group">
		<label for="question">Morphology:</label>
		<textarea class="form-control" name="morphology"><?php if(isset($results[0]->morphology)) { echo base64_decode($results[0]->morphology); } ?></textarea>
	</div>
	<div class="form-group">
		<label for="question">Quality assurance:</label>
		<textarea class="form-control" name="quality_assurance"><?php if(isset($results[0]->quality_assurance)) { echo base64_decode($results[0]->quality_assurance); } ?></textarea>
	</div>
	<div class="form-group">
		<label for="question">Transfusion:</label>
		<textarea class="form-control" name="transfusion"><?php if(isset($results[0]->transfusion)) { echo base64_decode($results[0]->transfusion); } ?></textarea>
	</div>
	<button name="sub" type="submit" class="btn btn-primary">Submit</button>
{!! Form::close() !!}
@stop