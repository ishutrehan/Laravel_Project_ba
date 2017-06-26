@extends('layouts.main')
@section('pageTitle', 'MCQs, EMQs')

@section('content')
@include('partials.status-panel')
<div class="container">
<div class="section_full_rw padding_tp-botm wp100">
	<div class="mcq_form wp100">
		<h3>Result page</h3>
			<hr>
			<?php

				if(count($results)) {				
					$total = session('total_ques');
					$tot_right = 0;
					$skip = 0;
					$wrong_arr = array();
					foreach ($results as $key => $result) {
						$right = 0;
						$qid = 0;
						$wrong = 0;
						foreach ($result as $key => $val) {
							if($val['value'] == 'yes') {
								$right = 1;
							}
							if($val['value'] == 'no') {
								$wrong++;
							}
							$qid = $val['qid'];
						}
						if(count($result) === $wrong) {
							array_push($wrong_arr, $qid);
						}
						$skip = $total - count($results);	
						$tot_right = $tot_right + $right;
					}

					?>
					<table>
						<tr>
							<td><b>Total Questions</b></td>
							<td>{{$total}}</td>
						</tr>
						<tr>
							<td><b>Correct Answers</b></td>
							<td>{{$tot_right}}</td>
						</tr>
						<tr>
							<td><b>Incorrect Answers</b></td>
							<td>{{$total - $tot_right - $skip}}</td>
						</tr>
						<tr>
							<td><b>Skipped Answers</b></td>
							<td>{{$skip}}</td>
						</tr>
						<tr>
							<td><b>Percentage</b></td>
							<td>{{$tot_right * 100 / $total}} %</td>
						</tr>
						<tr>
							<td><a class="a-btn rgt-btn" href="{{route('subscription.exam-mcq-emq-opt')}}">Return to MCQ/EMQ</a></td>
							<td><a class="a-btn rgt-btn" href="{{route('activated.protected')}}">Return to Member Page</a></td>
							<td><a class="a-btn rgt-btn" id="showans" href="javascript:void(0)">Review the incorrect questions</a></td>
						</tr>
					
					</table>
				<div id="inc_ans" style="display: none;">
				<hr>
				<h3 class="in_cortQ">Incorrect Questions</h3>					
				<?php
					if (count($wrong_arr)) {
						for ($i=0; $i < count($wrong_arr) ; $i++) { 
							foreach ($tests as $key => $test) {
								if ($test->id == $wrong_arr[$i]) {
									echo '<div class="dev_row"><h4>'.base64_decode($test->question).'</h4>';
									$ques = unserialize(base64_decode($test->data));				
									$x = 1;
									foreach ($ques as $key => $value) {
										echo "<div class='chek_ba'><span>".$x.") ".$ques[$key][0]."";
										if(isset($ques[$key][1]) && $ques[$key][1] == 'on'){
											echo "<b style='color:green;margin-left:10px;'>CORRECT</b>";
										}
										echo "</span></div>";
										$x++;
									}									
									echo "</div>";
								}
							}							
						}
					}
					?>
				</div>
				<?php
				}
			?>		
	</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#showans").on('click', function(event) {
           $("#inc_ans").show();
		});
	});
</script>
@stop