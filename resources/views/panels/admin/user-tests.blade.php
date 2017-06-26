@extends('layouts.admin')

@section('head')

@stop

@section('content')

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))
      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
</div> <!-- end .flash-message -->


<h2 class="membr_list">Tests List</h2>

<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Sno.</th>
			<th>Type</th>
			<th>Question Type</th>
			<th>Subject</th>
			<th>Date</th>
		</tr>
	</thead>
	@if (count($results))
		<tbody>
			@foreach ($results as $index => $result)
			    <tr>
			    	<td> {{ $index + 1 }} </td>
			    	<td> {{ $result->type }} </td>
			    	<td> {{ $result->qtype }} </td>
			    	<td> {{ $result->subject }} </td>
			    	<td> 
						<?php echo date('d-m-Y', strtotime($result->created_at)); ?>
			    	</td>
			    	
			    </tr>
			@endforeach
		</tbody>
	@endif
</table>
<div class="pagination"> {{ $results->links() }} </div>
<!-- Modal -->

@stop