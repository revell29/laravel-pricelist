@extends('layouts.master')
@section('title', 'Price List')
@section('styles')
<link href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/extensions/select.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/ui/moment/moment.min.js"></script>
<script type="text/javascript" src="/custom/datatables.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
@endsection
@section('content')
@component('layouts.component.header')
@slot('tools')
    @if(auth()->user()->role == 'admin')
        <a href="{{ route('pricelist.download') }}" class="btn btn-md btn-success mr-2">
            <i class="icon-file-excel mr-2"></i>
            <span>Download Template</span>
        </a>
        <button type="button" class="btn btn-md btn-primary" data-target="#moda_import" data-toggle="modal">
            <i class="icon-plus-circle2 mr-2"></i>
            <span>Import Excel</span>
        </button>
    @endif
@endslot
@slot('breadcumbs')
<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> / Price List</h4>
<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
@endslot
@slot('breadcumbs2')

@endslot
@endcomponent
<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"></h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>

        <table class="table table-hover table-bordered table-xs datatable-select-checkbox" id="data-table"
            data-url="{{route('user.index')}}">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Barcode</th>
                    <th>Nama Item</th>
                    <th>Nama Popular</th>
                    <th>Satuan</th>
                    <th>Harga Satuan 1</th>
                    <th>Harga Satuan 2</th>
                    <th>Harga Satuan 3</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('pages.pricelist.partials.modal')
@endsection

@push('javascript')
<script>
    
  

    var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            order: [0 , 'asc'],
            ajax: {
            url: '{{route('pricelist.index')}}',
            data: function (d) {
                d.datefrom = $('input[name=datefrom]').val();
            },
            method: 'GET'
        },
            columns: [
                { data: 'id', name: 'id', width: '30px', class: 'text-center' },
                { data: 'barcode', name: 'barcode' },
                { data: 'item_name', name: 'item_name' },
                { data: 'popular_name', name: 'popular_name' },
                { data: 'satuan', name: 'satuan' },
                { data: 'price_1', name: 'price_1' },
                { data: 'price_2', name: 'price_2' },
                { data: 'price_3', name: 'price_3' },
            ]
        });

        $("#submit_import").on('click', function() {
            let btn = $(this);
            let form = document.forms.namedItem("form-import");
            let formdata = new FormData(form);

            $.ajax({
                url: "{{ route("pricelist.import") }}",
                method: "POST",
                data: formdata,
                dataType: 'json',
                async: true,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    btn.html('Please wait').prop('disabled', true);
                },
                success: function(response) {
                  $("#moda_import").modal("toggle")
                  $("#form-import").trigger('reset')
                  btn.html('Submit').prop('disabled', false);
                  table.ajax.reload();
                },
                error: function(response) {
                    if (response.status == 500) {
                    console.log(response)
                    swalInit.fire("Error", response.responseJSON.message, 'error');
                    }
                    if (response.status == 422) {
                    var error = response.responseJSON.errors;

                    }
                    btn.html('Submit').prop('disabled', false);
                }
            });
        });

        $(".dataTables_filter > #table-action").css("display",'none');
</script>
<script type="text/javascript" src="/custom/custom-no.js"></script>
@endpush