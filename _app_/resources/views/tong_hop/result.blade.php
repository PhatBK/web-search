@extends('tong_hop.master')
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
                 $keyoo  = preg_split("/[\s,\/]+/",$key);

                 $key_l  = strtolower($key);
                 $key_u  = ucwords($key); 
                 $key_l_o   = preg_split("/[\s,]+/",$key_l);
                 $key_u_o   = preg_split("/[\s,]+/",$key_u);

                 $new_l = [];
                 $new_u = [];
                 // bi loi voi cac ky tu: á à ă â ơ ờ ợ ...
                 foreach ($key_l_o as $kl) {
                    array_push($new_l,lcfirst($kl));
                 }
                 foreach ($key_u_o as $ku) {
                    array_push($new_u,ucfirst($ku));
                 }
                 // dd($new_l,$new_u);
                 // dd($key_l_o,$key_u_o);
                 
                 foreach ($key_l_o as $key1) {
                     $kq  =  str_replace($key1,'<b style="color:blue;">'.$key1.'</b>',$title);
                    $title =  $kq;
                 }
                 foreach ($key_u_o as $key2) {
                     $kq_2  =  str_replace($key2,'<b style="color:blue;">'.$key2.'</b>',$title);
                    $title =  $kq_2;
                 }
                 
                 // foreach ($keyo as $ko) {
                 //    // viet thuong
                 //    $first_do_ko  =  lcfirst($ko) ;
                 //    $kq  =  str_replace(" ".$first_do_ko." ",'<b style="color:blue;">'." ".$first_do_ko." ".'</b>',$title);
                 //    $title =  $kq;
                 //    // viet hoa
                 //    $first_up_ko =  ucfirst($ko);
                 //    $kq  =  str_replace(" ".$first_up_ko." ",'<b style="color:blue;">'." ".$first_up_ko." ".'</b>',$title);
                 //    $title =  $kq;

                 // }
                 echo $title;
             @endphp
            </b>
             <br><br>
            <p>Link:<a href="{{ $doc['Url'][0] }}" target="_blank">{{ $doc['Url'][0] }}</a></p>
            <br>
            {{-- <p>{{ $doc['Content'][0] }}</p> --}}
            <p>
                @php
                    // $str = $doc['Content'][0];
                    $key1 = $key;
                    $key2 = $key;
                    echo str_replace($key1,'<b style="color:blue;">'.$key2.'</b>',$doc['Content'][0]);
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