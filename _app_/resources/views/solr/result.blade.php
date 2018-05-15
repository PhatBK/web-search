@extends('solr.master')
@section('content')
<div class="container">
    <i>Khoảng: &nbsp; <u>{{ $numResult }}</u> &nbsp;kết quả (khoảng:&nbsp;<u>{{ $timeSearch }}</u>&nbsp;giây)</i><br><br>
    @foreach ($docs as $doc)
        <div class="form-group">
            {{-- <b style="color: red;"> {{ $doc['Title'][0] }} </b><br><br> --}}
            <b style="color: red;">
             @php
                 $title = $doc['Title'][0];
                 $keyo = $key;
                 $keyn = $key;
                 // $key_ps = preg_split("/[\s,-]+/",$key);
                 // $key_ps_n = $key_ps;
                 // echo str_replace($key_ps,'<b style="color:blue;">'.$key_ps_n.'</b>',$title);
                 echo str_replace($keyo,'<b style="color:blue;">'.$keyn.'</b>',$title);
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
            <div class="col-md-4">
                <b>Tác Giả</b>:
            </div>
            <div class="col-md-4">
                <b>Ngày Đăng</b>:
            </div>
            <div class="col-md-4">
                <b>Số Lượt Xem</b>:
            </div>
        </div>
        <hr>   
    @endforeach
    {{--  <div style="text-aligin:center;">{!! $docs->links() !!}</div>  --}}
</div>
@endsection
@section('script')
    <script>
        console.log("Ket qua..");
        console.log($results);
    </script>
@endsection