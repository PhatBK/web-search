<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Phat Nguyen
Route::get('/', function () {
    return view('welcome');
});

Route::get('solr/search','SolrController@get_solr');
Route::post('solr/api/post','SolrController@post_solr');


Route::get('solr/flask/themdau','SolrController@get_themdau');
Route::get('solr/search/thong-ke','SolrController@get_thongke');

// Hoan Vu
Route::get('test',function(){
	return "hello";
});
Route::get('/ping', 'SolariumController@ping');

Route::get('/suggest', 'SolariumController@suggest');
Route::get('/search', 'SolariumController@getSearch');
Route::get('/result', [
	'as'=>'ketqua',
	'uses'=>'SolariumController@result'
]);