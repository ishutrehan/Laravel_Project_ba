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
			{!! Form::open(['url' => route('user.transfusion-page-next'), 'id'=> 'essay-form','data-parsley-validate' ] ) !!}
				<div class="dev_row">
					<h3>Transfusion</h3>
					<span>Case</span>

					<h4><?php echo base64_decode($result->qcase);?></h4>	
					<span>Information</span>
					<h4><?php echo base64_decode($result->information);?></h4>	
					<hr>

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
								<div class="textarea_div">
									<?php echo $ans[$ky][0]; ?>
								</div>
							</td>
							<td>
								<h4>model answer</h4><br>
								<div class="textarea_div">
									<?php echo $opt[1]; ?>
								</div>
							</tr>
							@endforeach
						</table>
						<h4>Discussion</h4>
						<div class="input_div">
						<?php echo base64_decode($result->discussion); ?></div>
						@if(!empty($result->reference))
						<h4>Reference</h4>
						<div class="input_div">
						<?php echo base64_decode($result->reference); ?></div>
						@endif
					</div>		

					<input type="hidden" name="index" value="{{$index + 1}}">
					<input type="hidden" name="dt" value="{{$dt}}">
					<input type="hidden" name="qid" value="{{$result->id}}">
					<input type="hidden" name="ans_after" value="{{$ans_after}}">
				
				<div class="dev_row">									
					<input type="submit" name="sub" value="Next question">
					<!-- <input type="reset"  name="" value="Quit test" class="right_btn"> -->
					<a class="a-btn" href="{{route('activated.protected')}}">Return to member home page</a>
				</div>

				</div>
			{!! Form::close() !!}
		</div>		
	</div>
</div>
@stop