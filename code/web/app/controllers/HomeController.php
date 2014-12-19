<?php
class HomeController extends BaseController {
	
	/**
	 *
	 * @var The SOLR client.
	 */
	protected $client;
	protected $newsClient;
	const WIKIFILE = 'C:\wamp\www\dump\wiki_dump.xml';
	const NEWSDIR = 'C:\wamp\www\dump\NewsDump\*\*\*.xml';
	const TWITTERDIR = 'C:\wamp\www\dump\training.1600000.processed.noemoticon.csv';
	const NEWSIDSUFFIX = "_news";
	const TWEETIDSUFFIX = "_tweet";
	
	/**
	 * Constructor
	 */
	public function __construct() {
		set_time_limit ( 0 );
		$this->client = new \Solarium\Client(Config::get('solr'));
		$this->newsClient = new \Solarium\Client(Config::get('solr'));
	}
	
	public function importHandler() {
		$this->flushIndex();
		$this->addWikiIndex();
		$this->addNewsDocs();
		$this->indexTweets();
	}
	
	public function flushIndex() {
		$update = $this->client->createUpdate();
		$update->addDeleteQuery("*:*");
		$update->addCommit();
		$this->client->update($update);
		print "<br />Flushed Wiki Index<br />";
		
		$newsupdate = $this->newsClient->createUpdate();
		$newsupdate->addDeleteQuery("*:*");
		$newsupdate->addCommit();
		$this->newsClient->update($newsupdate);
		print "<br />Flushed News Index<br />";
	}
	
	public function addWikiIndex() {
		$z = new XMLReader ();
		$z->open (self::WIKIFILE);
		
		// move to the first <page /> node
		while ( $z->read () && $z->name !== 'page' )
			;
		$time_start = microtime ( true );
		$update = $this->client->createUpdate ();
		$i = 0;
		echo "Wait..";
		// now that we're at the right depth, hop to the next <page /> until the end of the tree
		while ( $z->name === 'page' && $i ++ >= 0 ) {
			$doct = new DOMDocument ();
			// $node = new SimpleXMLElement($z->readOuterXML());
			$node = simplexml_import_dom ( $doct->importNode ( $z->expand (), true ) );
			
			// now you can use $node without going insane about parsing
			// var_dump($node->element_1);
			
			if (stristr($node->title, 'Category') === FALSE && stristr($node->revision->text, '#REDIRECT') === FALSE)	{
				// echo $node->revision->contributor->id."<br />";
				$doc = $update->createDocument ();
				$doc->id = $node->id;
				$doc->title = $node->title;
				$doc->revision = $node->revision->id;
				$doc->author = $node->revision->contributor->username;
				$doc->authorid = $node->revision->contributor->id;
				$doc->timestamp = $node->revision->timestamp;
				$doc->content = $node->revision->text;
				/*
				 * if(strlen($node->id)>2) $doc->id = $node->id; else continue; if(strlen($node->title)>2) $doc->title = $node->title; else continue; if(strlen($node->revision->id)>2) $doc->revision = $node->revision->id; else continue; if(strlen($node->revision->timestamp)>2) $doc->timestamp = $node->revision->timestamp; else $doc->timestamp = ""; if(strlen($node->revision->contributor->username)>2) $doc->author = $node->revision->contributor->username; else continue; if(strlen($node->revision->contributor->id)>2) $doc->authorid = $node->revision->contributor->id; else $doc->authorid = " ";
				 */
				$update->addDocument ( $doc );
				
				if ($i % 1000 == 0) {
					$update->addCommit ();
					$result = $this->client->update ( $update );
					$update = $this->client->createUpdate ();
				}
			}
			
			// go to next <page />
			$z->next ( 'page' );
		}
		$time_end = microtime ( true );
		
		// dividing with 60 will give the execution time in minutes other wise seconds
		$execution_time = ($time_end - $time_start) / 60;
		echo '<br /><b>Total Execution Time:</b> ' . $execution_time . ' Mins';
		
		$update->addCommit ();
		$result = $this->client->update ( $update );
		
		return View::make ( 'home.index' );
	}
	
	
	public function addNewsDocs() {
		$update = $this->newsClient->createUpdate();
		$i = 0;
		$NoOfReset = 0;
		foreach (glob(self::NEWSDIR) as $currentFile) {
			$i++;
			$line = new XMLReader();
			$line->open($currentFile);
			$doc = $update->createDocument();
			$doct = new DOMDocument();
			while($line -> read()) {
				if($line->nodeType == XMLReader::ELEMENT) {
					if($line->name == "title") {
						$node = simplexml_import_dom($doct->importNode($line->expand(), true));
						$doc->title = $node;
					} elseif($line->name == "person") {
						$node = simplexml_import_dom($doct->importNode($line->expand(), true));
						$doc->person = $node;
					} elseif($line->name == "classifier") {
						$node = simplexml_import_dom($doct->importNode($line->expand(), true));
						if($node['type'] == "types_of_material") {
							$doc->category = $node;
						}
					} elseif ($line->name == "pubdata"){
						$node = simplexml_import_dom($doct->importNode($line->expand(), true));
						foreach($node->attributes() as $key => $value) {
							if(!strcmp($key,"date.publication")) {
								$doc->timestamp = date("Y-m-d\TH:i:s\Z", strtotime($value));
							} elseif(!strcmp($key,"ex-ref")) {
								$doc->link = urlencode($value);
							} elseif(!strcmp($key,"name")) {
								$doc->source = urlencode($value);
							}
						}
					}elseif($line->name == "doc-id") {
						$node = simplexml_import_dom($doct->importNode($line->expand(), true));
						$doc->id = $node->attributes() . self::NEWSIDSUFFIX;
					} elseif($line->name == 'block') {
						$node = simplexml_import_dom($doct->importNode($line->expand(), true));
						if($node['class'] == "full_text") {
							$content = "";
							foreach($node->p as $par) {
								$content = $content . $par;
							}
							$doc->newsContent = $content;
						}
					}					
				}
			}
			$update->addDocument($doc);
			if ($i % 1000 == 0) {
				$update->addCommit();
				$result = $this->newsClient->update($update);
				$update = $this->newsClient->createUpdate();
				$noOfFiles = $i + ($NoOfReset * 1000);
				print "Indexed and Comitted " . $noOfFiles . " files.<br />";
				$NoOfReset++;
			}
		}
		$update->addCommit();
		$result = $this->newsClient->update($update);
		print "Indexing Completed <br />";
		$totalFiles = $i + ($NoOfReset * 1000);
		print "Total Indexed Files :: " . $totalFiles;
	}
	
	public function indexTweets() {
		$handle = fopen(self::TWITTERDIR, "r");
		$update = $this->client->createUpdate();
		if($handle !== FALSE) {
			$NoOfReset = 0;$i = 0;$errorCounter = 0;
			 while (($data = fgetcsv($handle, 1000, ",","\"")) !== FALSE) {
			 	if(sizeof($data) > 0) {
			 		$i++;
					$doc = $update->createDocument();
					$doc->id = $data[1] . self::TWEETIDSUFFIX;
					$doc->author = $data[4];
					$doc->timestamp = date("Y-m-d\TH:i:s\Z", strtotime($data[2]));
			 		$doc->tweetContent = $data[5];
			 		$update->addDocument($doc);
			 		if ($i % 10000 == 0) {
			 			$update->addCommit();
			 			$result = $this->client->update($update);
			 			$update = $this->client->createUpdate();
			 			$noOfFiles = $i + ($NoOfReset * 10000);
			 			print "Indexed and Comitted " . $noOfFiles . " Tweets.<br />";
			 			$NoOfReset++;
			 		}
			 	}
			 }
			 
			 $update->addCommit();
			 $result = $this->client->update($update);
			 print "Total Prob Tweets :: " . $errorCounter;
			 print "Indexing Completed <br />";
			 $totalFiles = $i + ($NoOfReset * 10000);
			 print "Total Indexed Tweets :: " . $totalFiles;
		}
	}
	
	/*
	 * |-------------------------------------------------------------------------- | Default Home Controller |-------------------------------------------------------------------------- | | You may wish to use controllers instead of, or in addition to, Closure | based routes. That's great! Here is an example controller method to | get you started. To route to this controller, just add the route: | |	Route::get('/', 'HomeController@showWelcome'); |
	 */
	public function showResults() {
		$queryText=Input::get('queryText');
		if($queryText==null)
			return Redirect::to('/');
		// get a select query instance
			$query = $this->client->createSelect();
		// set a query (all prices starting from 12)
		$query->setQuery("title:\"".$queryText."\"");
		$hl = $query->getHighlighting();
		$hl->getField('title')->setSimplePrefix('<b style=\"color: #6BAE48;\"><i>')->setSimplePostfix('</i></b>')->setFragSize(300);
		$hl->getField('content')->setSimplePrefix('<b style=\"color: yellow;\"><i>')->setSimplePostfix('</i></b>')->setFragSize(300);
		
		// set fields to fetch (this overrides the default setting 'all fields')
		$query->setFields(array('title', 'content', 'id', 'score'));

		// this executes the query and returns the result
		$resultset = $this->client->select($query);

		if($resultset->getNumFound()==0)
		{
					$ch = curl_init("http://en.wikipedia.org/w/api.php?action=query&prop=revisions&rvprop=content&format=json&titles=".urlencode($queryText));
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
						if(!isset($val->missing))
						{
							
							foreach($val->revisions[0] as $k=>$v);
							if (strpos($v,'REDIRECT') !== false) {
								$sp=explode('[[',$v);
								$sp=explode(']',$sp[1]);
								$ch = curl_init("http://en.wikipedia.org/w/api.php?action=query&prop=revisions&rvprop=content&format=json&titles=".$sp[0]);
					
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
								
								foreach($obj as $a=>$b)
									return View::make ( 'results' )->with('title', $b->title)->with('id', $b->pageid)->with('resultset', $resultset)->with('queryText', $queryText);				
								
								}
							return View::make ( 'results' )->with('title', $val->title)->with('id', $val->pageid)->with('resultset', $resultset)->with('queryText', $queryText);		
						}
					}
		}
		else
			return View::make ( 'results' )->with('resultset', $resultset)->with('queryText', $queryText);
		
		// get a select query instance
		$query = $this->client->createSelect();
		// set a query (all prices starting from 12)
		$query->setQuery("title:".$queryText." content:\"".$queryText."\"");
	// set fields to fetch (this overrides the default setting 'all fields')
		$query->setFields(array('title','score', 'content', 'id'));
		$hl = $query->getHighlighting();
		$hl->getField('title')->setSimplePrefix('<b style=\"color: #6BAE48;\"><i>')->setSimplePostfix('</i></b>')->setFragSize(300);
		$hl->getField('content')->setSimplePrefix('<b style=\"color: yellow;\"><i>')->setSimplePostfix('</i></b>')->setFragSize(300);
		// this executes the query and returns the result
		
		
		// add spellcheck settings
		$spellcheck = $query->getSpellcheck();
		$spellcheck->setQuery("title:".+$queryText." content:\"".$queryText."\"");
		//$spellcheck->setBuild(true);
		$spellcheck->setDictionary("default");
		$spellcheck->setCollate(true);
		$spellcheck->setExtendedResults(false);
		$spellcheck->setOnlyMorePopular(true);
		$spellcheck->setCount(3);
		$resultset = $this->client->select($query);
		$spellcheckResult = $resultset->getSpellcheck();
		if(isset($spellcheckResult))
		foreach ($spellcheckResult as $suggestion) {
			$words=$suggestion->getWords();
		}
		
		if(isset($words))
		return View::make ( 'results' )->with('words',$words)->with('resultset', $resultset)->with('queryText', $queryText);
		else
		return View::make ( 'results' )->with('resultset', $resultset)->with('queryText', $queryText);
		//return View::make ( 'home.index' )->with('resultset', $resultset)->with('queryText', $queryText);
		
	}
	public function autocomplete()
	{
		//http://localhost:8983/solr/suggest?suggest=true&suggest.q=A
		// get a suggester query instance
			$q=Input::get('term');
			$ch = curl_init(Config::get('host')."/solr/search2/suggest?suggest=true&suggest.q=".$q."&wt=json");
			
			curl_setopt($ch, CURLOPT_HTTPGET, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Accept: application/json'
			));
			$stack=array();
			$result = curl_exec($ch);
			curl_close($ch);
			$jsonobj=json_decode($result);
			$arr=$jsonobj->suggest->mySuggester;
			
			if(isset($arr->$q))
			{
				$arr=$arr->$q->suggestions;
				
			foreach($arr as $result){
					//echo '- '.$result.'<br/>';
					array_push($stack, $result->term);
				}
			return json_encode($stack);		
			}
			else
				return "";
			
			/*$query = $this->client->createSuggester();
			$query->setQuery($q); //multiple terms
			$query->setDictionary('mySuggester');
			$query->setOnlyMorePopular(true);
			$query->setCount(5);
			//$query->setCollate(true);
	 
			// this executes the query and returns the result
			$resultset = $this->client->suggester($query);

			foreach ($resultset as $term => $termResult) {
			return "av";
			foreach($termResult as $result){
					echo '- '.$result.'<br/>';
					
				}
			}
			return var_dump($resultset);
			*/
	}
	public function showPage()
	{
		$id=Input::get('id');
		$title=Input::get('title');
		$qtext=Input::get('qtext');
		$img=Input::get('img');
		$score=Input::get('score');

		

		//http://localhost:8983/solr/search2/mlt?q=Sachin%20Tendulkar&mlt.fl=tweetContent&mlt.mindf=5&mlt.mintf=1&mlt.minwl=4&mlt.boost=true&fl=author,tweetContent,score&df=tweetContent
		//http://localhost:8983/solr/search2/mlt?q=%22Sachin%20Tendulkar%22&mlt.fl=content&mlt.mindf=2&mlt.mintf=2&mlt.boost=true&fl=content,score,title&df=title&mlt.interestingTerms=details&mlt.sort=timestamp%20desc&mlt.minwl=5
		//http://localhost:8983/solr/search2/mlt?q=president&mlt.fl=title,newsContent&mlt.mindf=1&mlt.mintf=1&fl=title,newsContent&df=content
		// DO MLT for news and twitter
		
					$ch = curl_init("http://en.wikipedia.org/w/api.php?action=parse&pageid=".$id."&format=json&prop=text");
					
					curl_setopt($ch, CURLOPT_HTTPGET, true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Accept: application/json'
					));

					$result = curl_exec($ch);
					curl_close($ch);
					
					$darr = json_decode($result);
					if(!isset($darr->error))
					{
					$title=$darr->parse->title;
					
					$obj=$darr->parse->text;
					
					foreach($obj as $key=>$val)
					{
						$HTMLcontent=$val;
					}
					$pieces = explode("<span class=\"mw-headline\" id=\"References\">References</span>", $HTMLcontent);
					$HTMLcontent=$pieces[0]."</span>";	
					
					$HTMLcontent=preg_replace("/<span>\[<\/span>\d+<span>\]<\/span>/","",$HTMLcontent);
					$HTMLcontent = str_replace("class=\"noprint", "style=\"display:none; class=\"noprint", $HTMLcontent);
					$HTMLcontent = str_replace("\"/wiki/", "\"http://en.wikipedia.org/wiki/", $HTMLcontent);
					$HTMLcontent = str_replace("<span class=\"mw-editsection\">", "<div class=\"clearfix\"></div><div class=\"devide totalrating\"></div><span style=\"display:none\">", $HTMLcontent);
					$HTMLcontent = str_replace("class=\"thumbborder\"", "style=\"display:none;\"", $HTMLcontent);
					}
					else
					{
					$HTMLcontent="";
					}
		// get a select query instance
		$query = $this->client->createMoreLikeThis();
		// set a query (all prices starting from 12)
		$query->setQuery("\"".$title."\"");
		$query->setMltFields('content');
		$query->setQueryDefaultField('content');
		$query->setMinimumDocumentFrequency(1);
		$query->setMinimumTermFrequency(2);
		$query->setInterestingTerms('details');
		$query->setMatchInclude(true);
		$query->setMinimumWordLength(5);
		$query->setBoost(true);
		$query->setFields(array('title','score','timestamp'));

		$wikiresultset = $this->client->select($query);		
		$tags=$wikiresultset->getInterestingTerms();
		
		// get a select query instance
		$query = $this->client->createMoreLikeThis();
		// set a query (all prices starting from 12)
		$query->setQuery($title);
		$query->setMltFields('tweetContent');
		$query->setQueryDefaultField('tweetContent');
		$query->setMinimumDocumentFrequency(1);
		$query->setMinimumTermFrequency(1);
		$query->setInterestingTerms('details');
		$query->setMatchInclude(true);
		$query->setMinimumWordLength(4);
		$query->setBoost(true);
		$query->setFields(array('author','tweetContent','score','timestamp'));

		// this executes the query and returns the result
		$resultset = $this->client->select($query);		

		// get a select query instance
		$query = $this->client->createMoreLikeThis();
		// set a query (all prices starting from 12)
		$query->setQuery($title);
		$query->setMltFields('newsContent');
		$query->setQueryDefaultField('newsContent');
		$query->setMinimumDocumentFrequency(1);
		$query->setMinimumTermFrequency(2);
		$query->setInterestingTerms('details');
		$query->setMatchInclude(true);
		$query->setMinimumWordLength(5);
		$query->setBoost(true);
		$query->setFields(array('newsContent','person','score','link','title'));

		// this executes the query and returns the result
		$nresultset = $this->client->select($query);		
		
					//return $HTMLcontent;
					return View::make ( 'page' )->with('wikiresultset',$wikiresultset)->with('tags', $tags)->with('resultset', $resultset)->with('nresultset', $nresultset)->with('queryText',$title)->with('qtext',$qtext)->with('img',$img)->with('score',$score)->with('HTMLcontent', $HTMLcontent);
	}
}
