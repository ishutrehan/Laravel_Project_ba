@extends('layouts.main')
@section('content')
@section('pageTitle', 'Terms of Use')
@include('partials.status-panel')
      <div class="inner_banner">
       <div class="container">
         <div class="about_sr">
           <h2>Terms <span>of use</span></h2>
           
          <!--  <div class="pagination">
            <ul>
             <li><a href="#">Home</a></li>
             <li>Terms of use</li>
            </ul>
           </div>
 -->           
         </div>
       </div>
       
      </div>
    <!-- banner-part-end-->
    
    
    <div class="abot-part wp100 padding_bottom">
      <div class="container">
        <div class="morphology wp100">
          <?php echo base64_decode($terms_use); ?>   
        </div>
      </div>
    </div>
		@stop