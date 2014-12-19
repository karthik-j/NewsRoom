<!DOCTYPE html>
<html class="cufon-active cufon-ready">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>NewsRoom - Home</title>
	
	<!-- METAS -->
	<meta charset="utf-8">
	<meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
	<!-- METAS -->
	
	<!-- CSS -->
	<link rel="stylesheet" href="css/960.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/style2.css">
	
	<!--max search -->
	  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

	
	<link rel="stylesheet" type="text/css" media="all" href="css/font-awesome.css">
	

	<link rel="stylesheet" type="text/css" media="all" href="css/style.css">


	
	<script type="text/javascript" src="js/us.widgets.js"></script>
	
	<!-- JQuery and Plugins 
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>	
	
	<script src="js/jquery.min.js" type="text/javascript"></script>-->
	<script src="js/jquery.easing.1.3.js" type="text/javascript"></script>
	
	<script src="js/jquery.cycle.all.js" type="text/javascript"></script>
	<script src="js/jquery.scrollTo.js" type="text/javascript"></script>
	<script src="js/jquery.localscroll.js" type="text/javascript"></script>
	
	
	<!-- CUFON Start -->
	<script src="js/cufon-yui.js" type="text/javascript"></script><style type="text/css">cufon{text-indent:0!important;}@media screen,projection{cufon{display:inline!important;display:inline-block!important;position:relative!important;vertical-align:middle!important;font-size:1px!important;line-height:1px!important;}cufon cufontext{display:-moz-inline-box!important;display:inline-block!important;width:0!important;height:0!important;overflow:hidden!important;text-indent:-10000in!important;}cufon canvas{position:relative!important;}}@media print{cufon{padding:0!important;}cufon canvas{display:none!important;}}</style>
	<script src="js/ColaborateLight_400.font.js" type="text/javascript"></script>
	<script src="js/Colaborate-Regular_400.font.js" type="text/javascript"></script>
	<script src="js/Colaborate-Thin_400.font.js" type="text/javascript"></script>
	
<script type="text/javascript"> 
	
	Cufon.replace('.CF_ColReg',{fontFamily: 'Colaborate-Regular'});
	Cufon.replace('.CF_ColLight',{fontFamily: 'ColaborateLight' });
	Cufon.replace('.CF_ColThin',{fontFamily: 'Colaborate-Thin' });
	Cufon.replace('.main_menu a', {
    'fontFamily': 'Colaborate-Regular',
    hover: {
        color: '#dddddd'
    }
	});
	
	Cufon.replace('#portfolio_menu li a', {
    'fontFamily': 'ColaborateLight',
    hover: {
        color: '#e33124'
    }
	});
	
	
</script>
<!-- CUFON End -->
<!-- End JQuery and Plugins -->

  <script type="text/javascript">

	$(document).ready(function(){
		$('.main_menu').localScroll({
				target: 'body',
				axis: 'y'
			});
		$('.go_home').localScroll({
				target: 'body',
				axis: 'y'
		});
	var cache={};

		$( '#tags' ).autocomplete({
		minLength: 4,
		source: function( request, response ) {
			var term = request.term;
			if ( term in cache ) {
			response( cache[ term ] );
		
			return;
			}
 
        $.getJSON( "autocomplete", request, function( data, status, xhr ) {
          cache[ term ] = data;
          //response( data );
			response(data.slice(0, 5));   
        }
		);
		
		}});
	
		
		//Slider

	
		$('#slider').after('<div id="home_slider_button"><div class="centerdiv"><ul id="nav">').cycle({

        fx:     'zoom',
		speed:  'fast',
        timeout: 3000,
        pager:  '#nav',
		 
                // callback fn that creates a thumbnail to use as pager anchor 
                pagerAnchorBuilder: function(idx, slide)
                {
                    return '<li><a href="#"></a></li>';
                }

		});
	
		// end Slider	

	});
	
	
	</script>

</head>
<body>

<!-- Container Start -->
<div id="container">
	<!-- container_16 -->
	<div class="container_16">

	<!-- COMPANY -->
		<div class="height_60"></div>
		<div id="company" class="inner_class">
			<!-- title start -->
			<div class="title grid_16">
						<div class="left"><img alt="NewsRoom" src="logo.png" /><!--<h2 class="CF_ColReg"><cufon class="cufon cufon-canvas" alt="News" style="width: 57px; height: 31px;"><canvas width="79" height="31" style="width: 79px; height: 31px; top: 2px; left: -1px;"></canvas><cufontext>News</cufontext></cufon><cufon class="cufon cufon-canvas" alt="Room" style="width: 125px; height: 31px;"><canvas width="138" height="31" style="width: 138px; height: 31px; top: 2px; left: -1px;"></canvas><cufontext>Room</cufontext></cufon></h2>-->
						</div>
						<div class="clear"></div>
			</div>
			<div class="clear"></div>
				<!-- end title -->
				
	<!-- CONTAIN -->
	
		<!-- HOME -->
		<div class="height_40"></div>
		<div id="home" class="inner_class">
			
			<!-- HOME VIDEO start-->
			<div id="home_video" class="grid_11">
				<!-- VIMEO start-->
				<div class="video">
				<iframe src="http://player.vimeo.com/video/2286621" width="620" height="345"></iframe>
				</div>
				<!-- VIMEO end -->
				
				<!-- video reflection start -->
				<div class="vimeo_reflection">
				</div>
				<!-- video reflection end -->
			</div>
			<!-- HOME VIDEO end-->
			
			<!-- HOME SLIDER -->
			<div id="home_slider" class="grid_5">
				
				<div id="slider" style="position: relative;">
					
				
					<div class="slider1" style="position: absolute; top: 0px; left: 0px; display: block; z-index: 4; width: 282px; height: 316px; opacity: 1;">
						<h3 class="CF_ColLight"><cufon class="cufon cufon-canvas" alt="About" style="width: 113px; height: 36px;"><canvas width="142" height="38" style="width: 142px; height: 38px; top: -1px; left: -1px;"></canvas><cufontext>About </cufontext></cufon></h3>
						<span class="CF_ColLight"><cufon class="cufon cufon-canvas" alt="NEWSROOM" style="width: 37px; height: 17px;"><canvas width="50" height="18" style="width: 50px; height: 18px; top: -1px; left: 0px;"></canvas><cufontext>What is NEWSROOM? </cufontext></cufon><cufon class="cufon cufon-canvas" alt="What is NEWASROOM?" style="width: 24px; height: 17px;">
						</span>
						<div class="dashed"></div>
						<div class="slider_text">
						<p>
						Newsroom is a gateway to the Wikipedia articles, the latest breaking news stories and the webposts across the social media.
						</p>
						</div>
						
					</div>
						
				<div class="slider2" style="position: absolute; top: 0px; left: 0px; display: block; z-index: 4; width: 282px; height: 316px; opacity: 1;">
						<h3 class="CF_ColLight"><cufon class="cufon cufon-canvas" alt="SpellCheck" style="width: 113px; height: 36px;"><canvas width="142" height="38" style="width: 142px; height: 38px; top: -1px; left: -1px;"></canvas><cufontext>SpellCheck</cufontext></cufon></h3>
						<span class="CF_ColLight"><cufon class="cufon cufon-canvas" alt="NEWSROOM FEATURE" style="width: 37px; height: 17px;"><canvas width="50" height="18" style="width: 50px; height: 18px; top: -1px; left: 0px;"></canvas><cufontext>NEWSROOM FEATURE </cufontext></cufon><cufon class="cufon cufon-canvas" alt="What is NEWASROOM?" style="width: 24px; height: 17px;">
						</span>
						<div class="dashed"></div>
						<div class="slider_text">
						<p>
						Searching for something on the Web, but can't spell it? Don't worry.  Newsroom's "Did you mean" feature provides alternative suggestions when you may have misspelled a search term.
						</p>
						</div>
						
					</div>
					
					<div class="slider3" style="position: absolute; top: 0px; left: 0px; display: block; z-index: 4; width: 282px; height: 316px; opacity: 1;">
						<h3 class="CF_ColLight"><cufon class="cufon cufon-canvas" alt="Auto-Complete" style="width: 113px; height: 36px;"><canvas width="142" height="38" style="width: 142px; height: 38px; top: -1px; left: -1px;"></canvas><cufontext>Auto-Complete</cufontext></cufon></h3>
						<span class="CF_ColLight"><cufon class="cufon cufon-canvas" alt="NEWSROOM FEATURE" style="width: 37px; height: 17px;"><canvas width="50" height="18" style="width: 50px; height: 18px; top: -1px; left: 0px;"></canvas><cufontext>NEWSROOM FEATURE </cufontext></cufon><cufon class="cufon cufon-canvas" alt="What is NEWASROOM?" style="width: 24px; height: 17px;">
						</span>
						<div class="dashed"></div>
						<div class="slider_text">
						<p>
						As you type in the search box, you can find information quickly by seeing search predictions that might be similar to the search terms you're typing. For example, as you start to type [new york], you may see other popular New York-related searches. When you click a search prediction, you do a search using that prediction as your search term. 
						</p>
						</div>
						
					</div>
				
				
				</div>
				
			</div>
			<!-- End HOME SLIDER -->
				
			<div class="clear"></div>
<div class="l-canvas type_wide col_cont headerpos_fixed headertype_extended">
	
	
			<!-- TWITTER -->
			<div id="twitter" class="grid_16">
				<div class="twitter_content"><center>
				<!-- CANVAS -->
				<div class="l-subheader">
					
					<!-- SEARCH -->
						<div class="w-search">
							<div class="w-search-h">
								<a class="w-search-show" href="javascript:void(0)">
								
	<a class="w-search-show" href="javascript:void(0)" style="width:100%;">
								<center><input placeholder="Enter your query text" size="80" style="font-size:15px;height:25px;vertical-align:bottom;display:inline;margin:0;" type="text">    
								
<img src="images/searchbtn.png" />	</center>
								
								</a>
								<form class="w-search-form show_hidden" method="GET" action="search">
									<div class="w-search-form-h" style="width:auto;">
										<div class="w-search-form-row" style="width:auto;">
											<div class="w-search-label">
												<label for="tags">Just type and press 'enter'</label>
											</div>
											
											<!--<div class="w-search-submit">
												<input type="submit" value="Search">
											</div>-->
											<div class="w-search-input" style="width:auto;">
											<div class="ui-widget" style="width:auto;">
												<input id="tags" style="font-size:2.1em;" type="text" name="queryText" value="">	
												</div>
											</div>
											<a class="w-search-close" href="javascript:void(0)" title="Close search"> X </a>
										</div>
									</div>
								</form>
							</div>
						</div>
			</div>
</div>			

			
					</div>
			</div>
			<!-- end TWITTER -->
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<!-- End  HOME -->
		
		
		
	
	</div>
	<!-- end container_16 -->
	
</div>
<!-- Container End-->
<div id="footer_up_for_blog"></div>
	
	
	
<!-- footer-container start -->
<div id="footer-container">
  <!-- FOOTER start -->
  <div id="footer">
	
	<div class="container_16">
		
		<!-- footer_up start -->
		<div id="footer_up">
			<div id="footer_links_other" class="grid_7">
				
				<div id="footer_links">
					<h4>Links</h4>
					<ul>
						<li><a href="Home - Gateway.html">HOME</a></li>
						<li><a href="">COMPANY</a></li>
						<li><a href="">PORTFOLIO</a></li>
						<li><a href="">SUPPORT</a></li>
						<li class="last"><a href="">CONTACT</a></li>
					</ul>
				</div>
				
				<div id="footer_other">
					<h4>Other Sites</h4>
					<ul>
						<li><a href="">WEB HOSTING</a></li>
						<li><a href="">DESIGNER CORNER</a></li>
						<li><a href="">CODE4ME</a></li>
						<li><a href="">VISUALFX</a></li>
						<li class="last"><a href="">VECTOR MAGIC</a></li>
					</ul>
				</div>
				
				<div class="clear"></div>
				<blockquote><p>Lorem ipsum dolor sit amet, cons odit adipisicing elit, sed do eiusmod temp incididunt ut labore et dolore <span>&nbsp;</span></p></blockquote>
				
				
				
			</div>
			
			<div id="footer_why_choose" class="grid_5">
				<div class="fwc_background">
				<h4>Why Choose Gateway 9</h4>
				<ul>
					<li>- POWERFULL ONEPAGE DESIGN</li>
					<li>- SORTABLE PORTFOLIO DISPLAY</li>
					<li>- VIDEO ENABLE HEADER</li>
					<li>- HEADER SLIDE FOR EXTRA TEXT</li>
					<li>- LIVE TWEETER FEEDS</li>
					<li>- 3 COLUMN INFO &amp; SUPPORT DISPLAY</li>
					<li>- READY NEWSLETTER &amp; CONTACT FORM</li>
					<li>- BONUS LANDING PAGE</li>
					<li>- BONUS UNDERCONSTRUCTION PAGE</li>
					<li>- UNIQUE 3D STYLED SLICK DESIGN</li>
				</ul>
				</div>
			</div>
			
			<div id="footer_info" class="grid_4">
				
				<ul class="footer_info_p">
					<li>p: <b>+1 800 123 4567</b></li>
					<li>e: <b><a href="mailto:info@domain.com">info@domain.com</a></b></li>
				</ul>
				
				<div class="tag">
					<ul>
						<li><a href="" class="tag1">Tag 1</a></li>
						<li><a href="" class="tag2">Gateway 9</a></li>
						<li><a href="" class="tag3">Tag </a></li>
						<li><a href="" class="tag4">Tag 3</a></li>
						<li><a href="" class="tag5">slick </a></li>
						<li><a href="" class="tag6">added</a></li>
						<li><a href="" class="tag7">feature</a></li>
						<li><a href="" class="tag8">3d</a></li>
						<li><a href="" class="tag9">style</a></li>
						<li><a href="" class="tag10">form</a></li>
						<li><a href="" class="tag11">twitter</a></li>
						<li><a href="" class="tag12">Tag 4</a></li>
						<li><a href="" class="tag13">video</a>	</li>
					</ul>				
				</div>
				
				<div class="clear"></div>
				<div class="footer_available">
				<span class="wWhite">Also available on</span>
				<ul id="footer_social">
					<li><a href=""><img src="social_1.png"></a></li>
					<li><a href=""><img src="social_2.png"></a></li>
					<li><a href=""><img src="social_3.png"></a></li>
					<li><a href=""><img src="social_4.png"></a></li>
					<li><a href=""><img src="social_5.png"></a></li>
					<li><a href=""><img src="social_6.png"></a></li>
					<li><a href=""><img src="social_7.png"></a></li>					
				</ul>
				</div>
				
			</div>
			
			
		</div>	
		<!-- footer_up end -->
		
		
		<!-- footer_bottom start-->
		<div id="footer_bottom" class="grid_16">
		
			<!-- footer_copyright start-->
			<div class="footer_copyright">
				<ul class="menu">
					<li><a href="http://www.9dlabs.net/tfdemos/gateway9/main/index.html#">Privacy</a></li>
					<li><a href="http://www.9dlabs.net/tfdemos/gateway9/main/index.html#">Disclaimer</a></li>
					<li><a href="http://www.9dlabs.net/tfdemos/gateway9/main/index.html#">Credit</a></li>
				</ul>
			</div>
			<!-- footer_copyright end -->
			
		</div>
		<div class="clear"></div>
		<!-- footer_bottom end -->
	</div>
</div>
<!-- FOOTER end-->
</div>
<!-- footer-container end-->

</body></html>