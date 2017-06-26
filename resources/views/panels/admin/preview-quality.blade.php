@extends('layouts.admin')

@section('head')

@stop

@section('content')

<div class="container">
  <div class="row">
    <h4>Topic</h4>
      <?php
        echo base64_decode($result->topic);
      ?>
  </div>
  <div class="row">
    <h4>Discussion</h4>
      <?php
        echo base64_decode($result->discussion);
      ?>
  </div>
  <div class="row">
    <h4>Reference</h4>
      <?php
        echo base64_decode($result->reference);
      ?>
  </div>
  
  <hr>
  <div class="row">
    <?php
      $data = unserialize(base64_decode($result->data));
    ?>
    @foreach($data as $dt)
      <div>
         <p>
            <span>
              <h5><b>Question</b></h5><?php echo $dt[0]; ?>
            </span>
            <span>
              <h5><b>Answer</b></h5><?php echo $dt[1]; ?>
            </span>
          </p> 
      </div>
    @endforeach
  </div>  
</div>
@stop