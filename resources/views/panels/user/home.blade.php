@extends('layouts.main')
@section('pageTitle', 'My Profile')
@section('head')
@stop
@section('content')
<?php
	$user = Auth::user();
	$todayDate = date('U');
	$expireDate = date('U', strtotime($user->expire_at));
?>

<div class="contant_part">	
	<div class="container">		
		<div class="section_full_rw padding_tp-botm wp100">
			<a class="btn_payent" href="{{route('user.payments')}}">Payment History</a>		
			@if ((Session::has('success-message')))
			<div class="alert alert-success col-md-12">{{
				Session::get('success-message') }}</div>
			@endif @if ((Session::has('fail-message')))
			<div class="alert alert-danger col-md-12">{{
				Session::get('fail-message') }}</div>
			@endif	
			<div class="myaccount_se">				
				<ul>
					<li><a href="#">My account <span style="float: right;">{{$user->first_name}}</span></a></li>
					<li><a href="#">Date joined <span style="float: right;">
							<?php
								echo date("d-M-Y", strtotime($user->created_at));
							?>
							</span></a></li>
					<li><div class="dv_btn">Your subscription expires on
						<span style="float: right;">
							<p>
							<?php
								echo date("d-M-Y", strtotime($user->expire_at));
							?>
							</p>
						<?php
						if($todayDate > $expireDate || $user->subscription == 0) { ?>
							<a class="btn btn-warning" href="{{route('user.subscribe')}}">Subscribe</a>
						<?php } ?>
						</span> </div></li>
					<li><a href="#">Email/Username<span style="float: right;">{{$user->email}}</span></a></li>
					<li><a href="{{route('user.edit-profile')}}" class="btn_payent">Edit Profile</a></li>
				</ul>				
			</div>
		</div>		
	</div>
</div>


@stop