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

// Get view
Route::get('/','SolrController@get_view_giao_duc');
Route::get('demo/nlp','SolrController@get_NLP');


// Data giao duc
Route::get('solr/search/giao_duc','GiaoDucController@get_view_giao_duc');
Route::post('solr/api/post/giao_duc','GiaoDucController@post_solr_giao_duc_api');
Route::get('solr/api/get/giao_duc','GiaoDucController@get_solr_giao_duc_api');

// Data tong hop
Route::get('solr/search/tong_hop','SolrController@get_view_tong_hop');
Route::post('solr/api/post/tong_hop','SolrController@post_solr_tong_hop_api');
Route::get('solr/api/get/tong_hop','SolrController@get_solr_tong_hop_api');
Route::get('solr/api/get/tong_hop/key_real_time','SolrController@key_real_time');

// NLP for searching
Route::get('solr/flask/themdau','SolrController@get_themdau');
Route::get('solr/search/thong-ke','SolrController@get_thongke');
