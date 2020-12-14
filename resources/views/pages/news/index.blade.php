@extends('layouts.master')
@section('title', 'News')
@section('scripts')
<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/extensions/select.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/ui/moment/moment.min.js"></script>
<script type="text/javascript" src="/custom/datatables.js"></script>
@endsection
@section('content')
@component('layouts.component.header')
@slot('tools')
    @if(auth()->user()->role == 'admin')
        <a href="{{route('news.create')}}" class="btn btn-md btn-primary">
            <i class="icon-plus-circle2 mr-2"></i>
            <span>Tambah Berita</span>
        </a>
    @endif
@endslot
@slot('breadcumbs')
<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> / Berita</h4>
<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
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
            data-url="{{route('news.index')}}">
            <thead>
                <tr>
                    <th><input type="checkbox" class="styled" id="select-all"></th>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('javascript')
<script>
    var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            order: [1 , 'desc'],
            ajax: {
            url: '{{route('news.index')}}',
            data: function (d) {
                d.datefrom = $('input[name=datefrom]').val();
            },
            method: 'GET'
        },
            columnDefs: [{
                targets: 0,
                createdCell: function(td, cellData) {
                    if (cellData != 0 ){
                        $(td).addClass('select-checkbox')
                    }
                }
            }],
            columns: [
                { data: 'id', name: 'id', width: '50px', orderable: false, render: function() { return ''} },
                { data: 'id', name: 'id', width: '30px' , class: "text-center", searchable: false },
                { data: 'judul', name: 'judul' },
                { data: 'description', name: 'description' },
                { data: 'deleted_at', name: 'deleted_at', class: 'text-center', width: '30px' },
            ]
        });
</script>
<script type="text/javascript" src="/custom/custom-full.js"></script>
@endpush