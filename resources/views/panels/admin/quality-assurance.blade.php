@extends('layouts.admin')

@section('head')

@stop

@section('content')

@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif

<h3>Add New Question</h3>
{!! Form::open(['url' => url('admin/add-quality-assurance'), 'files' => true, 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="topic">Topic:</label>
    <textarea class="form-control" name="topic"></textarea>
  </div>
  <div class="form-group">
    <label for="question">Discussion/Explanation:</label>
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
       <option value="haemastasis-thrombosis">Haemastasis and thrombosis</option> 
    </select>
  </div>
  <div class="form-group">
    <label for="question">Question 1:</label>
    <textarea class="form-control" name="question[0][0]"></textarea>
  </div>
  <div class="form-group">
    <label for="question">Answer:</label>
    <textarea class="form-control" name="question[0][1]"></textarea>
  </div>
  <div class="form-group">
    <div class="input_fields_wrap2">
      <button class="add_field_button2" type="button">Add Question & Answers</button>
    </div>
  </div>
  <div class="form-group">
    <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>
    <input type="button" id="add_more" class="upload" value="Add More Files"/>
  </div> 
   
  <button type="submit" class="btn btn-default">Submit</button>   
{!! Form::close() !!}
<hr>
<h3>Listing</h3>
<div class="rows">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Sno.</th>
        <th>Topic</th>
        <th>Discussion</th>
        <th>Action</th>
      </tr>
    </thead>
    @if (count($results))
      <tbody>
        @foreach ($results as $index => $result)
            <tr>
              <td> {{ $index + 1 }} </td>
              <td> <?php echo  base64_decode($result->topic); ?> </td>
              <td> <?php echo  base64_decode($result->discussion); ?> </td>
              <td>
                <a class="btn btn-primary btn-sm" href="{{route('admin.edit-quality-assurance', ['id' => $result->id ])}}">Edit</a>
                <a class="btn btn-primary btn-sm" onclick="return confirm('Are you sure?')" href="{{route('admin.delete-quality-assurance', ['id' => $result->id ])}}">Delete</a>
                <a class="btn btn-primary btn-sm" href="{{route('admin.preview-question-quality', ['id' => $result->id ])}}">Preview</a>
              </td>
            </tr>
        @endforeach
      </tbody>
    @endif      
  </table>
</div>

@stop