<?php
	$options = array();
	if($result->data) {
		$options = unserialize(base64_decode($result->data));
	}
?>
@extends('layouts.main')

@section('pageTitle', 'Morphology')

@section('content')
@include('partials.status-panel')
<div class="container">
	<div class="section_full_rw padding_tp-botm wp100">
		<div class="mcq_form wp100">
			{!! Form::open(['url' => route('user.morphology-ques-page'), 'id'=> 'test_mcq_each', 'data-parsley-validate' ] ) !!}		
				<div class="sixth_part">
					<div class="dev_row">
						<label>
						@if($q_type == 'short-long')
						<span>Either Short or Long cases</span>
						@endif
						@if($q_type == 'short-cases')
							<span>Short cases</span>
						@endif
						@if($q_type == 'long-cases')
							<span>Long cases</span>
						@endif
						</label>
						<span>Information</span>
						<p><?php echo base64_decode($result->information); ?></p>
					</div>					
					<div class="dev_row">
						<div class="slide_tav">
							<a href="{{ asset('uploads/morphology') }}/{{$result->slide}}" target="_blank">
								<img src="{{ asset('uploads/morphology') }}/{{$result->slide}}" alt=""/>
							</a>
						</div>
					</div>					
					<div class="dev_row">						
						<input type="hidden" name="dt" value="{{$dt}}">	
						<input type="hidden" name="index" value="{{$index}}">	
						<input type="hidden" name="q_type" value="{{$q_type}}">	
						<input type="hidden" name="qid" value="{{$result->id}}">	
						<input type="hidden" name="ans_after" value="{{$ans_after}}">	
						<input type="submit" name="submit" value="Submit answer">
						<input type="submit" name="skip" value="Skip question">
					</div>	
				</div>
				<div class="fourth_part">
					@foreach($options as $ky=>$opt)					
						<div class="Ques_tion">
							<h4><?php echo $opt[0]; ?></h4>
							<hr>
							<h4>Answer</h4>
							<textarea rows="6" cols="55" name="ans[{{$ky}}][]"></textarea>
						</div>	
					@endforeach								
					<div class="stati_stic">
						<a class="a-btn" href="{{route('activated.protected')}}">Return to member home page</a>
					</div>					
				</div>
			</form>
		</div>		
	</div>
</div>
@stop