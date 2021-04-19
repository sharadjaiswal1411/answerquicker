<!DOCTYPE html>
<html lang="zxx">
<head>
@include('partials.header')
@yield('css')
</head>
<body class="header-one">
<div id="main_wrapper">
@include('partials.menu')
	

@yield('content')


<div id="footer" class="footer_sticky_part"> 
<div class="container">
  <div class="row">
	<div class="col-md-2 col-sm-3 col-xs-6">
	  <h4>Useful Links</h4>
	  <ul class="social_footer_link">
		<li><a href="#">Home</a></li>
		<li><a href="#">Listing</a></li>
		<li><a href="#">Blog</a></li>
		<li><a href="#">Privacy Policy</a></li>
		<li><a href="#">Contact</a></li>
	  </ul>
	</div>
	<div class="col-md-2 col-sm-3 col-xs-6">
	  <h4>My Account</h4>
	  <ul class="social_footer_link">
		<li><a href="#">Dashboard</a></li>
		<li><a href="#">Profile</a></li>
		<li><a href="#">My Listing</a></li>
		<li><a href="#">Favorites</a></li>
	  </ul>
	</div>
	<div class="col-md-2 col-sm-3 col-xs-6">
	  <h4>Pages</h4>
	  <ul class="social_footer_link">
		<li><a href="#">Blog</a></li>
		<li><a href="#">Our Partners</a></li>
		<li><a href="#">How It Work</a></li>
		<li><a href="#">Privacy Policy</a></li>
	  </ul>
	</div>
	<div class="col-md-2 col-sm-3 col-xs-6">
	  <h4>Help</h4>
	  <ul class="social_footer_link">
		<li><a href="#">Sign In</a></li>
		<li><a href="#">Register</a></li>
		<li><a href="#">Add Listing</a></li>
		<li><a href="#">Pricing</a></li>
		<li><a href="#">Contact Us</a></li>
	  </ul>
	</div>
	<div class="col-md-4 col-sm-12 col-xs-12"> 
	  <h4>About Us</h4>
	  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>          
	</div>
  </div>
  
  <div class="row">
	<div class="col-md-12">
	  <div class="footer_copyright_part">Copyright © 2019 All Rights Reserved.</div>
	</div>
  </div>
</div>
</div> 
<div id="bottom_backto_top"><a href="#"></a></div>
</div>
@include('partials.footer')
@yield('scripts')
<!-- Style Switcher -->
<div id="color_switcher_preview">
  <h2>Choose Your Color <a href="#"><i class="fa fa-cog fa-spin (alias)"></i></a></h2>	
	<div>
		<ul class="colors" id="color1">
			<li><a href="#" class="stylesheet"></a></li>
			<li><a href="#" class="stylesheet_1"></a></li>
			<li><a href="#" class="stylesheet_2"></a></li>			
			<li><a href="#" class="stylesheet_3"></a></li>						
			<li><a href="#" class="stylesheet_4"></a></li>
			<li><a href="#" class="stylesheet_5"></a></li>			
		</ul>
	</div>		
</div>
</body>
</html>

