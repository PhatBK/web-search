<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <base href="{{ asset('') }}" target="_blank, _self, _parent, _top">
    <link rel="stylesheet" href="">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style type="text/css" media="screen">
    #imaginary_container{
        margin-top:7%; /* Don't copy this */
    }
    .stylish-input-group .input-group-addon{
        background: white !important; 
    }
    .stylish-input-group .form-control{
        border-right:0; 
        box-shadow:0 0 0; 
        border-color:#ccc;
    }
    .stylish-input-group button{
        border:0;
        background:transparent;
    }
    </style>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

</head>
<body>
    {{-- <div style="float: left;">
            <input type="button" name="" value="Tổng số văn bản:{{ $numFound }}">
    </div> --}}
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div id="imaginary_container"> 
                    <img src="uploads/images/solr.png" alt="" width="350px" height="100px">
                    <br><br>
                    <form action="solr/api/get" method="POST" accept-charset="utf-8">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" />
                        <div class="input-group stylish-input-group input-append">
                            <input type="text" class="form-control"  placeholder="Search" >
                            <span class="input-group-addon">
                                <button type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>  
                            </span>
                        </div>
                    </form>
                    <br><br>
                    <div class="form-group" >
                        <div class="col-md-12 col-md-offset-12 container" style="float: right;">
                           {{--  <button type="submit" class="btn btn-primary pull-left">Tìm Kiếm Với Solr</button> --}}
                           
                           <div style="float: left;">
                                <input type="button" name="" value="Tổng số văn bản:{{ $numFound }}">
                           </div>
                           
                            <a class="btn btn-warning pull-right" href=""><b style="color: black;">Tìm Kiếm Với Google</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    
    <div class="container">
        <i>Khoảng &nbsp; <u>{{ $numResult }}</u> &nbsp;kết quả (<u>{{ $timeSearch }}</u>&nbsp;giây)</i><br><br>
        @foreach ($docs as $doc)
            <div class="form-group">
                <b style="color: red;"> {{ $doc['Title'][0] }} </b><br><br>
                <p>Link:<a href="{{ $doc['Url'][0] }}" target="_blank">{{ $doc['Url'][0] }}</a></p>
                <br>
                <p>{{ $doc['Content'][0] }}</p>
                <div>
                    
                </div>
            </div>
            <hr>   
        @endforeach
    </div>
    
</body>
</html>




