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

class GiaoDucController extends Controller
{
     // Sử dụng cơ sở dữ liệu về giáo dục
    // Cái này cũ rồi ae không làm nữa
    
	public function get_view_giao_duc(){
		return view('giao_duc.master');
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
        // dd($docs);
        $numResult      = $numFound ;
        $timeSearch     = $QTime;
        $flag = true;

        // luu lai lich su search;
        $thongke = new KeySearch;
        $thongke->key = $request->search;
        $thongke->save();

        // Phan trang ket qua tim kiem
        $page = Input::get('page',1);
        $perpage = 10;
        $offset = ($page*$perpage) - $perpage;
        $json_doc = new LengthAwarePaginator(array_slice($docs,$offset,$perpage,true),count($docs),$perpage,$page,['path'=>$request->url(),'query'=> $request->query()]);
        // dd($request->query());
        $recommend_keys = "";

        return view('giao_duc.result',
                    [
                    'flag' => $flag,
                    'docs'=>$json_doc,
                    'numFound'=>$numFound,
                    'numResult'=>$numResult,
                    'timeSearch' => $timeSearch,
                    'key' => $key,
                    'results '=> $results ,
                    ]
        );
    }
    public function get_real_time_key(Request $request){

    }
    
}
