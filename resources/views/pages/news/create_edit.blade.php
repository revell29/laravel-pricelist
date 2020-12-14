@extends('layouts.master')
@section('title', 'Form Berita')

@section('content')
@component('layouts.component.header')
@slot('tools')

@endslot
@slot('breadcumbs')
<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> Berita /
    {{isset($data) ? 'Edit Berita' : 'Buat berita'}}</h4>
<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
@endslot

@endcomponent
<!-- Main content -->
<div class="content">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">{{isset($data) ? 'Edit Berita' : 'Tambah Berita'}}</h5>
                </div>
                <div class="card-body">
                    <form id="form-user" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="">Judul</label>
                            <input type="text" name="judul" class="form-control" id=""
                                value="{{isset($data) ? $data->judul : null}}">
                        </div>
                        <div class="form-group">
                            <label for="">Deskripsi</label>
                          <textarea name="description" class="form-control" rows="10">{{ isset($data) ? $data->description : null }}</textarea>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        <button type="button" id="save" class="btn btn-md btn-primary pull-right">Submit</button>
                        <a href="{{route('user.index')}}" class="btn btn-md btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('javascript')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\News\NewsRequest') !!}
<script>
    $('#save').on("click",function(){
    let btn = $(this);
    let form = $('#form-user');
    if(form.valid()) {
        $.ajax({
            url: "{{isset($data) ? route('news.update',$data->id) : route('news.store')}}",
            method: "{{isset($data) ? 'PATCH' : 'POST'}}",
            data: $('#form-user').serialize(),
            dataType: 'JSON',
            beforeSend: function(){
                btn.html('Please wait').prop('disabled',true);
            },
            success: function(response){
                swalInit.fire({
                    title: "Success!",
                    text: response.message,
                    type: 'success',
                    buttonStyling: false,
                    confirmButtonClass: 'btn btn-primary btn-lg',
                }).then(function() {
                    window.location.href = "{{route('news.index')}}";
                })
            },
            error: function(response){
                if(response.status == 500){
                    console.log(response)
                    swalInit.fire("Error", response.responseJSON.message,'error');
                }
                if(response.status == 422){
                    var error = response.responseJSON.errors;
                    
                }
                btn.html('Submit').prop('disabled',false);
            }
        });
    }    
});
</script>
@endpush