@extends('layouts.admin')

@section('head')

@stop

@section('content')
<div class="col-lg-6">
<h2>Member</h2>

{!! Form::open(['url' => url('admin/update-member'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="email">First Name:</label>
    <input type="text" class="form-control" id="name" name="name" value="{{$user['first_name']}}">
  </div>
  <div class="form-group">
    <label for="email">Last Name:</label>
    <input type="text" class="form-control" id="lname" name="lname" value="{{$user['last_name']}}">
  </div>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="text" class="form-control" disabled id="name" name="name" value="{{$user['email']}}">
  </div>
  <div class="form-group">
    <label for="email">Phone:</label>
    <input type="text" class="form-control" id="phone" name="phone" value="{{$user['phone']}}">
  </div>
  <div class="form-group">
    <label for="email">Gender:</label>
    <div class="radio">
      <label>
        <input type="radio" name="gender" id="male" value="male" @if($user['gender']=='male') checked @endif>
        Male
      </label>
    </div>
    <div class="radio">
      <label>
        <input type="radio" name="gender" id="female" value="female" @if($user['gender']=='female') checked @endif>
        Female
      </label>
    </div>
  </div>

  <div class="form-group">
    <label for="email">Current hospital:</label>
    <input type="text" class="form-control" id="current_hospital" name="current_hospital" value="{{$user['current_hospital']}}">
  </div>
  <div class="form-group">
    <label for="email">Country Residence:</label>
    <!-- <input type="text" class="form-control" name="country_residence" value="{{$user['country_residence']}}" id="quick-setup"> -->
    <select class="form-control" name="country_residence" id="quick-setup" value="{{$user['country_residence']}}"></select>
    <!-- <select value="FRA" 
        data-role="country-selector">
    </select> -->
  </div>
  <div class="form-group">
    <label for="email">Haematology trainee/ scientist:</label>
    <input type="text" class="form-control" id="haematology" name="haematology" value="{{$user['haematology']}}">
    <input type="hidden" name="user_id" value="{{$user['id']}}">
  </div>
   <?php 
    $todayDate = date('U');
    $expireDate = date('U', strtotime($user['expire_at']));
    if($user['subscription'] == 1 && !empty($user['expire_at']) && $todayDate < $expireDate) { ?>
      <a onclick="return confirm('Are you sure?')" href="{{route('admin.end-subs', ['id' => $user['id'] ])}}"  class="btn btn-danger">Cancel membership</a>
    <?php } ?>
  <button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

</div>

@stop