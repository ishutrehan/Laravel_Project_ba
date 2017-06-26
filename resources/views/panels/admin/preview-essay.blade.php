@extends('layouts.admin')

@section('head')

@stop

@section('content')

<div class="container">
  <div class="row">
    <h3>
        <?php
          echo base64_decode($result->question);
        ?>      
    </h3>
    <h5>
        <?php
          echo base64_decode($result->answer);
        ?>      
    </h5>
  </div>
  <hr>
  <div class="row">
    <h4>Discussion</h4>
      <?php
        echo base64_decode($result->discussion);
      ?>
  </div>
  <div class="row">
    <h4>Topic</h4>
      <?php
        echo base64_decode($result->topic);
      ?>
  </div>  
</div>
@stop