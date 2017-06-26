@extends('layouts.main')
@section('content')
@section('pageTitle', 'Contact Us')
@include('partials.status-panel')
 <!-- banner-part-start-->
      <div class="inner_banner">
       <div class="container">
         <div class="about_sr">
           <h2>Contact<span>us</span></h2>
           
    
         </div>
       </div>
       
      </div>
    <!-- banner-part-end-->
    
    
    <div class="abot-part wp100 padding_bottom">
     <div class="container">
        <div class="area_part wp100">
            <div class="cont_from pag_cont">
              @if(Session::has('message'))
                  <div class="alert alert-info" style="color: green; text-align: center;">
                    {{Session::get('message')}}
                  </div>
              @endif
              <h2 align="center">Contact<span>Us</span></h2>

              {!! Form::open(['url' => url('contact-page'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" value="" placeholder="Email" required>
                <!-- <input type="text" name="phone" value="" placeholder="Phone number" required> -->
                <textarea placeholder="Message" name="message"></textarea>
                <input type="submit" name="" value="Send message">
              {!! Form::close() !!}
            </div>
        </div> 
        </div>        
     </div>
   
		@stop