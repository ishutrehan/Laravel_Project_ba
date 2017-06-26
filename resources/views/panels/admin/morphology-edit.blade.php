@extends('layouts.admin')

@section('head')

@stop

@section('content')

@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif

<h3>Add New Question</h3>
{!! Form::open(['url' => url('admin/update-morphology'), 'files' => true, 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Short/ long case:</label>
    <textarea class="form-control" name="short_longcase">{{base64_decode($morphology->short_longcase)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Information:</label>
    <textarea class="form-control" name="information">{{base64_decode($morphology->information)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Discussion/Explanation:</label>
    <textarea class="form-control" name="discussion">{{base64_decode($morphology->discussion)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">References:</label>
    <textarea class="form-control" name="reference">{{base64_decode($morphology->reference)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Type:</label>
    <select name="subject" class="form-control" >
       <option value="short-cases" @if($morphology->type == 'short-cases') selected @endif >Short cases</option> 
       <option value="long-cases" @if($morphology->type == 'long-cases') selected @endif >Long cases</option> 
       <option value="short-long" @if($morphology->type == 'short-long') selected @endif >Short and long cases</option> 
    </select>
  </div>
  
  <div class="form-group">
    <div class="input_fields_wrap2">
      <button class="add_field_button2" type="button">Add Question & Answers</button>
      <?php
        $qdata = unserialize(base64_decode($morphology->data));
        $i = 1;
        foreach ($qdata as $key => $value) { 
          ?>
          <div class="row2">
            <div class="form-group">
              <label for="question">Question {{$i}}:</label>
              <textarea class="form-control" name="question[{{$i}}][0]">{{$value[0]}}</textarea>
            </div>
            <div class="form-group">
              <label for="question">Answer:</label>
              <textarea class="form-control" name="question[{{$i}}][1]">{{$value[1]}}</textarea>
            </div>
          </div>  
        <?php $i++; } 
      ?>
    </div>
  </div>
  <input type="hidden" name="id"  value="{{$morphology->id}}">
  <div class="form-group">
    <label for="question">Slide:</label>
    <input type="file" name="slide">
  </div>

  <div class="form-group">
    <label for="question">File:</label>
    <input type="text" name="pdf" class="form-control" value="{{$morphology->pdf}}">
  </div>
  <div class="form-group">
    <input type="hidden" name="old_images" value="{{$morphology->images}}">
    <?php
      if (!empty($morphology->images)) {
        $images = $morphology->images;
        $images = explode(',', $images);
        foreach ($images as $img) { ?>
            <img src="{{ asset('uploads/morphology') }}/{{$img}}" width="120">
      <?php }
      }
    ?>
  </div>
  <div class="form-group">
    <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>
    <input type="button" id="add_more" class="upload" value="Add More Files"/>
  </div>
  <button type="submit" class="btn btn-default">Update</button>   
{!! Form::close() !!}

@stop