<!doctype html>
<html>
<head>
	<title>NewsRoom | Search Results for "<?php echo $queryText; ?>"</title>
	<meta name="description" content="some description" />
	<meta name="keywords" content="HTML,CSS,XML,JavaScript" />
	<meta name="author" content="{your name}" />
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	 
	 	<!--max search  -->
	  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css">

	<!--<script type="text/javascript" src="js/jquery-1.9.1.js"></script>-->
	
	<script type="text/javascript" src="js/us.widgets.js"></script>

	<link rel="stylesheet" href="css/style2.css">
	
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<!--[if IE 7]>
		<link rel="stylesheet" href="css/font-awesome-ie7.min.css">
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="style.css" />
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Oswald:400,700,300' rel='stylesheet' type='text/css'>
</head>
<body>
<script>
$(document).ready(function(){
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
		});
</script>
<div class="clearfix"></div>
<div class="parentcontainer">

	<header id="mainheader" class="mobile-hide">
		<div class="container container_12">
			<!-- Logo -->
			<div class="grid_3 logo">
				<a href="home"><img src="logo.png" width="150" class="mobile-hide" alt="britanews"/></a>
			</div>
		</div>
		
		<div class="clearfix"></div>
		
		<!-- Menu -->
		<div class="container container_12">
			<div class="grid_12">
				<nav>
					<div>
						<ul class="mainmenu">
							
						</ul>
					</div>
				</nav>
			</div>
		</div>
		<div class="clearfix"></div>
	</header>
	<div class="clearfix"></div>
	
	