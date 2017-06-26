@extends('layouts.admin')

@section('head')

@stop

@section('content')
@if(Session::has('alert-success'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('alert-success') !!}</em></div>
@endif
<h3>Edit Question</h3>
{!! Form::open(['url' => url('admin/update-mcq-emq'), 'files'=>true,'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
  <div class="form-group">
    <label for="question">Question:</label>
    <textarea class="form-control" name="question">{{base64_decode($mcq->question)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Discussion:</label>
    <textarea class="form-control" name="discussion">{{base64_decode($mcq->discussion)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">References:</label>
    <textarea class="form-control" name="reference">{{base64_decode($mcq->reference)}}</textarea>
  </div>
  <div class="form-group">
    <label for="question">Subject:</label>
    <select name="subject" class="form-control" >
       <option @if($mcq->subject == 'general-haematology') selected @endif value="general-haematology">General haematology</option> 
       <option @if($mcq->subject == 'transfusion') selected @endif value="transfusion">Transfusion</option> 
       <option @if($mcq->subject == 'haemato-oncology') selected @endif value="haemato-oncology">Haemato-oncology</option> 
       <option @if($mcq->subject == 'haemastasis-thrombosis') selected @endif value="haemastasis-thrombosis">Haemastasis and thrombosis</option> 
    </select>
  </div>

  <div class="form-group">
    <label for="email">Answer Type:</label>
    <label class="radio-inline">
        {{$mcq->type}}
    </label>
    <input type="hidden" name="id" value="{{$mcq->id}}"> 
  </div>
  <?php
    $questions = unserialize(base64_decode($mcq->data));
    // echo "<pre>";
    // print_r($questions);
    // echo "</pre>";
  ?>
  <div class="form-group">
    <input type="hidden" name="old_images" value="{{$mcq->images}}">
    <?php
      if (!empty($mcq->images)) {
        $images = $mcq->images;
        $images = explode(',', $images);
        foreach ($images as $img) { ?>
            <img src="{{ asset('uploads/mcq') }}/{{$img}}" width="120">
      <?php }
      }
    ?>
  </div>
  <div class="form-group">
    <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>
    <input type="button" id="add_more" class="upload" value="Add More Files"/>
  </div>  
  <div class="dy_form multiple_form form-group col-md-8" style="">
    @if($mcq->type == 'single')
      <div class="input_fields_wrap_emq emq-form">
        <button class="add_field_button_emq" type="button">Add Answer</button>      
          <?php $x = 0; ?> 
          @foreach($questions as $key=>$question)
            <div class="row">
              <textarea name="multiple_opts2[{{$key}}][0]">{{$questions[$key][0]}}</textarea>
              <div class="input_fields_wrap_emq_inr" data-id='0'>
                  <button class="add_field_button_emq_inr" type="button">Add Answer Options</button>
                  <?php $v = 0; ?>       
                  @foreach($question as $key2=>$opt)
                    @if(gettype($opt) == 'array')
                      <div class="row2">
                        <input type="text" name="multiple_opts2[{{$key}}][{{$v}}][1]" value="{{$opt[1]}}">
                        <input type="radio" name="multiple_opts2[{{$key}}][{{$v}}][2]" @if(isset($opt[2]) && $opt[2] == 'on') checked @endif>
                      </div>
                    @endif
                    <?php $v++; ?>
                   @endforeach   
              </div>
              <?php $x++; ?>
            </div>          
          @endforeach   
      </div>
    @else
      <div class="input_fields_wrap">
        <div class="form-group row">
          <div class="col-md-7">
            <button class="add_field_button btn" type="button">Add Answer options</button>
          </div>
          <div class="col-md-2">
            <label style="float: right;">Right Answer</label>
          </div>
        </div>
        @foreach($questions as $question)   
          <div class="row">
            <div class="col-md-8">
              <input type="text" class="form-control inpt" value="{{$question[0]}}" name="multiple_opts[{{$loop->index}}][0]">
            </div>
            <div class="col-md-4">
              <input type="checkbox" name="multiple_opts[{{$loop->index}}][1]" @if(isset($question[1]) && $question[1] == 'on') checked @endif>
            </div>
          </div>
        @endforeach    
      </div>
    @endif
    <input type="hidden" name="ans_type" value="{{$mcq->type}}">      
  <button type="submit" class="btn btn-default">Submit</button>
  </div>   
{!! Form::close() !!}

@stop