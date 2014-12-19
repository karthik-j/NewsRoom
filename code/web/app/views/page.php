<?php include "header.php"; ?>


	<section id="maincontent">

		<!-- BREADCRUMBS -->
		<div class="container_12">
		
			<div class="grid_6">
				<ul class="breadcrumbs inline-list">
					<li><a href="home">Home</a></li>
					<li><?php echo $queryText; ?></li>
				</ul>
				
			</div>
			<div class="grid_6 text-right">
				<div id="Date" class="mobile-hide"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<!-- CONTENT/ARTIKEL -->
		<div class="container_12">
			<div class="grid_8">
				<!-- LOOP HERE... PUT THE QUERY HERE -->
				<article class="singlepost">
					<header>
						<!-- THUMB -->
						<div class="singlePosThumb">
						<?php if($img=="")
						{ ?>
						
						<?php } else { ?>
							<img src="<?php echo $img; ?>"  style="width:auto;" alt="image"/>
							<?php } ?>
							<div class="content-title">
								<h1 class="page-title" style="float:right;margin-right:30px;"><?php echo $queryText; ?></h1>
							</div>
							<div class="bub-right"></div>
							<div class="bub-left"></div>
						</div>
						<div class="clearfix"></div>
						<!-- META -->
						<div class="content-entry content-tags">
						
							TAGS: 
					<?php 
					foreach($tags as $key=>$val)
					{
					$sp=explode(":",$key);
					?>
						<a href="search?queryText=<?php echo $sp[1]; ?>">#<?php echo $sp[1]; ?></a>
					<?php } ?>
					
						</div>
					</header>
					
					<div class="clearfix"></div>
					<div class="devide"></div>
					
					<div class="content-entry">
						<div class="ratebox text-center">
							<h3>Our Relevancy Score</h3>
							<p>for the query "<?php echo $queryText; ?>"</p>
							<h1><?php echo $score*100; ?>%</h1>
							
						</div>
						<p><?php echo $HTMLcontent; ?>
						
					</div>
					
					<div class="clearfix"></div>
					<div class="devide"></div>
					<footer>
						<!-- TAGS -->
						
					</footer>
					<div class="clearfix"></div><div class="devide"></div>
					
					<!-- RELATED -->
					<div class="content-entry related">
						<div class="grid_12">
							<h3>Related Wiki Articles</h3>
						</div>
					<?php 
					$i=0;
					
					foreach ($wikiresultset as $document) {
					$i++;
					if($i<4){
					?>
					<div class="grid_4">
						<h2><a href="#"><?php echo $document->title; ?></a></h2>
						</div>
						<?php } } ?>
						
					</div>
				</article>
				
				<div class="clearfix"></div>
				
			</div>
			
			
			<div class="grid_4">
			<!-- CANVAS -->
				<div class="l-subheader" style="float:right;width:100%;">
					
					<!-- SEARCH -->
						<div class="w-search">
							<div class="w-search-h">
								<a class="w-search-show" href="javascript:void(0)" style="width:100%;">
								<center><input placeholder="<?php echo $qtext; ?>" style="font-size:15px;display:inline;width:60%;height:10px;margin:0;border: 1px solid #ccc;" type="text">    
								<button style="background-color: #208dcc;padding: 4px 9px;">Search</button>
								
								</center>
								</a>
								<form class="w-search-form show_hidden" method="GET" action="search">
									<div class="w-search-form-h">
										<div class="w-search-form-row">
											<div class="w-search-label">
												<label for="q">Just type and press 'enter'</label>
											</div>
											<div class="w-search-input">
											<div class="ui-widget">
												<input id="tags" style="font-size:2.1em;" type="text" name="queryText" value="<?php echo $qtext; ?>">	
												</div>
											</div>
											<a class="w-search-close" href="javascript:void(0)" title="Close search"> X </a>
										</div>
									</div>
								</form>
							</div>
						</div>
			</div>
			<br /><br /><br /><br />
				<div class="widgetbox blue">
					<h4><i class="icon-twitter"></i> Related Tweets</h4>
					<ul>
					<?php $i=0;
					$test=$resultset->getMatch();
					if(isset($test)) {
					foreach ($resultset->getMatch() as $k=>$v) {
					 if($k=="author") { $i++;?>
					<li><a href="#">@<?php echo $v; ?>:
					<?php } else if($k=="tweetContent") { ?>
					<?php echo $v; ?></a></li>
					<?php
					} } }
					foreach ($resultset as $document) {
					$i++;
					if($i<6){
					?>
						<li><?php echo "@".$document->author.": ".$document->tweetContent; ?></li>
						<?php } } ?>
						
					</ul>
				</div>
				<div class="widgetbox darkblue">
					<h4><i class="icon-comments"></i> Related News Articles</h4>
					<?php $i=0;$n=0;
					$test=$nresultset->getMatch();
					if(isset($test)) 
					{
					foreach ($nresultset->getMatch() as $k=>$v) {
					if($k=="link")
						$link=$v;
					else if($k=="title")
						$title=$v;
					else if($k=="newsContent")
						$newsContent=$v;
					}
					 $i++; 
					?>
					<article class="comitem">
						<div class="grid_12">
						
						<a href="<?php if(isset($link)) echo urldecode($link); else echo "#"; ?>">
							<em><b><?php echo $title; ?> </b></em>
							<br />
							 <i><?php echo substr($newsContent,0,150)."..."; ?></i>
							 <br />
							 <b style="float:right;"><i>Read more >> </i></b>
							</a></div>
					</article>
						
					<?php
					 }
					foreach ($nresultset as $document) {
					$i++;
					if($i<4){
					?>
					<article class="comitem">
						<div class="grid_12"><a href="<?php echo urldecode($document->link); ?>">
							 <em><b><?php echo $document->title; ?> </b></em>
							 <br />
							 <i><?php echo substr($document->newsContent,0,150)."..."; ?></i>
							 <br />
							 <b style="float:right;"><i>Read more >> </i></b>
							 </a>
						</div>
					</article>
					<?php } } ?>
					
				</div>
				
				<div class="widgetbox grey">
					<h4><i class="icon-bookmark"></i> Hot Trends</h4>
					<ul class="categorylist">
					<?php 
						$intarr=$resultset->getInterestingTerms();
						
					foreach($intarr as $key=>$val)
					{
					$sp=explode(":",$key);
					?>
						<li><a href="search?queryText=<?php echo $sp[1]; ?>">#<?php echo $sp[1]; ?></a></li>
					<?php } 
					$intarr=$nresultset->getInterestingTerms();
					foreach($intarr as $key=>$val)
					{
					$sp=explode(":",$key);
					?>
						<li><a href="search?queryText=<?php echo $sp[1]; ?>">#<?php echo $sp[1]; ?></a></li>
					<?php } 
					
					?>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		
		
	<div class="clearfix"></div>
	</section>

	
<?php include "footer.php"; ?>