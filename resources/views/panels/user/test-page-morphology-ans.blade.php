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
			<div class="texansr_q">
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
				<table class="tal_loop">
					@foreach($options as $ky=>$opt)
					<tr>
						<td>
						<h4>{{$loop->index + 1}}) <?php echo $opt[0]; ?></h4></td>
						<td colspan="0"></td>
					</tr>
					<tr>
						<td>
							<h4>Answer</h4><br>
							<!-- <textarea rows="6" cols="55" readonly><?php echo $ans[$ky][0]; ?></textarea> -->
							<div class="textarea_div"><?php echo $ans[$ky][0]; ?></div>
						</td>
						<td>
							<h4 style="color: green">Model Answer</h4><br>
							<div class="textarea_div"><?php echo $opt[1]; ?></div>
							<!-- <textarea rows="6" cols="55" readonly></textarea> -->
						</td>
					</tr>
						@endforeach
					</table>
					<h4>Discussion</h4>
					<div class="input_div"><?php echo base64_decode($result->discussion);?> </div>
					<h4>References</h4>
					<div class="input_div"><?php echo base64_decode($result->reference); ?></div>						
				</div>			
				
				{!! Form::open(['url' => route('user.morphology-ques-page-next'), 'id'=> 'test_mcq_each', 'data-parsley-validate' ] ) !!}
				<div class="dev_row">					
					<input type="hidden" name="dt" value="{{$dt}}">
					<input type="hidden" name="index" value="{{$index + 1}}">
					<input type="hidden" name="q_type" value="{{$q_type}}">
					<input type="hidden" name="qid" value="{{$result->id}}">
					<input type="hidden" name="ans_after" value="{{$ans_after}}">
					<input type="submit" name="sub" value="Next question">
					<!-- <input type="reset" name="skip" value="Quit text" class="rgt_dev"> -->
					
					<span><a class="a-btn" href="{{route('activated.protected')}}">Return to member home page</a></span>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	@stop