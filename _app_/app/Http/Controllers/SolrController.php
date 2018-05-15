<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use App\Models\KeySearch;
use function GuzzleHttp\json_decode;

class SolrController extends Controller
{
	public function get_view(){
		return view('solr.view');
	}
	public function get_solr(){
		return view('solr.master');
	}
    public function post_solr(Request $request){

    	$key = $request->search;
        // dd($request->all());

        // Create a client with a base URI
        $client = new Client(['base_uri' => 'http://127.0.0.1:8983/solr/search/']);

        // xây dựng truy vấn trên các trường của dữ liệu
        $response_content   = $client->request('GET', 'select?df=Content&q='.$key.'&rows=100');
        $response_title     = $client->request('GET', 'select?df=Title&q='.$key.'&rows=100');
        $response_url       = $client->request('GET', 'select?df=Url&q='.$key.'&rows=100');
        // lấy tất cả dữ liệu
        $response_all = $client->request('GET', 'select?q='.$key.'&rows=100');


        $content_content = $response_content->getBody();

        $content_title = $response_title->getBody();

        $content_url = $response_url->getBody();
/*
	chu y: json_decode($json) ==> object(stdClass)
	con : json_decode($json,true) ==> array()
	link:http://php.net/manual/en/function.json-decode.php
*/
        $results        = json_decode($content_content->getContents(),true);

        // $results_title     = json_decode($content_title->getContents(),true);
        // dd($results_1);
        // $results_url     = json_decode($content_url->getContents(),true);
        // dd($results_2);

        $responseHeader = $results['responseHeader'];
        $status         = $responseHeader['status'];
        $QTime          = $responseHeader['QTime'];

        $response       = $results['response'];
        $numFound 		= $response['numFound'];
        $start 			= $response['start'];
        $docs 			= $response['docs'];
        $numResult 		= $numFound ;
        $timeSearch		= $QTime;
        $flag = true;

        // luu lai lich su search;
        $thongke = new KeySearch;
        $thongke->key = $request->search;
        $thongke->save();

        // Phan trang ket qua tim kiem
        $page = Input::get('page',1);
        $perpage = 5;
        $offset = ($page*$perpage) - $perpage;
        $json_doc = new LengthAwarePaginator(array_slice($docs,$offset,$perpage,true),count($docs),$perpage,$page,['path'=>$request->url(),'query'=> $request->query()]);
        // dd($request->query());


        return view('solr.result',
		        	[
		        	'flag' => $flag,
		        	'docs'=>$docs,
		        	'numFound'=>$numFound,
		        	'numResult'=>$numResult,
		        	'timeSearch' => $timeSearch,
                    'key' => $key,
                    'results '=> $results ,
		            ]
		);
    }





    public function get_themdau(){
        
    }
    public function rank_result_my(){

    }
    public function post_search(){

    }
    public function get_cookie(){

    }
    public function get_thongke(){
        $key_searchs = KeySearch::all();
        dd($key_searchs);
    }
}
