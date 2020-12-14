<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            {{$breadcumbs}}
        </div>

        <div class="header-elements d-none">
            <div class="d-flex justify-content-center">
                {{$tools}}
            </div>
        </div>
    </div> 
</div>
@if(get_news())
<div class="alert alert-primary border-0 alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
   <marquee> {{ get_news()->judul }}</marquee>
</div>
@endif