NewsRoom
========

###Deno
http://youtu.be/DplR6aqGeUY

###Installation

1) Open the directory containing solr, replace the solr configuration files schema.xml and solrconfig.xml from code/solr directory.

2) Edit code/web/app/controllers/HomeController.php line number 10, 11, 12 to specify the locations for the dump for wiki, news and twitter.

3) Edit code/web/app/config/solr.php to configure the solr core name and path.

4) Run solr jetty server, deploy the entire web folder in wampp or any php supported server and run http://127.0.0.1/NewsRoom/web/public/ to start and experience the NEWSROOM
###Features
*	Newsroom serves the Wikipedia articles, the contextually related news stories from The New York Times and the related tweets, all in one place. 

*	Dynamic Indexing On the Go: Newsroom does not intend to disappoint the users when the existing Index does not contain the documents that the users are looking for. The concept of ‘Near’ real-time indexing is incorporated in such a way that the system queries the original source of Wikipedia articles and indexes them so that they are readily available for search after being indexed. 

*	Spell-Checker: 
To ease the users’ efforts to know the correct spelling of the terms being queried, the Newsroom’s ”Did you mean?” feature provides the alternate correct spelling suggestions considering the phonetics of the terms. The users shall be able to provide the correct intended search query by merely choosing the best option from the listed spelling suggestions in case of a faulty query input. An interactive spelling correction facility that presents possible appropriate corrections to their erroneous queries would improve the system in terms of precision, recall and user-effort. 

* Auto-Complete: 
The system provides search predictions that might sound similar to the search terms dynamically in real-time as the user types in the search box.

*	Hot Trends and Content Tags: 
The user shall get to see the trending categories across the medium and a list of important keywords extracted out of the content that’s currently viewed. The user can also continue to search based on these keywords by just clicking on them.

*	Related Wikipedia Articles:  
In addition to the related tweets and the news stories, the users are provided with the links to the related Wikipedia articles as well. 
*	Relevancy Percentage: 
The users shall know the measure of how relevant the document, that is currently being viewed, to the search query in terms of a percentage on the UI. 
