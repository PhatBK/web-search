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

use NlpTools\Tokenizers\WhitespaceTokenizer;
use NlpTools\Similarity\CosineSimilarity;

class SolrController extends Controller
{
    
    // Sử dụng cơ sở dữ liệu về giáo dục
    // Cái này cũ rồi ae không làm nữa
	public function get_view_giao_duc(){
		return view('giao_duc.master');
	}
    public function post_solr_giao_duc_api(Request $request){

    	$key = $request->search;
        // dd($request->all());
        // Create a client with a base URI
        $client = new Client(['base_uri' => 'http://127.0.0.1:8983/solr/search/']);

        /* 
         * Phần xây dựng các truy vấn khác nhau
         * Mỗi Truy vấn là một bộ tham số khác nhau
         * Cần xây dựng một cơ số truy vấn để vẽ đường cong đánh giá
         * Ahihi
        */
        // xây dựng truy vấn trên các trường của dữ liệu
        $response_content   = $client->request('GET', 'select?df=Content&q='.$key.'&rows=100');
        $response_title     = $client->request('GET', 'select?df=Title&q='.$key.'&rows=100');
        $response_url       = $client->request('GET', 'select?df=Url&q='.$key.'&rows=100');

        // lấy tất cả dữ liệu
        $response_all = $client->request('GET', 'select?q='.$key.'&rows=100');

        // Lay phan noi dung
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


        return view('giao_duc.result',
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
    public function get_solr_giao_duc_api(Request $request){
        $key = $request->search;
        // dd($request->all());
        // Create a client with a base URI
        $client = new Client(['base_uri' => 'http://127.0.0.1:8983/solr/search/']);

        /*Phần xây dựng các truy vấn khác nhau
         *Mỗi Truy vấn là một bộ tham số khác nhau
         * Cần xây dựng một cơ số truy vấn để vẽ đường cong đánh giá
         * Ahihi
        */
        // xây dựng truy vấn trên các trường của dữ liệu
        $response_content   = $client->request('GET', 'select?df=Content&q='.$key.'&rows=100');
        $response_title     = $client->request('GET', 'select?df=Title&q='.$key.'&rows=100');
        $response_url       = $client->request('GET', 'select?df=Url&q='.$key.'&rows=100');

        // lấy tất cả dữ liệu
        $response_all = $client->request('GET', 'select?q='.$key.'&rows=100');
        
        // Lay phan noi dung
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
        $numFound       = $response['numFound'];
        $start          = $response['start'];
        $docs           = $response['docs'];
        $numResult      = $numFound ;
        $timeSearch     = $QTime;
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


        return view('giao_duc.result',
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




    // 15/05/2018 
    // Sử dụng cơ sở dữ liệu về kinh tế,giáo dục hỗn hợp
    // ae làm trên cái này nhé
    public function get_view_tong_hop(){
        return view('tong_hop.master');
    }
    public function get_solr_tong_hop_api(Request $request){

        $key = $request->search;
        // dd(split_key_search($key));

        $client = new Client(['base_uri' => 'http://127.0.0.1:8983/solr/tong_hop/']);
        /* 
         * Phần xây dựng các truy vấn khác nhau
         * Mỗi Truy vấn là một bộ tham số khác nhau
         * Cần xây dựng một cơ số truy vấn để vẽ đường cong đánh giá
         * Ahihi
        */
        // xây dựng truy vấn trên các trường của dữ liệu
        $response_content   = $client->request('GET', 'select?df=Content&q='.$key.'&rows=100');
        $response_title     = $client->request('GET', 'select?df=Title&q='.$key.'&rows=100');
        $response_url       = $client->request('GET', 'select?df=Url&q='.$key.'&rows=100');
        $response_all       = $client->request('GET', 'select?q='.$key.'&rows=100');

        // Lay phan noi dung theo cac truy van khac nhau
        $content_content = $response_content->getBody();
        $content_title = $response_title->getBody();
        $content_url = $response_url->getBody();
        /*
            chu y: json_decode($json) ==> object(stdClass)
            con : json_decode($json,true) ==> array()
            link:http://php.net/manual/en/function.json-decode.php
        */
        $results        = json_decode($content_content->getContents(),true);

        $responseHeader = $results['responseHeader'];
        $status         = $responseHeader['status'];
        $QTime          = $responseHeader['QTime'];

        $response       = $results['response'];
        $numFound       = $response['numFound'];
        $start          = $response['start'];
        $docs           = $response['docs'];
        $numResult      = $numFound ;
        $timeSearch     = $QTime;
        $flag = true;
        if($request->search != "" && $request->search != " "){
            $thongke = new KeySearch;
            $thongke->key = $request->search;
            $thongke->save();
        }
        
        return view('tong_hop.result',
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
    public function key_real_time(Request $request){
        $key = $request->key;
        $data = [];
        $i = 0;
        $client = new Client(['base_uri' => 'http://127.0.0.1:8983/solr/tong_hop/']);
        $response_content   = $client->request('GET', 'select?df=Content&q='.$key.'&rows=5');
        $content_content = $response_content->getBody();
        $results        = json_decode($content_content->getContents(),true);

        $response       = $results['response'];
        $docs           = $response['docs'];
        foreach ($docs as $doc) {
            // $data = $doc['Title'][0];
            array_push($data,$doc['Title'][0]);
        }
        
        return response()->json($data,200);
    }
    
    public function get_NLP(){
        
        function getWikipediaPage($page) {
            ini_set('user_agent', 'NlpToolsTest/1.0 (tests@php-nlp-tools.com)');
            $page = json_decode(file_get_contents("http://en.wikipedia.org/w/api.php?format=json&action=parse&page=".urlencode($page)),true);
            return preg_replace('/\s+/',' ',strip_tags($page['parse']['text']['*']));
        }
        $tokenizer = new WhitespaceTokenizer();
        $sim = new CosineSimilarity();
         
        $aris = $tokenizer->tokenize(getWikipediaPage('Aristotle'));
        $archi = $tokenizer->tokenize(getWikipediaPage('Archimedes'));
        $einstein = $tokenizer->tokenize(getWikipediaPage('Albert Einstein'));
         
        $aris_to_archi = $sim->similarity(
            $aris,
            $archi
        );
         
        $aris_to_albert = $sim->similarity(
            $aris,
            $einstein
        );
         
        dd($aris_to_archi,$aris_to_albert);

    }

    public function get_thongke(){
        $key_searchs = KeySearch::all();
        dd($key_searchs);
    }
}
