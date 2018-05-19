{{-- su dung method Get: --}}
<div class="col-md-12" style="float: left;">
        <div class="row">
            <div class="col-sm-9 col-sm-offset-3">
                {{-- <div id="imaginary_container" class="col-md-12"> --}}
                <div class="col-md-12">
                    <img src="uploads/images/solr.png" alt="" width="350px" height="100px">
                    <br><br>
                    <form action="solr/api/get/vi_data" method="GET" accept-charset="utf-8" autocomplete="off">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" />
                        <div class="input-group stylish-input-group input-append">
                            <input type="text" class="form-control" list="suggestions"  placeholder="Index dữ liệu sử dụng Filter+Stopword" name="search" id="key_search" required=""
                            @isset ($key)
                                value="{{ $key }}" 
                            @endisset
                            >
                            <datalist id="suggestions">
                                <option value="Dai hoc Bach Khoa"></option>
                                <option value="Dai hoc Bach Khoa Ha Noi"></option>
                                <option value="Dai hoc Bach Khoa HCM"></option>
                              
                               {{--  @foreach ($suggestions as $sugg)
                                    <option value="{{ $sugg }}"></option>
                                @endforeach   --}}                            
                            </datalist>

                            <span class="input-group-addon">
                                <button {{-- type="submit" --}}>
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>  
                            </span>
                            <div style="float: left;">
                                <a class="btn btn-default pull-right" href="
                                    @isset($key)
                                    https://www.google.com.vn/search?hl=vi&source=hp&ei=bWfTWqnQFciB8gWv-YLwCQ&q={{ $key }}
                                    @endisset " target="_blank">
                                     <b style="color: black;">Tìm Với Google</b>
                                </a>
                            </div>
                        </div>
                    </form>
                    <br><br><br><br><br><br>
                </div>
            </div>
        </div>
</div>