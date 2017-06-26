@extends('layouts.admin')

@section('head')

@stop

@section('content')

@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif

<h3>Edit Question</h3>
{!! Form::open(['url' => url('admin/update-quality-assurance'), 'files'=>true ,'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="topic">Topic:</label>
    <textarea class="form-control" name="topic">{{base64_decode($qualityassurance->topic)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Discussion/Explanation:</label>
    <textarea class="form-control" name="discussion">{{base64_decode($qualityassurance->discussion)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">References:</label>
    <textarea class="form-control" name="reference">{{base64_decode($qualityassurance->reference)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Subject:</label>
    <select name="subject" class="form-control" >
     
       <option @if($qualityassurance->subject == 'general-haematology') selected @endif value="general-haematology">General haematology</option> 
       <option @if($qualityassurance->subject == 'transfusion') selected @endif value="transfusion">Transfusion</option> 
       
       <option @if($qualityassurance->subject == 'haemastasis-thrombosis') selected @endif value="haemastasis-thrombosis">Haemastasis and thrombosis</option>  
    </select>
  </div>
  <div class="form-group">
    <div class="input_fields_wrap2">
      <button class="add_field_button2" type="button">Add Question & Answers</button>
      <?php
        $qdata = unserialize(base64_decode($qualityassurance->data));
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
  
    <input type="hidden" name="id" value="{{$qualityassurance->id}}">
  <div class="form-group">
  <input type="hidden" name="old_images" value="{{$qualityassurance->images}}">
    <?php
      if (!empty($qualityassurance->images)) {
        $images = $qualityassurance->images;
        $images = explode(',', $images);
        foreach ($images as $img) { ?>
            <img src="{{ asset('uploads/quality-assurance') }}/{{$img}}" width="120">
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