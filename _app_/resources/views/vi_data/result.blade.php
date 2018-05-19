@extends('vi_data.master')
@section('content')
<div class="container">
    <hr>
    <i>Khoảng: &nbsp; <u>{{ $numResult }}</u> &nbsp;kết quả (khoảng:&nbsp;<u>{{ $timeSearch }}</u>&nbsp;giây)</i>
    <br>
    @if ($spell != null)
        <i style="font-size: 15px;">Mọi người cũng hay tìm kiếm:&nbsp;</i><u>{{ $spell }}</u>
    @endif

    <div style="text-align: center;">{!! $docs->links() !!}</div> 
    <br>
    @foreach ($docs as $doc)
        <div class="form-group">
            <b>
             @php
                 $title  = $doc['Title'][0];
                 $key_n = preg_replace('/[\:]/',"",$key);
                 $result = str_replace(" ".$key_n." ",'<b style="color:blue;">'." ".$key_n." ".'</b>',$title);
                 
                 $key_all = preg_split("/[\s,]+/",$key_n);
            

                 foreach ($key_all as $key1) {
                    $kq  =  str_replace(" ".$key1." ",'<b style="color:blue;">'." ".$key1." ".'</b>',$result);
                    $kq  =  preg_replace('/'.$key1.'/','<b style="color:blue;">'." ".$key1." ".'</b>',$kq); 
                    $result = $kq;
                 } 
                echo $result ;
             @endphp
            </b>
             <br><br>
            <p>Link:<a href="{{ $doc['Url'][0] }}" target="_blank">{{ $doc['Url'][0] }}</a></p>
            <br>
            <div style="height: 200px;overflow: auto;">
            <p>
                @php
                    $results = $doc['Content'][0];
                    $key_n = preg_replace('/[\:]/',"",$key);
                    $results_kq = str_replace(" ".$key_n." ",'<b style="color:blue;">'." ".$key_n." ".'</b>',$results);
                    $key_all = preg_split("/[\s,]+/",$key_n);

                    foreach($key_all as $key1){
                        $content    = str_replace(" ".$key1." ",'<b style="color:blue;">'." ".$key1." ".'</b>',$results_kq);
                        $results_kq = preg_replace('/'.$key1.'/','<b style="color:blue;">'." ".$key1." ".'</b>',$content);
                    }
                    echo $results_kq;
                @endphp
            </p>
            </div>
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