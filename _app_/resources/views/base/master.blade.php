<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base Index Standar Search</title>
    <base href="{{ asset('') }}" target="_blank, _self, _parent, _top">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    {{-- <link rel="stylesheet" href="css/autocomplete.css" type="text/css"> --}}

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
    @include('base.form')
    @yield('content')
</body>
    @yield('script')
    
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    {{-- <script src="js/autocomplete.js"></script> --}}

    {{-- <script>
        $(document).ready(function(){

            $('#key_search').keyup(function (e) {
            key = $(this).val();
            e.preventDefault();
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $.ajax({
                url: 'solr/api/get/base/key_real_time',
                type: 'GET',
                dataType: 'json',
                data: {
                    key: key,
                }
            }).done(function(response) {
                // console.log(response);
                var str = "" ;
                for(var i = 0; i < response.length; i++){
                    str += "<option value="+'"'+response[i]+'"'+">"+response[i]+"</option>";

                }
                $( "#key_search" ).autocomplete({
                  source: response
                });
                // $("#key_search").autocomplete({
                //     hints: response
                // });
                // console.log(str);
                // $("#key_search").easyAutocomplete(response);
                // $("#real_time_result").html(str);
                // document.getElementById('suggestions').innerHTML=str;
                // console.log(str);
                // document.getElementById('real_time_result').innerHTML = str;
            });
            });
        });


        // bắt sựu kiện nhập song nhấn enter
        // $( "#key_search" ).keypress(function() {
        //   console.log($(this).val());
        // });
    </script> --}}
</html>




