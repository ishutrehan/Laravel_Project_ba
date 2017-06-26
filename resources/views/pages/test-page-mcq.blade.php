@extends('layouts.main')
@section('content')
@include('partials.status-panel')
<div class="container">
	<div class="section_full_rw padding_tp-botm wp100">
		<div class="mcq_form wp100">
			<form>
				
				<div class="sixth_part">
					<div class="dev_row">
						<label>Question 1 of ?</label>
						<span>Either MCQ or EMQ</span>
					</div>
					
					<div class="dev_row">
						<h4>What bone marrow cellularity would you expect from a 90 year old</h4>
						<div class="chek_ba"><span>1.10%</span><input type="checkbox"></div>
						<div class="chek_ba"><span>2.50%%</span><input type="checkbox"></div>
						<div class="chek_ba"><span>3.100%</span><input type="checkbox"></div>
						<div class="chek_ba"><span>4.70%</span><input type="checkbox"></div>
						<div class="chek_ba"><span>5.60%</span><input type="checkbox"></div>
					</div>
					
					<div class="dev_row">
						<input type="submit" name="" value="Submit answer">
						<input type="reset" name="" value="Skip question">
					</div>
					
					
					
				</div>
				<div class="fourth_part">
					
					<div class="stati_stics">
						<h3> Answer statistics of test</h3>
						<h4>Score – 	Bar chart Correct/Incorrect<br><span>% correct</span></h4>
					</div>
					
					
					<div class="stati_stics">
						<h3>Notepad</h3>
						<input type="text" name="" value="">
						<h4>Save revision notes</h4>
					</div>
					
					
					<div class="stati_stics">
						<h3>Quit test </h3>
						<span>(return to membership dashboard)</span>
					</div>
					
					
				</div>
				
				
				
			</form>
		</div>
		
	</div>
</div>
@stop