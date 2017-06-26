

@extends('layouts.main')

@section('pageTitle', 'Transfusion')

@section('content')

@include('partials.status-panel')

<div class="container">

<div class="section_full_rw padding_tp-botm wp100">

	<div class="mcq_form wp100">

		<h3>Thank you</h3>
		<span><a class="a-btn" href="{{route('activated.protected')}}">Return to member home page</a></span>
	

		<!-- <pre> -->

			<?php

				// print_r($results);

				// if(count($results)){

				// 	$total = session('total_ques');

				// 	foreach ($results as $key => $result) {

				// 		foreach ($result as $key => $val) {

							

				// 		}

				// 	}

				// }

			?>		

		<!-- </pre> -->

	</div>

	</div>

</div>

@stop