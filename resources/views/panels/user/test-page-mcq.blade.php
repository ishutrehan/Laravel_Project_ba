<?php
	$options = array();
	if($result->data) {
		$options = unserialize(base64_decode($result->data));
	}
?>
@extends('layouts.main')

@section('pageTitle', 'MCQs, EMQs')

@section('content')
@include('partials.status-panel')
<div class="container">
<div class="section_full_rw padding_tp-botm wp100">
	<div class="mcq_form wp100">
		
		{!! Form::open(['url' => route('user.mcq-ques-page'), 'id'=> 'test_mcq_each', 'data-parsley-validate' ] ) !!}
			<div class="fourth_part">
				<div class="stati_stics">
					<h3> Answer statistics of test</h3>
					<h4>Score –
						<span id="pers"></span>%
					</h4>
					<!-- <h4>Score – Bar chart Correct/Incorrect<br><span>% correct</span></h4> -->
					<div id="canvas-holder" style="width:70%;margin: auto;">
				        <canvas id="chart-area" />
				    </div>
				</div>
				<div class="stati_stics">
					<ul id="notes">
						@if(count($result->notes))
							@foreach($result->notes as $note)
								<li>
									
									<a href="{{ asset('uploads/notes') }}/{{$note->uid}}.txt"><?php echo substr($note->revision,  0, 20); ?> - {{$note->id}}</a>
								</li>
							@endforeach
						@endif
					</ul>
				</div>
				<div class="stati_stics">
					<h3>Notepad</h3>
					<textarea name="revision" cols="50" rows="8" id="txt_notes"></textarea>
					<button type="button" id="save_note">Save revision notes</button>
					<!-- <h4>Save revision notes</h4> -->
				</div>				
				<div class="stati_sstics">					
					<span><a class="a-btn" href="{{route('activated.protected')}}">Return to member home page</a></span>
				</div>				
			</div>
			<div class="sixth_part">
				<div class="dev_row">
					<label>Question {{$index + 1}} of {{ session('total_ques') }}</label>
					@if($result->type == 'single')
						<span>EMQ</span>
					@else
						<span>MCQ</span>
					@endif	
				</div>				
				<div class="dev_row">
					<h4><?php echo base64_decode($result->question); ?></h4>
					@if($result->type == 'single')
						<?php
							$x = 1;
							foreach ($options as $key2 => $option) {
								echo "<h4>".$x.'. '.$option[0]."<h4>";
								echo "<select name='que_ans[".$key2."]'><option value=''>Choose from one of the following answers</option>";								
								foreach ($option as $key => $opt) {
									if (gettype($opt) == 'array') {
										echo "<option value='".$key."'>".$opt[1]."</option>";
									}
								}
								echo "</select>";
								echo "<span class='ans' data-id='".$key2."'></span>";
								$x++;
							}
						?>
					@else
						@foreach($options as $key=>$option)
							@if(!empty($option[0]))	
								<div class="chek_ba">
									<input type="radio" name="que_ans[]" value="{{$key}}">
									<span><?php
										echo $option[0];
									?></span>
									<span class='ans' data-id="{{$key}}"></span>	
								</div>
							@endif
						@endforeach
					@endif
				</div>				
				<div class="dev_row">
					<input type="hidden" name="questype" value="{{$questype}}">
					<input type="hidden" name="qtype" id="qtype" value="{{$result->type}}">

					@if($showans == 'ans_each')
						<input type="button" name="submit" id="current" value="Submit answer">
					@else
						<input type="submit" name="submit" value="Submit answer">
					@endif
					<input type="submit" name="next" id="next" style="display: none;" value="Next Question">
					<input type="submit" name="skip" value="Skip question">
				</div>
				<hr>
				<div class="dev_row">
					<span class="discussion" style="display: none;">
						<h4>Discussion</h4>
						<?php
							echo base64_decode($result->discussion);
						?>
					</span>
					<br>
					<hr>
					@if(!empty($result->reference))
					<span class="discussion" style="display: none;">
						<h4>Reference</h4>
						<?php
							echo base64_decode($result->reference);
						?>
					</span>
					@endif
				</div>
			</div>
			
			<input type="hidden" name="dt" id="dt" value="{{$dt}}">	
			<input type="hidden" name="index" value="{{$index}}">
			@if($result->type == 'single')
				<input type="hidden" name="questype" value="emqs">	
			@else
				<input type="hidden" name="questype" value="mcqs">
			@endif	
			<input type="hidden" name="qid" id="qid" value="{{$result->id}}">	
			<input type="hidden" name="showans" value="{{$showans}}">	
		{!! Form::close() !!}
	</div>
	</div>
	
</div>
<script>
var randomScalingFactor = function() {
    return Math.round(Math.random() * 100);
};
var tot = "{{session('total_ques')}}";

var crr = (localStorage.getItem("correct") == null) ? 0 : localStorage.getItem("correct");
var incrr = (localStorage.getItem("incorrect") == null) ? 0 : localStorage.getItem("incorrect");

var config = {
    type: 'pie',
    data: {
        datasets: [{
            data: [
                crr,
                incrr,
            ],
            backgroundColor: [
                window.chartColors.red,
                window.chartColors.orange,
            ],
            borderColor: [
                'rgba(255,99,132,1)'
            ],
            label: 'MCQ-EMQ',
        }],
        labels: [
            "Correct",
            "Incorrect"
        ]
    },
    options: {
    	legend: { labels: { fontColor:"gray", fontSize: 12 }},
        responsive: true,
        showLines: false
    }
};

window.onload = function() {
	
    var ctx = document.getElementById("chart-area").getContext("2d");
    var per = (localStorage.getItem("perc") == null) ? 0 : localStorage.getItem("perc");
    document.getElementById("pers").innerText = parseFloat(per).toFixed(2);
    window.myPie = new Chart(ctx, config);
};

</script>

@stop