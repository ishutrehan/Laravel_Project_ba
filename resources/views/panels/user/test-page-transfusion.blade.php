<?php
	$options = array();
	if($result->data) {
		$options = unserialize(base64_decode($result->data));
	}
?>
@extends('layouts.main')
@section('pageTitle', 'Transfusion')
@section('content')
@include('partials.status-panel')
<div class="container">
	<div class="section_full_rw padding_tp-botm wp100">
		<div class="mcq_form wp100">
			{!! Form::open(['url' => route('user.transfusion-page'), 'id'=> 'essay-form','data-parsley-validate' ] ) !!}
				<div class="dev_row">
					<h3>Transfusion</h3>
					<!-- <label>Haemastasis and thrombosis </label> -->
					<span>Topic </span>
					<h4><?php echo base64_decode($result->qcase); ?></h4>
					<span>Information </span>
					<h4><?php echo base64_decode($result->information); ?></h4>	
					<hr>
					<?php $pos=1 ?>
					@foreach($options as $ky=>$opt)
						<div class="dev_row">
							<span>Question {{$pos}}</span>
							<h4><?php echo $opt[0]; ?></h4>
							<hr>
							<h4>Answer</h4>
							<div class="third_prt">
								<textarea cols="70" rows="8" name="ans[{{$ky}}][]"></textarea>
							</div>
						</div>										
						<?php $pos++ ?>
					@endforeach		


					<input type="hidden" name="index" value="{{$index}}">
					<input type="hidden" name="dt" value="{{$dt}}">
					<input type="hidden" name="qid" value="{{$result->id}}">
					<input type="hidden" name="ans_after" value="{{$ans_after}}">

				</div>
				<div class="dev_row">
					<input type="submit" name="submit" value="Submit answer">
					<input type="submit" name="skip" value="Skip Question">
					<!-- <input type="reset"  name="quit" value="Quit Test" class="right_btn"> -->
					<a class="a-btn" href="{{route('activated.protected')}}">Return to member home page</a>
				</div>
			{!! Form::close() !!}
		</div>		
	</div>
</div>
@stop