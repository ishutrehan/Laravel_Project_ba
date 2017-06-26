@extends('layouts.main')
@section('pageTitle', 'Essay')
@section('content')
@include('partials.status-panel')
<div class="container">
	<div class="section_full_rw padding_tp-botm wp100">
		<div class="mcq_form wp100">
			{!! Form::open(['url' => route('user.essay-ques-page'), 'id'=> 'essay-form','data-parsley-validate' ] ) !!}
				<div class="dev_row">
					<h3>Essays</h3>
					<!-- <label>Haemastasis and thrombosis </label> -->
					<span>Topic </span>
					<h4><?php echo  base64_decode($result->topic); ?></h4>	
					<hr>
					<span>Question </span>
					<h4><?php echo  base64_decode($result->question); ?></h4>
					<hr>
					<h4>Answer</h4>
					<div class="third_prt">
						<textarea required cols="70" rows="8" name="answer"></textarea>
						<input type="hidden" name="index" value="{{$index}}">
						<input type="hidden" name="dt" value="{{$dt}}">
						<input type="hidden" name="qid" value="{{$result->id}}">
					</div>
				</div>
				<div class="dev_row">
					<input type="submit" name="submit" value="Submit answer">
					<!-- <input type="reset"  name="" value="Return to essays" class="right_btn"> -->
					<a class="a-btn" href="{{route('activated.protected')}}">Return to member home page</a>
				</div>
			{!! Form::close() !!}
		</div>		
	</div>
</div>
@stop