@extends('layouts.main')
@section('pageTitle', 'Home Page')
@section('head')

@stop

@section('content')
 <div class="container">
      <div class="section_full_rw padding_tp-botm wp100">
  
         <div class="memer_home">
          <div class="Essay_bx">
            <div class="contents_left">
              <h2>Part 1</h2>
              <span><a href="{{route('subscription.exam-mcq-emq-opt' )}}">Multiple choice and extended matching questions</a></span> 
              <span><a href="{{route('subscription.exam-essay-questions' )}}">Essay</a></span> </div>
          </div>
          <div class="Essay_bx">
            <div class="contents_left">
              <h2>Part 2</h2>
              <span><a href="{{route('subscription.exam-morphology' )}}">Morphology</a></span> 
              <span><a href="{{route('subscription.exam-quality-assurance' )}}">Laboratory quality assurance (includes interactive module)</a></span> 
              <span><a href="{{route('subscription.exam-transfusion' )}}">Transfusion</a></span> </div>
          </div>
        </div>
        
        <div class="rec-up">
          <h3>Recent Updates</h3>
          <br>
          @if(count($results))
            @foreach($results as $result)
              <span style="margin: 10px 0;float: left;width: 100%;"><?php echo base64_decode($result->updates); ?></span>
            @endforeach
          @endif
        </div>
        <div class="myaccount_se">
          <!-- <ul>
            <li><a href="MCQandEMQs.html">MCQs, EMQs</a></li>
            <li><a href="MCQ-EMQquestion-page.html">Essay questions</a></li>
          </ul> -->
        </div>
      </div>
    </div>

@stop