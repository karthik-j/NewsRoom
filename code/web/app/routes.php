<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
//Route::controller('/', 'HomeController');
Route::get('/importwiki',array('uses'=>'HomeController@addWikiIndex'));
Route::get('/importnews',array('uses' => 'HomeController@addNewsDocs'));
Route::get('/flushimport',array('uses' => 'HomeController@importHandler'));
Route::get('/flush_index',array('uses' => 'HomeController@flushIndex'));
Route::get('/importtweets',array('uses' => 'HomeController@indexTweets'));
Route::get('/search',array('uses'=>'HomeController@showResults'));
Route::post('/page',array('uses'=>'HomeController@showPage'));
Route::get('/page', function()
{
	return Redirect::to('/');
});
Route::get('/autocomplete',array('uses'=>'HomeController@autocomplete'));
Route::get('/', function()
{
	//return View::make('hello');
	    return View::make('index');
});
Route::get('/home', function()
{
	return Redirect::to('/');
});