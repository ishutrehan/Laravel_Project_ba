@extends('layouts.admin')

@section('head')

@stop

@section('content')

<h3>Edit Question</h3>
{!! Form::open(['url' => url('admin/update-essay-ques'), 'files'=>true ,'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Question:</label>
    <textarea class="form-control" name="question">{{base64_decode($essay->question)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Answer:</label>
    <textarea class="form-control" name="answer">{{base64_decode($essay->answer)}}</textarea>
    <input type="hidden" name="id" value="{{$essay->id}}">
  </div>
    <div class="form-group">
    <label for="question">Discussion:</label>
    <textarea class="form-control" name="discussion">{{base64_decode($essay->discussion)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Topic:</label>
    <textarea class="form-control" name="topic">{{base64_decode($essay->topic)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">References:</label>
    <textarea class="form-control" name="reference">{{base64_decode($essay->reference)}}</textarea>
  </div>
   <div class="form-group">
    <label for="question">Subject:</label>
    <select name="subject" class="form-control" >
       
       <option @if($essay->subject == 'general-haematology') selected @endif value="general-haematology">General haematology</option> 
       <option @if($essay->subject == 'transfusion') selected @endif value="transfusion">Transfusion</option> 
       <option @if($essay->subject == 'haemato-oncology') selected @endif value="haemato-oncology">Haemato-oncology</option> 
       <option @if($essay->subject == 'haemastasis-thrombosis') selected @endif value="haemastasis-thrombosis">Haemastasis and thrombosis</option> 

    </select>
  </div>
  <div class="form-group">
    <input type="hidden" name="old_images" value="{{$essay->images}}">
    <?php
      if (!empty($essay->images)) {
        $images = $essay->images;
        $images = explode(',', $images);
        foreach ($images as $img) { ?>
            <img src="{{ asset('uploads/essay') }}/{{$img}}" width="120">
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