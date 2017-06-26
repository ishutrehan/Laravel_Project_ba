@extends('layouts.admin')

@section('head')

@stop

@section('content')
<div class="col-lg-6">
<h2>Add Member</h2>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{!! Form::open(['url' => url('admin/add-member'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="email">First Name:</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  <div class="form-group">
    <label for="email">Last Name:</label>
    <input type="text" class="form-control" id="lname" name="lname" required>
  </div>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="form-group">
    <label for="email">Phone:</label>
    <input type="text" class="form-control" id="phone" name="phone">
  </div>
  <div class="form-group">
    <label for="email">Gender:</label>
    <div class="radio">
      <label>
        <input type="radio" name="gender" id="male" value="male" checked>
        Male
      </label>
    </div>
    <div class="radio">
      <label>
        <input type="radio" name="gender" id="female" value="female">
        Female
      </label>
    </div>
  </div>
  <div class="form-group">
    <label for="email">Current hospital:</label>
    <input type="text" class="form-control" id="current_hospital" name="current_hospital">
  </div>
 
  <div class="form-group">
    <label for="email">Country Residence:</label>
    <select class="form-control" name="country_residence" id="quick-setup"></select>
  </div>
  <div class="form-group">
    <label for="email">Haematology trainee/ scientist:</label>
    <input type="text" class="form-control" id="haematology" name="haematology">
    <input type="hidden" name="user_id">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}
</div>



@stop