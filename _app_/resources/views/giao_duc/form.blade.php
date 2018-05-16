{{-- su dung method Get: --}}
<div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div id="imaginary_container"> 
                    <img src="uploads/images/solr.png" alt="" width="350px" height="100px">
                    <br><br>
                    <form action="solr/api/get/giao_duc" method="GET" accept-charset="utf-8" autocomplete="off">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" />
                        <div class="input-group stylish-input-group input-append">
                            <input type="text" class="form-control"  placeholder="Search" name="search" id="key_search" required="" 
                            @isset ($key)
                                value="{{ $key }}" 
                            @endisset
                            >
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
                        <a class="btn btn-default pull-right" href="
                            @isset($key)
                            https://www.google.com.vn/search?hl=vi&source=hp&ei=bWfTWqnQFciB8gWv-YLwCQ&q={{ $key }}
                            @endisset " target="_blank">
                             <b style="color: black;">Tìm Kiếm Với Google</b>
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>



{{-- su dung method Post:27/04/2018 --}}

{{-- <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div id="imaginary_container"> 
                    <img src="uploads/images/solr.png" alt="" width="350px" height="100px">
                    <br><br>
                    <form action="solr/api/post" method="POST" accept-charset="utf-8">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" />
                        <div class="input-group stylish-input-group input-append">
                            <input type="text" class="form-control"  placeholder="Search" name="search" id="key_search"
                            @isset ($key)
                                value="{{ $key }}" 
                            @endisset
                            >
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
                        <a class="btn btn-default pull-right" href="
                            @isset($key)
                            https://www.google.com.vn/search?hl=vi&source=hp&ei=bWfTWqnQFciB8gWv-YLwCQ&q={{ $key }}
                            @endisset " target="_blank">
                             <b style="color: black;">Tìm Kiếm Với Google</b>
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div> --}}