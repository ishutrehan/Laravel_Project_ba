@extends('layouts.main')
@section('pageTitle', 'Morphology -Options')
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
			      	{!! Form::open(['url' => route('user.get-morphology-ques'), 'data-parsley-validate' ] ) !!}
						<div class="dev_row">
							<label>Question type</label>
							<div class="third_prt"><span>Short cases </span><input type="radio" name="q_type" value="short-cases"></div>
							<div class="third_prt"><span>Long cases</span><input type="radio" name="q_type" value="long-cases"></div>
							<div class="third_prt"><span>Short and long cases</span><input type="radio" name="q_type" value="short-long"></div>
							
						</div>				
						<div class="dev_row">
							<label>Questions I have</label>
							<div class="third_prt"><span>Seen before </span><input type="radio" name="q_seen" value="seen"></div>
							<div class="third_prt"><span>Not seen before </span><input type="radio" name="q_seen" value="not_seen"></div>		
						</div>	
						<div class="dev_row">
							<label>Number of questions</label>
							<div class="third_prt">
								<select name="no_ques">
									<option value="0">-Select Options-</option>
									<option value="10">10</option>
									<option value="20">20</option>
									<option value="30">30</option>
									<option value="40">40</option>
									<option value="50">50</option>
									<option value="all">All</option>
								</select>
							</div>
					</div>		
					<div class="dev_row">
						<label>Show answers after</label>
						<div class="third_prt"><span>Every question </span><input type="radio" name="ans_after" value="each"></div>
						<div class="third_prt"><span>At end of exam  </span><input type="radio" name="ans_after" value="end"></div>
					</div>			
					<div class="dev_row">
						<input type="submit" name="sub" value="Let’s go">
					</div>
					{!! Form::close() !!}
			    </div>

				<div id="information" class="tabcontent  info-tab">

					<p><?php echo base64_decode($morphology); ?></p>
				</div>
				
		</div>
		
	</div>
</div>
@stop