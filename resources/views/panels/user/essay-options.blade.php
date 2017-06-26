@extends('layouts.main')
@section('pageTitle', 'Essay Options')
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
		</div> <!-- end .flash-message -->
		<div class="mcq_form wp100">
		      <div class="tab">
		        <button class="tablinks" onclick="openCity(event, 'questions')" id="defaultOpen">Questions</button>
		        <button class="tablinks" onclick="openCity(event, 'information')">Information</button>
		      </div>
		      <div id="questions" class="tabcontent">
		      	{!! Form::open(['url' => route('user.get-essay-ques'), 'data-parsley-validate' ] ) !!}
				<div class="dev_row">
					<h3>Essays</h3>
					<label>General haematology </label>
					<table class="table_wide">
						@if(count($general))
							<?php $x = 1; ?>
							@foreach($general as $gen)
								<tr>
									<td><span>{{$x}}) <?php echo base64_decode($gen->question); ?></span><input type="radio" class="chk" name="general-haematology" value="{{$gen->id}}"></td>
								</tr>
							<?php $x++; ?>
							@endforeach
						@endif
					</table>
				</div>
				<div class="dev_row">
					<label>Transfusion </label>
					<table class="table_wide">
						@if(count($transfusion))
							<?php $x1 = 1; ?>
							@foreach($transfusion as $ten)
								<tr>
									<td><span>{{$x1}}) <?php echo base64_decode($gen->question); ?></span><input type="radio" class="chk" name="transfusion" value="{{$ten->id}}"></td>
								</tr>
								<?php $x1++; ?>
							@endforeach
						@endif
					</table>
				</div>
				<div class="dev_row">
					<label>Haemato-oncology </label>
					<table class="table_wide">
						@if(count($haemato))
							<?php $x2 = 1; ?>
							@foreach($haemato as $hae)
								<tr>
									<td><span>{{$x2}}) <?php echo base64_decode($gen->question); ?></span><input type="radio" class="chk" name="haemato-oncology" value="{{$hae->id}}"></td>
								</tr>
								<?php $x2++; ?>
							@endforeach
						@endif			
					</table>
				</div>
				<div class="dev_row">
					<label>Haemastasis and thrombosis </label>
					<table class="table_wide">
						@if(count($haemastasis))
							@foreach($haemastasis as $hae)
								<tr>
									<td><span><?php echo base64_decode($gen->question); ?></span><input type="radio" class="chk" name="haemastasis-thrombosis" value="{{$hae->id}}"></td>
								</tr>
							@endforeach
						@endif	
					</table>
				</div>
				<div class="dev_row">
					<input type="submit" name="" value="Go to Essay">
				</div>
			{!! Form::close() !!}
		      </div>

		      <div id="information" class="tabcontent info-tab">
		        <?php echo base64_decode($essay); ?>
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