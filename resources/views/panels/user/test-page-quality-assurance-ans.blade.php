<?php
	$options = array();
	if($result->data) {
		$options = unserialize(base64_decode($result->data));
	}
?>
@extends('layouts.main')
@section('pageTitle', 'Laboratory quality assurance')
@section('content')
@include('partials.status-panel')
<div class="container">
	<div class="section_full_rw padding_tp-botm wp100">
		<div class="mcq_form wp100">
			{!! Form::open(['url' => route('user.quality-assurance-page'), 'id'=> 'essay-form','data-parsley-validate' ] ) !!}
				<div class="dev_row">
					<h3>Quality Assurance</h3>
					<span>Topic </span>
					<h4><?php echo base64_decode($result->topic); ?></h4>	
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
								<div class="textarea_div"><?php echo $ans[$ky][0]; ?></div>
							</td>
							<td>
								<h4>model answer</h4><br>
								<div class="textarea_div"><?php echo $opt[1]; ?></div>
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

					<input type="hidden" name="index" value="{{$index}}">
					<input type="hidden" name="dt" value="{{$dt}}">
					<input type="hidden" name="qid" value="{{$result->id}}">
				
				<div class="dev_row">					
					<!-- <input type="reset"  name="" value="Return to Quality Assurance" class="right_btn"> -->
					<a class="a-btn" href="{{route('activated.protected')}}">Return to member home page</a>
				</div>

				</div>
			{!! Form::close() !!}
		</div>		
	</div>
</div>
@stop