@extends('admin.layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ load_asset('css/client.css') }}">

    <div class="content-wrapper">

        <section class="content-header">
            <h1>后台<small>账单</small></h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fa fa-dashboard"></i> 后台
                    </a>
                </li>
                <li class="active">账单</li>
            </ol>
        </section>

        <section class="content">

            @include('admin.layouts.partials.alerts')

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">客户</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <div class="col-md-12">
                        <table class="table table-hover dataTable" id="ziptable">
                            <thead>
                            <tr>
                                <th>账单包名</th>
                                <th>操作人</th>
                                <th>备注</th>
                                <th>生成时间</th>
                            </tr>
                            </thead>
                            <tbody class="table-striped"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
    <script>
        $(function () {
            var DownloadUrl = '{{ url("admin/check/download") }}';

            var ct = $("#ziptable").DataTable({
                columns: [
                    { data: "zip_name", name: "zip_name" },
                    { data: "uid", name: "uid" },
                    { data: "mark", name: "mark"},
                    { data: "created_at", name: "created_at" }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return '<a href="'+ DownloadUrl + '/' +row.id +'/download">'+ row.zip_name +'</a>'
                        }
                    },
                    {
                        targets: 1,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return row.uid;
                        }
                    }
                ],
                order: [[3, "desc"]],
                language: {url: "{{ load_asset('plugins/datatables/localisation/Chinese.json') }}"},
                processing: true,
                serverSide: true,
                ajax: '{!! route("check.data") !!}',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "全部"]]
            });
        });
    </script>
    @endpush

@endsection
