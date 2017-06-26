@extends('layouts.main')
@section('content')

@section('pageTitle', 'Pricing')

@include('partials.status-panel')
<!-- banner-part-start-->

<!-- banner-part-end-->


<div class="abot-part wp100 padding_bottom">
  <div class="container">
    <div class="introd_uctory">
      <div class="offer">
        <h2>special introductory offer</h2>
        <h1>£60</h1>
        <h3>4 month subscription</h3>
      </div>
      <div class="list">
        <ul>
          <li>Unlimited acess to all questions covering both FRCpath (haematology) part 1                                        and 2 exams.</li>
          <li>Interactive e-learning modules.</li>
          <li>Innovative morphology learning experience.</li>
          <li>Detailed clinical explanations.</li>
        </ul>
      </div>
      <div class="anchor"> <a href="{{route('register')}}"><button type="button">register to blood academy</button></a> </div>
      <div class="anch"><a href="{{route('public.explore-page')}}"> <button type="button">explore blood academy's features</button></a> </div>
    </div>
  </div>
</div>
@stop