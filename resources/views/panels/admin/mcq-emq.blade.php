@extends('layouts.admin')

@section('head')

@stop

@section('content')
@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif
<h3>Add New Question</h3>
{!! Form::open(['url' => url('admin/add-mcq-emq'),'files' => true ,'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Question:</label>
    <textarea class="form-control" name="question"></textarea>
  </div>
  <div class="form-group">
    <label for="question">Discussion:</label>
    <textarea class="form-control" name="discussion"></textarea>
  </div>
  <div class="form-group">
    <label for="question">References:</label>
    <textarea class="form-control" name="reference"></textarea>
  </div>
  <div class="form-group">
    <label for="question">Subject:</label>
    <select name="subject" class="form-control" >
       <option value="general-haematology">General haematology</option> 
       <option value="transfusion">Transfusion</option> 
       <option value="haemato-oncology">Haemato-oncology</option> 
       <option value="haemastasis-thrombosis">Haemastasis and thrombosis</option> 
    </select>
  </div>
  <div class="form-group">
    <label for="email">Answer Type:</label>
    <label class="radio-inline">
        <input type="radio" name="ans_type" value="multiple" class="ans_type" checked>MCQs
    </label>
    <label class="radio-inline">
        <input type="radio" name="ans_type" value="single" class="ans_type">EMQs
    </label> 
  </div>
  
  <!-- <div class="form-group">
    <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>
    <input type="button" id="add_more" class="upload" value="Add More Files"/>
  </div> -->  
  <div class="dy_form multiple_form form-group">
    <div class="input_fields_wrap mcq-form">
      <div class="form-group row">
        <div class="col-md-7">
          <button class="add_field_button btn " type="button">Add Answer</button>
        </div>
        <div class="col-md-2">
          <label style="float: right;">Right Answer</label>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <input type="text" class="form-control inpt" name="multiple_opts[0][0]">
        </div>
        <div class="col-md-4">
          <input type="checkbox" name="multiple_opts[0][1]">
        </div>
      </div>
    </div>
    <div class="input_fields_wrap_emq emq-form" style="display: none;">
        <button class="add_field_button_emq" type="button">Add Answer</button>      
        <div class="row">
          <textarea name="multiple_opts2[0][0]"></textarea>
          <div class="input_fields_wrap_emq_inr" data-id='0'>
              <button class="add_field_button_emq_inr" type="button">Add Answer Options</button>      
              <div class="row2">
                <input type="text" name="multiple_opts2[0][1][1]">
                <input type="radio" name="multiple_opts2[0][1][2]">
              </div>
          </div>
        </div>          
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </div>   
{!! Form::close() !!}
<hr>
<h3>Listing</h3>
<div class="rows">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Sno.</th>
        <th>Question</th>
        <th>Type</th>
        <th>Action</th>
      </tr>
    </thead>
    @if (count($results))
      <tbody>
        @foreach ($results as $index => $result)
            <tr>
              <td> {{ $index + 1 }} </td>
              <td> <?php echo base64_decode($result->question); ?> </td>
              <td> {{ $result->type }} </td>
              <td>
                <a class="btn btn-primary btn-sm" href="{{route('admin.edit-question-mcq', ['id' => $result->id ])}}">Edit</a>
                <a class="btn btn-primary btn-sm" onclick="return confirm('Are you sure?')" href="{{route('admin.delete-question-mcq', ['id' => $result->id ])}}">Delete</a>
                <a class="btn btn-primary btn-sm" href="{{route('admin.preview-question-mcq', ['id' => $result->id ])}}">Preview</a>
              </td>
            </tr>
        @endforeach
      </tbody>
    @endif      
  </table>
</div>


@stop