<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Solr Search Client</title>
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
</head>
<body>
    @section('title')
    @show
    @include('tong_hop.form')
    @yield('content')
</body>
    @yield('script')
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
     <script>
        $(document).ready(function(){
            $('#key_search').keyup(function (e) {
            $('#display').text($(this).val());

            key = $(this).val();
            e.preventDefault();
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $.ajax({
                url: 'solr/api/get/tong_hop/key_real_time',
                type: 'GET',
                dataType: 'json',
                data: {
                    key: key,
                }
            }).done(function(response) {
                // console.log(response);
                console.log(response);
            });
            });
        });


        // bắt sựu kiện nhập song nhấn enter
        // $( "#key_search" ).keypress(function() {
        //   console.log($(this).val());
        // });
    </script>
</html>




