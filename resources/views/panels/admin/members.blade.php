@extends('layouts.admin')

@section('head')

<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap-datepicker.min.js"></script>

@stop

@section('content')

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
</div> <!-- end .flash-message -->


<h2 class="membr_list">Members List</h2>

<a href="{{route('admin.add-user')}}" class="btn btn-primary ad_usr">Add User</a>



<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Sno.</th>
			<th>Name</th>
			<th>Email</th>
			<th>Country</th>
			<th>Amount</th>
			<th>Date joined</th>
			<th>Subscription Expire</th>
			<th>Action</th>
		</tr>
	</thead>
	@if (count($users))
		<tbody>
			@foreach ($users as $index => $user)
			    <tr>
			    	<td> {{ $index + 1 }} </td>
			    	<td> {{ $user->first_name }} </td>
			    	<td> {{ $user->email }} </td>
			    	<td> {{ $user->country_residence }} </td>
			    	<td> <?php print_r(unserialize($user->data)['amount']); ?> </td>
			    	<td> <?php echo date('d-m-Y', strtotime($user->created_at)); ?> </td>
			    	<td>
			    		<?php if(!empty($user->expire_at)) { echo date('d-m-Y', strtotime($user->expire_at)); }?> 
			    		@if(!empty($user->expire_at)) 
			    		<button type="button" class="btn btn-info btn-sm edit-sub" data-date="{{ $user->expire_at }}" data-id="{{$user->id}}" data-toggle="modal">Edit</button>
			    		@endif
			    	</td>
			    	<td>
			    		<a class="btn btn-primary btn-sm" href="{{route('admin.edit-user', ['id' => $user->id ])}}">Edit</a>
			    		<a class="btn btn-primary btn-sm" onclick="return confirm('Are you sure?')" href="{{route('admin.delete-user', ['id' => $user->id ])}}">Delete</a>
			    		<a class="btn btn-primary btn-sm" href="{{route('admin.tests', ['id' => $user->id ])}}">Tests</a>
			    	</td>
			    </tr>
			@endforeach
		</tbody>
	@endif
</table>
<div class="pagination"> {{ $users->links() }} </div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Manage Subscription</h4>
      </div>
      <div class="modal-body">
		{!! Form::open(['url' => url('admin/update-subs'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
		  <div class="form-group">
		    <label for="date">Expire Date:</label>
		    <input type="text" class="form-control datepicker" name="date" data-date-format="yyyy-mm-dd" data-provide="datepicker" id="user_date">
		    <input type="hidden" name="user_id" id="user_id">
		  </div>
		  <button type="submit" class="btn btn-default">Submit</button>
		{!! Form::close() !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@stop