@extends('layouts.admin')

@section('head')

@stop

@section('content')

@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif

<h3>Add New Question</h3>
{!! Form::open(['url' => url('admin/add-morphology'), 'files' => true, 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Short/ long case:</label>
    <textarea class="form-control" name="short_longcase"></textarea>
  </div>
  <div class="form-group">
    <label for="question">Information:</label>
    <textarea class="form-control" name="information"></textarea>
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
    <label for="question">Type:</label>
    <select name="subject" class="form-control" >
       <option value="short-cases">Short cases</option> 
       <option value="long-cases">Long cases</option> 
       <option value="short-long">Short and long cases</option> 
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
    <label for="question">Slide:</label>
    <input type="file" name="slide">
  </div>
    <div class="form-group">
    <label for="question">File Url:</label>
    <input type="text" name="pdf" class="form-control">
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
        <th>Short/ long case</th>
        <th>Information</th>
        <th>Type</th>
        <th>Action</th>
      </tr>
    </thead>
    @if (count($results))
      <tbody>
        @foreach ($results as $index => $result)
            <tr>
              <td> {{ $index + 1 }} </td>
              <td> <?php echo base64_decode($result->short_longcase); ?> </td>
              <td> <?php echo base64_decode($result->information); ?> </td>
              <td> {{ $result->type }} </td>
              <td>
                <a class="btn btn-primary btn-sm" href="{{route('admin.edit-question-morphology', ['id' => $result->id ])}}">Edit</a>
                <a class="btn btn-primary btn-sm" onclick="return confirm('Are you sure?')" href="{{route('admin.delete-question-morphology', ['id' => $result->id ])}}">Delete</a>
                
                <a class="btn btn-primary btn-sm" href="{{route('admin.preview-question-morphology', ['id' => $result->id ])}}">Preview</a>
              </td>
            </tr>
        @endforeach
      </tbody>
    @endif      
  </table>
</div>

@stop