@extends('layouts.main')
@section('content')
@section('pageTitle', 'About Us')
@include('partials.status-panel')
 <!-- banner-part-start-->
      <div class="inner_banner">
       <div class="container">
         <div class="about_sr">
           <h2>About<span>us</span></h2>
           
          <!--  <div class="pagination">
            <ul>
             <li><a href="#">Home</a></li>
             <li>About us</li>
            </ul>
           </div> -->
           
         </div>
       </div>
       
      </div>
    <!-- banner-part-end-->
    
    
    <div class="abot-part wp100 padding_bottom">
     <div class="container">
        <div class="area_part wp100">
         <!--  <p><img src="images/aboimg.jpg" alt="" class="right_img">
          Blood-Academy is a unique and interactive e-learning platform aimed at maximising your chances of passing the Fellowship of the Royal College of Pathologists (FRCPath) haematology exam. We are based in the UK and all content is provided by haematologists and scientists who have passed the exam.</p>
          <p>There is obviously no substitute to a well-structured training scheme. However, getting exposure to rare cases as well as developing and refining exam technique can be difficult. This site aims to develop these skills and help equip you to pass the exam and develop a passion for haematology that grows as an independent haematologist.</p>
          <p>Blood-Academy aims to be the most comprehensive revision resource available. We are constantly working in developing more content and because we are online we can be much more up-to-date than any written text. </p>
          <hr> -->
          <p><?php echo base64_decode($about); ?></p>
        </div>
        
       
        </div>
        
        
     </div>
    </div>
		@stop