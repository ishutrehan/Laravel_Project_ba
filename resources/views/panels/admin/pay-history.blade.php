@extends('layouts.admin')

@section('head')

@stop

@section('content')

<h3>Payment History Listing</h3>

<div class="rows">
  {!! Form::open(['url' => url('admin/filter-payment'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
    <div class="row">
      <span class="col-md-3">
        <input type="text" name="dt-from" required class="datepicker form-control " placeholder="From" value="<?php if(isset($_POST['dt-from'])) { echo $_POST['dt-from']; } ?>">
      </span>
      <span class="col-md-3">
        <input type="text" name="dt-to" required class="datepicker form-control" placeholder="To" value="<?php if(isset($_POST['dt-to'])) { echo $_POST['dt-to']; } ?>">
      </span>
      <span class="col-md-2">
        <button name="sub" name="sub" type="submit" class="btn">Submit</button>
      </span>
    </div>
  {!! Form::close() !!}
  <br>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Sno.</th>
        <th>Name</th>
        <th>Email</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Created</th>
      </tr>
    </thead>
      <tbody>
        @if(count($results))
          <?php $i = 1; ?>
          @foreach($results as $row)
            <?php
              $data = unserialize($row->data);
            ?>            
            <tr>
              <td>{{$i}}</td>
              <td>{{$row->first_name}} {{$row->last_name}}</td>
              <td>{{$row->email}}</td>
              <td>{{$data['amount']}}</td>
              <td>{{$data['status']}}</td>
              <td>{{date('d/m/Y', strtotime($row->created_at))}}</td>
            </tr>
            <?php $i++;?>
          @endforeach
        @endif
      </tbody>
  </table>
  <div class="pagination"> {{ $results->links() }} </div>
</div>

@stop