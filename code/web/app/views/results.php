<?php include "header.php"; ?>
 	
	<section id="maincontent">
		<!-- BREADCRUMBS -->
		<div class="container_12">
			<div class="grid_6">
				<ul class="breadcrumbs inline-list">
					<li><a href="home">Home</a></li>
					<li>Search Results (<?php if(isset($id)) echo "1"; else echo $resultset->getNumFound(); ?> found)</li>
				</ul>
			</div>
			<div class="grid_6 text-right">
				<div id="Date" class="mobile-hide"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<!-- CONTENT/ARTIKEL -->
		<div class="container_12">
		<!-- CANVAS -->
				<div class="l-subheader">
					
					<!-- SEARCH -->
						<div class="w-search">
							<div class="w-search-h">
								<a class="w-search-show" href="javascript:void(0)" style="width:100%;">
								<center><input placeholder="<?php echo $queryText; ?>" style="display:inline;font-size:15px;width:85%;height:10px;margin:0;border: 1px solid #ccc;" type="text">

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
												<input id="tags" style="font-size:2.1em;" type="text" name="queryText" value="<?php echo $queryText; ?>">	
												</div>
											</div>
											<a class="w-search-close" href="javascript:void(0)" title="Close search"> X </a>
										</div>
									</div>
								</form>
							</div>
						</div>
			</div>
<br /><br />
			<div class="grid_12 archivetitle">
				<div class="textdev"><h1> Search Results for "<?php echo $queryText; ?>"</h1>
				<?php if(isset($words)) { ?> <br />
				<h3>Did you mean "<a href="search?queryText=<?php echo $words[0]['word']; ?>" /><i><?php echo $words[0]['word']; ?></i></a>"?</h3>
				<?php } ?>
				<div></div></div>
			</div>
			<div class="grid_8">
			<?php 
			
			if($resultset->getNumFound()==0)
			{
				// DYNAMIC RETRIEVAL
				if(isset($id))
				{
					$ch = curl_init("http://en.wikipedia.org/w/api.php?action=query&pageids=".$id."&prop=pageimages&format=json&pithumbsize=1000");

					curl_setopt($ch, CURLOPT_HTTPGET, true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Accept: application/json'
					));

					$result = curl_exec($ch);
					curl_close($ch);
					
					$darr = json_decode($result);
					$obj=$darr->query->pages;
					
					
					foreach($obj as $key=>$val)
					{
					if(isset($val->thumbnail->source))
						$img = $val->thumbnail->source;
					else	
						$img=null;
					}
					
					//$ch = curl_init("http://en.wikipedia.org/w/api.php?action=parse&pageid=".$id."&format=json&prop=text");
					$ch = curl_init("http://en.wikipedia.org/w/api.php?action=query&pageids=".$id."&format=json&prop=extracts");
					
					curl_setopt($ch, CURLOPT_HTTPGET, true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Accept: application/json'
					));

					$result = curl_exec($ch);
					curl_close($ch);
					
					$darr = json_decode($result);
					$obj=$darr->query->pages;
					
					foreach($obj as $key=>$val)
					{
						$title=$val->title;
						$summary=$val->extract;
					}
							$wikiclient = new \Solarium\Client(Config::get('solr'));
							$update = $wikiclient->createUpdate();
							$doc = $update->createDocument();
							$doc->id = $id;
							$doc->title = $title;
							$doc->revision = $id;
							$doc->author = "DYNAMIC";
							$doc->authorid = "1010";
							$doc->timestamp =  gmdate('Y-m-d\TH:i:s\Z',time());
							$doc->content = $summary;
							$update->addDocument ( $doc );
							$update->addCommit();
							$result = $wikiclient->update( $update );
							
					?>
					<article>
					<div class="postloopBig">
						<div class="loopBigThumb" style="height:350px;background-color:#000000;">
							<?php
							if(isset($img))
							{
							?>
							<img src="<?php echo $img; ?>" alt="image"/>
							<?php
							}
							else
							{
							?>
							<h1 style="color:white;margin:20px 20px;"><?php echo $title; ?></h1>
							<?php
							}
							?>
							
							
						</div>
						<div class="loopBigAuthor">
						<form method="post" action="page" id="pform<?php echo $id; ?>">
						<input type="hidden" value="<?php echo $id; ?>" name="id" />
						<input type="hidden" value="<?php if(isset($score)) echo $score; else $score="100%"; ?>" name="score" />
						
						<input type="hidden" value="<?php echo $queryText; ?>" name="qtext" />
						<input type="hidden" value="<?php if(isset($img)) echo $img; else echo "" ?>" name="img" />
						<input type="hidden" value="<?php echo $title; ?>" name="title" />
						</form>
							
						</div>
						<div class="loopBigIsi">
							<header>
								<h2><a href="#" onclick="document.getElementById('pform<?php echo $id;?>').submit();"><?php echo $title; ?></a></h2>
								<!--<ul class="loopBigMeta inline-list">
									<li><a href="#"><i class="icon-bookmark-empty"></i> How To's</a></li>
									<li><a href="#"><i class="icon-calendar-empty"></i> November 21, 2013</a></li>
								</ul>-->
							</header>
							<div class="content-entry">
								<p><?php   
								$sp=explode(" ",$queryText);
								
								$ostr=substr($summary,0,300);
								$str=$ostr;
								foreach($sp as $keyword)
									$str = preg_replace("/\w*?".preg_quote($keyword)."\w*/i", "<b style=\"color:yellow;\"><i>$0</i></b>", $str);
								if($str==$ostr)
									$str=$resultset->getHighlighting()->getResult($id)->getField("content")[0];
								echo $str;
								  ?>....</p>
							</div>
							<footer>
								<a href="#" onclick="document.getElementById('pform<?php echo $id;?>').submit();" class="loopBigRdmr">READ MORE</a>
								<div class="circle rborder">
									 > 
								</div>
							</footer>
						</div>
					</div>
				</article>
					<?php
				}
				else
					echo "<h2 class=\"fword\">No results found!</h2>";
			}
			foreach ($resultset as $document) {

				// the documents are also iterable, to get all fields
			foreach ($document as $field => $value) {
			if (is_array($value)) {
					$value = implode(', ', $value);
				}
				if(!strcmp($field,"title"))
					$title=$value;
				else if(!strcmp($field,"content"))
					$content=$value;
				else if(!strcmp($field,"score"))
					$score=$value/$resultset->getMaxScore();
				else if(!strcmp($field,"id"))
				{
					$id=$value;
					
					$ch = curl_init("http://en.wikipedia.org/w/api.php?action=query&pageids=".$id."&prop=pageimages&format=json&pithumbsize=1000");

					curl_setopt($ch, CURLOPT_HTTPGET, true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Accept: application/json'
					));

					$result = curl_exec($ch);
					curl_close($ch);
					
					$darr = json_decode($result);
					$obj=$darr->query->pages;
					
					foreach($obj as $key=>$val)
					{
					if(isset($val->thumbnail->source))
						$img = $val->thumbnail->source;
					else	
						$img=null;
					}
					
					//$ch = curl_init("http://en.wikipedia.org/w/api.php?action=parse&pageid=".$id."&format=json&prop=text");
					$ch = curl_init("http://en.wikipedia.org/w/api.php?action=query&pageids=".$id."&format=json&prop=extracts");
					
					curl_setopt($ch, CURLOPT_HTTPGET, true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Accept: application/json'
					));

					$result = curl_exec($ch);
					curl_close($ch);
					
					$darr = json_decode($result);
					$obj=$darr->query->pages;
					
					foreach($obj as $key=>$val)
					{
						if(isset($val->extract))
							$summary=$val->extract;
					}

					
				}
			}
			
			?>
			<article>
					<div class="postloopBig">
						<div class="loopBigThumb" style="height:350px;background-color:#000000;">
							<?php
							if(isset($img))
							{
							?>
							<img src="<?php echo $img; ?>" alt="image"/>
							<?php
							}
							else
							{
							?>
							<h1 style="color:white;margin:20px 20px;"><?php echo $title; ?></h1>
							<?php
							}
							?>
							
							
						</div>
						<div class="loopBigAuthor">
						<form method="post" action="page" id="pform<?php echo $id; ?>">
						<input type="hidden" value="<?php echo $id; ?>" name="id" />
						<input type="hidden" value="<?php echo $score; ?>" name="score" />
						<input type="hidden" value="<?php echo $queryText; ?>" name="qtext" />
						<input type="hidden" value="<?php if(isset($img)) echo $img; else echo "" ?>" name="img" />
						<input type="hidden" value="<?php echo $title; ?>" name="title" />
						</form>
							
						</div>
						<div class="loopBigIsi">
							<header>
								<h2><a href="#" onclick="document.getElementById('pform<?php echo $id;?>').submit();"><?php echo $title; ?></a></h2>
								<!--<ul class="loopBigMeta inline-list">
									<li><a href="#"><i class="icon-bookmark-empty"></i> How To's</a></li>
									<li><a href="#"><i class="icon-calendar-empty"></i> November 21, 2013</a></li>
								</ul>-->
							</header>
							<div class="content-entry">
								<p><?php   
								$sp=explode(" ",$queryText);
								if(isset($summary))
								{
								$ostr=substr($summary,0,300);
								$str=$ostr;
								foreach($sp as $keyword)
									$str = preg_replace("/\w*?".preg_quote($keyword)."\w*/i", "<b style=\"color:yellow;\"><i>$0</i></b>", $str);
								}
								else
								{
								$str="a";
								$ostr=$str;
								}
								
								if($str==$ostr)
								{
									$obj=$resultset->getHighlighting()->getResult($id)->getField("content");
									if(count($obj)>0)
										$str=$obj[0];
								}
								echo $str;
								  ?>....</p>
							</div>
							<footer>
								<a href="#" onclick="document.getElementById('pform<?php echo $id;?>').submit();" class="loopBigRdmr">READ MORE</a>
								<div class="circle rborder">
									 > 
								</div>
							</footer>
						</div>
					</div>
				</article>
				<?php } ?>
				
				<div class="clearfix"></div>
				
			</div>
			
			
			<div class="grid_4">
			<div class="widgetbox grey">
					<h4><i class="icon-bookmark"></i> Top Keywords</h4>
					<ul class="categorylist">
				<?php
				$client = new \Solarium\Client(Config::get('solr'));
				$query = $client->createMoreLikeThis();
		// set a query (all prices starting from 12)
		$query->setQuery("\"".$queryText."\"");
		$query->setMltFields('content');
		$query->setQueryDefaultField('content');
		$query->setMinimumDocumentFrequency(1);
		$query->setMinimumTermFrequency(2);
		$query->setInterestingTerms('details');
		$query->setMatchInclude(true);
		$query->setMinimumWordLength(5);
		$query->setBoost(true);
		$query->setFields(array('title','score','timestamp'));
		$wikiresultset = $client->select($query);		
		$tags=$wikiresultset->getInterestingTerms();
		$i=0;
		foreach($tags as $key=>$val)
		{
					$i++;
					if($i<11)
					{
					$sp=explode(":",$key);
		?>
						<li><a href="search?queryText=<?php echo $sp[1]; ?>"><?php echo $sp[1]; ?></a></li>
						
						<?php } } ?>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		
		
	<div class="clearfix"></div>
	</section>
	
<?php include "footer.php" ?>