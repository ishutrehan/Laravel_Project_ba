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
					<h4>Topic </h4>
					<span><?php echo base64_decode($result->topic);?></h4>	
				
					<hr>
					<h4>Question </h4>
					<span><?php echo base64_decode($result->question);?></span>
					<hr>
					
					<div class="third_prt full_rw50"> <h4>Answer</h4>
						<div class="textarea_div"><?php echo  $answer; ?></div>
						<input type="hidden" name="index" value="{{$index}}">
						<input type="hidden" name="dt" value="{{$dt}}">
						<input type="hidden" name="qid" value="{{$result->id}}">
					</div>
					
					<div class="third_prt full_rw50">
					<h4>Model answer plan</h4>
						<div class="textarea_div"><?php echo base64_decode($result->answer);?></div>
					</div>
					<div class="third_prt1 full_rw_100">
					<div>
						
						<h4>Discussion</h4>
						<div class="input_div"><?php echo base64_decode($result->discussion);?></div>
					</div>
					<hr>
					<div>
						@if(!empty($result->reference))
						<h4>Reference</h4>
						<div class="input_div"><?php echo base64_decode($result->reference);?></div>
						@endif
					</div>
					</div>
				</div>
				<div class="dev_row">
					<!-- <input type="submit" name="submit" value="Submit answer"> -->
					<!-- <input type="reset"  name="" value="Return to essays" class="right_btn"> -->
					<a class="a-btn" href="{{route('activated.protected')}}">Return to member home page</a>
				</div>
			{!! Form::close() !!}
		</div>		
	</div>
</div>
@stop