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
Route::get('/','SolrController@get_view_tong_hop');
Route::get('demo/nlp','SolrController@get_NLP');


// Data giao duc
Route::get('solr/search/giao_duc','GiaoDucController@get_view_giao_duc');
Route::get('solr/api/get/giao_duc','GiaoDucController@get_solr_giao_duc_api');

// Data tong hop
Route::get('solr/search/tong_hop','SolrController@get_view_tong_hop');
Route::get('solr/api/get/tong_hop','SolrController@get_solr_tong_hop_api');
Route::get('solr/api/get/tong_hop/key_real_time','SolrController@key_real_time');

// Su dung cho du lieu  duoc filetr theo tieng viet
Route::get('solr/search/vi_data','Vi_DataController@get_view_vi_data');
Route::get('solr/api/get/vi_data','Vi_DataController@get_solr_vi_data_api');
Route::get('solr/api/get/vi_data/key_real_time','Vi_DataController@key_real_time');


// NLP for searching
Route::get('solr/flask/themdau','SolrController@get_themdau');
Route::get('solr/search/thong-ke','SolrController@get_thongke');
Route::get('solr/check_spell','SolrController@spell_check');
Route::get('solr/del/db','SolrController@delete_all_db');
