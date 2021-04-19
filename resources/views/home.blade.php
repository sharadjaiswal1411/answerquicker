@extends('layouts.front')
@section('content')
  <div class="search_container_block overlay_dark_part">
    <div class="main_inner_search_block">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2>Best Online Quiz & Mock Platform</h2>
            <h4>Take a free online quiz to upgrade your skills</h4>
            <div class="main_input_search_part">

              <div class="main_input_search_part_item intro-search-field">
                <select data-placeholder="Select Stream" class="selectpicker default" title="All Categories" data-live-search="true" data-selected-text-format="count" data-size="5">
                  <option>Accounting</option>
                  <option>Commerce</option>
                  <option>Computer Science</option>
                  <option>Business</option>
                  <option>Electronics</option>
                  <option>Goverment</option>
                </select>
              </div>

           
              <div class="main_input_search_part_item intro-search-field">
                  <select data-placeholder="Select Subject/Exam" class="selectpicker default" title="Select Subject/Exam" data-live-search="true" data-selected-text-format="count" data-size="5">
                  <option>Accounting</option>
                  <option>Commerce</option>
                  <option>Computer Science</option>
                  <option>Business</option>
                  <option>Electronics</option>
                  <option>Goverment</option>
                </select>
			       </div>

             <div class="main_input_search_part_item">
                <input type="text" placeholder="Type your question..." value=""/>
              </div>

              <button class="button" onclick="window.location.">Search</button>
            </div>
            <div class="main_popular_categories">
			  <h3>Or Browse Popular Categories</h3>		
              <ul class="main_popular_categories_list">
				<li> <a href="#">
                  <div class="utf_box"> <i class="im im-icon-Chef-Hat" aria-hidden="true"></i>
                    <p>Restaurant</p>					
                  </div>
                  </a> 
				</li>
                <li> <a href="#">
                  <div class="utf_box"> <i class="im im-icon-Dumbbell" aria-hidden="true"></i>
                    <p>Fitness</p>
                  </div>
                  </a> 
				</li>
                <li> <a href="#">
                  <div class="utf_box"> <i class="im im-icon-Electric-Guitar" aria-hidden="true"></i>
                    <p>Events</p>
                  </div>
                  </a> 
				</li>
                <li> <a href="#">
                  <div class="utf_box"> <i class="im im-icon-Hotel" aria-hidden="true"></i>
                    <p>Hotels</p>
                  </div>
                  </a> 
				</li>                
                <li> <a href="#">
                  <div class="utf_box"> <i class="im im-icon-Home-2" aria-hidden="true"></i>
                    <p>Real Estate</p>
                  </div>
                  </a> 
				</li>
				<li> <a href="#">
                  <div class="utf_box"> <i class="im im-icon-Business-Man" aria-hidden="true"></i>
                    <p>Business</p>
                  </div>
                  </a> 
				</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    

  </div>
  

  



  <section class="fullwidth_block margin-top-65 padding-top-75 padding-bottom-70" data-background-color="#f9f9f9">
    <div class="container">
    	@foreach($sectors as $sector)
      <div class="row">
        <div class="col-md-12">
          <h3 class="headline_part pull-left"> {{$sector->name}} </h3>
          <a class="pull-right mt-2 view-all" href="{{$sector->slug}}/">View All</a>
        </div>
      </div>
    
		<div class="row">
@foreach($sector->featuredCategories as $category)
			<div class="col-md-3"> 
				<div class="category-bx">
					<a href="{{url('quiz/'.$category->slug)}}/">
						<div class="utf_img_content_box visible">
						<h4>{{$category->name}}</h4>
						<span>{{$category->played}} Plays</span> 
						</div>
					</a> 
				</div>
			</div>
@endforeach

		</div>
@endforeach
 
	   
    </div>
  </section> 
  
  <section class="fullwidth_block padding-top-75 padding-bottom-75" data-background-color="#ffffff">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3 class="headline_part centered margin-bottom-50"> Letest Tips & Blog<span>Discover & connect with top-rated local businesses</span></h3>
        </div>
      </div>
      <div class="row"> 
        <div class="col-md-3 col-sm-6 col-xs-12"> <a href="blog_detail_post.html" class="blog_compact_part-container">
          <div class="blog_compact_part"> <img src="images/blog-compact-post-01.jpg" alt="">
            <div class="blog_compact_part_content">              
			  <h3>The Most Popular New top Places Listing</h3>
			  <ul class="blog_post_tag_part">
                <li>22 January 2019</li>				
              </ul>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor</p>
            </div>
          </div>
          </a> 
		</div>
        
        <div class="col-md-3 col-sm-6 col-xs-12"> <a href="blog_detail_post.html" class="blog_compact_part-container">
          <div class="blog_compact_part"> <img src="images/blog-compact-post-02.jpg" alt="">
            <div class="blog_compact_part_content">              
              <h3>Greatest Event Places in Listing</h3>
			  <ul class="blog_post_tag_part">
                <li>18 January 2019</li>
              </ul>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor</p>
            </div>
          </div>
          </a> 
		</div>
        
        <div class="col-md-3 col-sm-6 col-xs-12"> <a href="blog_detail_post.html" class="blog_compact_part-container">
          <div class="blog_compact_part"> <img src="images/blog-compact-post-03.jpg" alt="">
            <div class="blog_compact_part_content">              
              <h3>Top 15 Greatest Ideas for Health & Body</h3>
			  <ul class="blog_post_tag_part">
                <li>10 January 2019</li>
              </ul>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor</p>
            </div>
          </div>
          </a> 
		</div>
        
        <div class="col-md-3 col-sm-6 col-xs-12"> <a href="blog_detail_post.html" class="blog_compact_part-container">
          <div class="blog_compact_part"> <img src="images/blog-compact-post-04.jpg" alt="">
            <div class="blog_compact_part_content">              
              <h3>Top 10 Best Clothing Shops in Sydney</h3>
			  <ul class="blog_post_tag_part">
                <li>18 January 2019</li>
              </ul>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor</p>
            </div>
          </div>
          </a> 
		</div>        
        <div class="col-md-12 centered_content"> <a href="blog_page.html" class="button border margin-top-20">View More Blog</a> </div>
      </div>
    </div>
  </section>
  
  <section class="fullwidth_block margin-bottom-0 padding-top-30 padding-bottom-65" data-background-color="linear-gradient(to bottom, #f9f9f9 0%, rgba(255, 255, 255, 1))">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="headline_part centered margin-bottom-40 margin-top-30">Our Company Logos</h3>
			</div>
			<div class="col-md-12">
				<div class="companie-logo-slick-carousel utf_dots_nav margin-bottom-10">
					<div class="item">
						<img src="images/brand_logo_01.png" alt="">
					</div>
					<div class="item">
						<img src="images/brand_logo_02.png" alt="">
					</div>
					<div class="item">
						<img src="images/brand_logo_03.png" alt="">
					</div>
					<div class="item">
						<img src="images/brand_logo_04.png" alt="">
					</div>
					<div class="item">
						<img src="images/brand_logo_05.png" alt="">
					</div>		
					<div class="item">
						<img src="images/brand_logo_06.png" alt="">
					</div>	
					<div class="item">
						<img src="images/brand_logo_07.png" alt="">
					</div>					
				</div>
			</div>
		</div>
	</div>
  </section>
  
  <section class="utf_cta_area_item utf_cta_area2_block">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="utf_subscribe_block clearfix">
                    <div class="col-md-8 col-sm-7">
                        <div class="section-heading">
                            <h2 class="utf_sec_title_item utf_sec_title_item2">Subscribe to Newsletter!</h2>
                            <p class="utf_sec_meta">
                                Subscribe to get latest updates and information.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-5">
                        <div class="contact-form-action">
                            <form method="post">
                                <span class="la la-envelope-o"></span>
                                <input class="form-control" type="email" placeholder="Enter your email" required="">
                                <button class="utf_theme_btn" type="submit">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
	</section>
  
@endsection