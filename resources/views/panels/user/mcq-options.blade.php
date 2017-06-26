@extends('layouts.main')
@section('pageTitle', 'MCQs, EMQs - Options')

@section('head')
@stop
@section('content')
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
      			{!! Form::open(['url' => route('user.get-mcq-ques'), 'data-parsley-validate' ] ) !!}
				<div class="dev_row">
					<label>Question type</label>
					<div class="third_prt"><span>MCQs</span><input type="radio" name="ques-type" value="mcqs"></div>
					<div class="third_prt"><span>EMQs</span><input type="radio" name="ques-type" value="emqs"></div>
					<div class="third_prt"><span>MCQs and EMQs</span><input type="radio" checked name="ques-type" value="mcqs-emqs"></div>
				</div>				
				<div class="dev_row">
					<label>Question type</label>
					<div class="third_prt"><span>Seen before </span><input checked type="radio" name="ques-seen" value="old"></div>
					<div class="third_prt"><span>Not seen before </span><input type="radio" name="ques-seen" value="new"></div>
				</div>						
				<div class="dev_row">
					<label>Number of questions</label>
					<div class="third_prt">
						<select name="questions">
							<option value="">-Select Options-</option>
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
					<label>Subject</label>					
					<div class="third_prt"><span><b>Select all</b></span><input type="checkbox" id="check_all"></div>
					<div class="third_prt"><span>General haematology</span><input type="checkbox" class="subject" name="subject[]" value="general-haematology"></div>
					<div class="third_prt"><span>Transfusion</span><input type="checkbox" class="subject" name="subject[]" value="transfusion"></div>
					<div class="third_prt"><span>Haemato-oncology</span><input type="checkbox" class="subject" name="subject[]" value="haemato-oncology"></div>
					<div class="third_prt"><span>Haemastasis and thrombosis</span><input type="checkbox" class="subject" name="subject[]" value="haemastasis-thrombosis"></div>
				</div>				
				<div class="dev_row">
					<label>Show answers after</label>
					<div class="third_prt"><span>Every question </span><input checked type="radio"  name="show-ans" value="ans_each"></div>
					<div class="third_prt"><span>At end of exam  </span><input type="radio"  name="show-ans" value="ans_end"></div>
				</div>
				<div class="dev_row">
					<input type="submit" name="" value="Let’s go">
				</div>
			{!! Form::close() !!}
      		</div>
      		<div id="information" class="tabcontent info-tab">
        	 <p><?php echo base64_decode($mcq_emq); ?></p> 
      		</div>
			
		</div>
	</div>
</div>
<script type="text/javascript">
	localStorage.removeItem('correct');
    localStorage.removeItem('incorrect');
    localStorage.removeItem('perc');
</script>
@stop