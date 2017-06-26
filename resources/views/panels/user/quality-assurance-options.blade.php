@extends('layouts.main')
@section('pageTitle', 'Laboratory quality assurance -Options')
@section('content')
@include('partials.status-panel')

<div class="container">
	<div class="section_full_rw padding_tp-botm wp100">
		<div class="flash-message">
			@foreach (['danger', 'warning', 'success', 'info'] as $msg)
			@if(Session::has('alert-' . $msg))
				<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
			@endif
			@endforeach
		</div>
		<div class="mcq_form wp100">
		    <div class="tab">
		        <button class="tablinks" onclick="openCity(event, 'questions')" id="defaultOpen">Questions</button>
		        <button class="tablinks" onclick="openCity(event, 'information')">Information</button>
		    </div>
		    <div id="questions" class="tabcontent">
		      	{!! Form::open(['url' => route('user.get-quality-assurance-ques'), 'data-parsley-validate' ] ) !!}
				<div class="dev_row">
					<h3>Quality assurance questions</h3>
					<label>General haematology </label>
					<table class="table_wide">
						<tr>
							@if(count($general))
								@foreach($general as $gen)
									<tr>
										<td><span><?php echo base64_decode($gen->topic);?></span><input type="radio" class="chk" name="general-haematology" value="{{$gen->id}}"></td>
									</tr>
								@endforeach
							@endif
						</tr>
					</table>
				</div>
				
				
				<div class="dev_row">
					<label>Transfusion  </label>
					<table class="table_wide">
						<tr>
							@if(count($transfusion))
								@foreach($transfusion as $ten)
									<tr>
										<td><span><?php echo base64_decode($ten->topic);?></span><input type="radio" class="chk" name="transfusion" value="{{$ten->id}}"></td>
									</tr>
								@endforeach
							@endif
						</tr>
					</table>
				</div>
				
				<div class="dev_row">
					<label>Haemastasis and thrombosis</label>
					<table class="table_wide">
						<tr>
							@if(count($haemastasis))
								@foreach($haemastasis as $hae)
									<tr>
										<td><span><?php echo base64_decode($hae->topic);?></span><input type="radio" class="chk" name="haemastasis-thrombosis" value="{{$hae->id}}"></td>
									</tr>
								@endforeach
							@endif	
						</tr>
					</table>
				</div>
				<div class="dev_row">
					<input type="submit" name="" value="Go to Question">
				</div>
				{!! Form::close() !!}
		    </div>

		    <div id="information" class="tabcontent  info-tab">
		        <p><?php echo base64_decode($quality_assurance); ?></p>
		    </div>
			
		</div>
		
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('click', '.chk', function(event) {
			$('.chk').prop('checked', false);
			$(this).prop('checked', true);
		});
	});
</script>
@stop