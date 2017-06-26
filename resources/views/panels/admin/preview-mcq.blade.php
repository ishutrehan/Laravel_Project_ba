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
  </div>
  <div class="row">
    <?php
    $data = unserialize(base64_decode($result->data));
    $x = 1; 
    foreach ($data as $key => $opt) { ?>
        <p>
          <?php
            echo $x.') '.$opt[0]; 
            if (isset($opt[1]) && $opt[1] == 'on') {
              echo " - <b style='color:green'>CORRECT</b>";
            }
          ?>
        </p>
        
    <?php $x++; }
    ?>
  </div>
  <hr>
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
</div>
@stop