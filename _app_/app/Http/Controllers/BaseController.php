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
use DB;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

use NlpTools\Tokenizers\WhitespaceTokenizer;
use NlpTools\Similarity\CosineSimilarity;

class BaseController extends Controller
{
  
    public function get_view_base(){
        return view('base.master');
    }
    public function get_solr_base_api(Request $request){

        $key = $request->search;

        $key_n = preg_replace('/[\:]/',"",$key);
        $spell= $this->spell_check($key_n);
        
        if($spell != null){
            $key_s = $spell;
        }else{
            $key_s = $key_n;
        }
        
        $client = new Client(['base_uri' => 'http://127.0.0.1:8983/solr/base_index/']);

        $response_content   = $client->request('GET', 'select?df=Content&q='.$key_s.'&rows=100');

        $response_title     = $client->request('GET', 'select?df=Title&q='.$key_s.'&rows=100');
        $response_url       = $client->request('GET', 'select?df=Url&q='.$key_s.'&rows=100');

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
        // dd($docs);
        $numResult      = $numFound ;
        $timeSearch     = $QTime;
        $flag = true;

        // Phần phân trang kết quả tìm kiếm
        $page = Input::get('page',1);
        $perpage = 10;
        $offset = ($page*$perpage) - $perpage;
        $json_doc = new LengthAwarePaginator(array_slice($docs,$offset,$perpage,true),count($docs),$perpage,$page,['path'=>$request->url(),'query'=> $request->query()]);


        // luu lai tu khoa
        if($page == 1){
            if($request->search != "" && $request->search != " "){
            // $key_l  = mb_strtolower($request->search, 'UTF-8');
                $thongke = new KeySearch;
                $thongke->key = $request->search;
                $thongke->save();
            }
        }
        // Phần trả lại kết quả cho giao diện
        $suggestions = KeySearch::all();

        return view('base.result',
                    [
                    'flag' => $flag,
                    'docs'=>$json_doc,
                    'numFound'=>$numFound,
                    'numResult'=>$numResult,
                    'timeSearch' => $timeSearch,
                    'key' => $key,
                    'results '=> $results ,
                    'spell' => $spell,
                    'suggestions' => $suggestions
                    ]
        );
    }
    public function key_real_time(Request $request){
        $key = $request->key;
        $data = [];
        $i = 0;
        $client = new Client(['base_uri' => 'http://127.0.0.1:8983/solr/base_index/']);
        $response_content   = $client->request('GET', 'select?q='.$key.'&rows=5');
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
         
        $aris = $tokenizer->tokenize(getWikipediaPage('Hom nay toi di hoc'));
        $archi = $tokenizer->tokenize(getWikipediaPage('hom nay'));
        $einstein = $tokenizer->tokenize(getWikipediaPage('Toi di hoc'));
         
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
    public function jaccard($string1,$string2){
        $arr1 = preg_split('/\s+/', $string1, -1, PREG_SPLIT_NO_EMPTY);
        $arr2 = preg_split('/\s+/', $string2, -1, PREG_SPLIT_NO_EMPTY);
        $arr_giao_temp=array();
        for($i=0;$i<count($arr1);$i++){
            for($j=0;$j<count($arr2);$j++){
                if($arr1[$i]==$arr2[$j]){
                    array_push($arr_giao_temp,$arr1[$i]);
                }
            }
        }
        $arr_giao=array_unique($arr_giao_temp);
        $arr_hop_temp=array();
        for($i=0;$i<count($arr1);$i++){
            array_push($arr_hop_temp,$arr1[$i]);
        }
        for($i=0;$i<count($arr2);$i++){
            array_push($arr_hop_temp,$arr2[$i]);
        }
        $arr_hop=array_unique($arr_hop_temp);
        $jaccard=count($arr_giao)/count($arr_hop);
        return $jaccard;
    }
    public function spell_check($string){
        // $tukhoa_suggest=DB::table('key_search')
        //                                         ->select(DB::raw('key,count(*) as soluong'))
        //                                         ->groupBy('key')
        //                                         ->orderBy('soluong','desc')
        //                                         ->take(20)
        //                                         ->get();
        $tukhoa_suggest = DB::table('key_search')->distinct()->get();

        foreach ($tukhoa_suggest as $sg){
            $jaccard=$this->jaccard($sg->key,$string);
            if(0.53<$jaccard and $jaccard < 1){
                return $sg->key;
            }
        }
        return null;
    }
    public function get_top_key(){
        $result = DB::table('key_search')
                                                ->select(DB::raw('count(*) as soluong'))
                                                ->groupBy('key')
                                                ->orderBy('soluong','desc')
                                                ->take(20)
                                                ->get();
        dd($result);
    }
}
