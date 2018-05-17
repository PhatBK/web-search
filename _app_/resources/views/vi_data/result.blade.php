@extends('vi_data.master')
@section('content')
<div class="container">
    <hr>
    <i>Khoảng: &nbsp; <u>{{ $numResult }}</u> &nbsp;kết quả (khoảng:&nbsp;<u>{{ $timeSearch }}</u>&nbsp;giây)</i><br><br>
    <div style="text-align: center;">{!! $docs->links() !!}</div> 
    <br>
    @foreach ($docs as $doc)
        <div class="form-group">
            {{-- <b style="color: red;"> {{ $doc['Title'][0] }} </b><br><br> --}}
            <b {{-- style="color: red;" --}}>
             @php
                 $title  = $doc['Title'][0];
                 $result = str_replace("".$key."",'<b style="color:blue;">'."".$key."".'</b>',$title);
                 
                 // dd(mb_convert_case ($key, MB_CASE_TITLE, 'UTF-8')); 
                 // dd(mb_strtolower($key, 'UTF-8'));

                 $key_l  = mb_strtolower($key, 'UTF-8');
                 $key_u  = mb_convert_case ($key, MB_CASE_TITLE, 'UTF-8');

                 $key_l_o   = preg_split("/[\s,]+/",$key_l);
                 $key_u_o   = preg_split("/[\s,]+/",$key_u);
                 
                 $key_all = array_merge($key_l_o, $key_u_o);
            
                 //    array_push($new_l,lcfirst($kl));
                 //    array_push($new_u,ucfirst($ku));
                
                 foreach ($key_all as $key1) {
                    $kq  =  str_replace("".$key1."",'<b style="color:blue;">'."".$key1."".'</b>',$result);
                    $result = $kq;
                 } 
                echo $result ;
             @endphp
            </b>
             <br><br>
            <p>Link:<a href="{{ $doc['Url'][0] }}" target="_blank">{{ $doc['Url'][0] }}</a></p>
            <br>
            {{-- <p>{{ $doc['Content'][0] }}</p> --}}
            <p>
                @php
                    $results = $doc['Content'][0];
                    $results_kq = str_replace("".$key."",'<b style="color:blue;">'."".$key."".'</b>',$results);
                   
                    $key_l  = mb_strtolower($key, 'UTF-8');
                    $key_u  = mb_convert_case ($key, MB_CASE_TITLE, 'UTF-8');
                    $key_l_o   = preg_split("/[\s,]+/",$key_l);
                    $key_u_o   = preg_split("/[\s,]+/",$key_u);
                    $key_all = array_merge($key_l_o, $key_u_o);

                    foreach($key_all as $key1){
                        $content = str_replace("".$key1."",'<b style="color:blue;">'."".$key1."".'</b>',$results_kq);
                        $results_kq = $content;
                      
                    }
                    echo $results_kq;
                @endphp
            </p>
        </div>
        <div class="row">
            <div class="col-md-6" style="text-align: center;">
                <i>Tác Giả</i>:&nbsp;<b>{{ $doc['Author'][0] }}</b>
            </div>
            <div class="col-md-6" style="text-align: center;">
                <i>Ngày Đăng</i>:&nbsp;<b>{{ $doc['Time'][0] }}</b>
            </div>
        </div>
        <hr>   
    @endforeach
    {{--  <div style="text-aligin:center;">{!! $docs->links() !!}</div>  --}}
    <div style="text-align: center;">{!! $docs->links() !!}</div> 
</div>
@endsection