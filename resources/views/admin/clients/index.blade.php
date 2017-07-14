@extends('admin.layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ load_asset('css/client.css') }}">

    <div class="content-wrapper">

        <section class="content-header">
            <h1>后台<small>客户</small></h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fa fa-dashboard"></i> 后台
                    </a>
                </li>
                <li class="active">客户</li>
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

                <div style="padding: 10px 25px;">
                    <button type="button" class="btn btn-primary" id="select-all">全选/button>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">导入</button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#packageModal">打包</button>
                </div>

                <div class="box-body table-responsive">
                    <div class="col-md-12">
                        <table class="table table-hover dataTable" id="clienttable">
                            <thead>
                            <tr>
                                <th>合同编号</th>
                                <th>非续投/续投</th>
                                <th>出借人姓名</th>
                                <th>身份证</th>
                                <th>性别</th>
                                <th>导入时间</th>
                            </tr>
                            </thead>
                            <tbody class="table-striped"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{--<a class="btn bg-purple" href="{{ route('permissions.create') }}">创建新权限</a>--}}
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form role="form" method="POST" action="{{ route('clients.store') }}"  enctype="multipart/form-data" class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">导入</h4>
                    </div>
                    <div class="modal-body" style="min-height: 60px;">
                        <label for="gravatar" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <input type="file" name="file_name" id="file_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-purple"><i class="fa fa-pencil"></i>上传Excel</button>
                    </div>
                    {!! csrf_field() !!}
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="packageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="POST" action="{{ route('check.package') }}" class="form-horizontal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">打包列表</h4>
                    </div>
                    <div class="modal-body">
                        <table class="package-list-td">
                            <thead><tr><td>合同编号</td><td>出借人</td></tr></thead>
                            <tbody id="package-list"></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">打包</button>
                    </div>
                </div>
                {!! csrf_field() !!}
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function () {
            var ClientsShowUrl = '{{ url("admin/clients/") }}';

            var ct = $("#clienttable").DataTable({
                columns: [
                    { data: "contractno", name: "contractno" },
                    { data: "is_continue", name: "is_continue" },
                    { data: "client", name: "client"},
                    { data: "cardid", name: "cardid" },
                    { data: "gender", name: "gender" },
                    { data: "created_at", name: "created_at" }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return '<a href="'+ ClientsShowUrl + '/' +row.id +'">'+row.contractno+'</a>'
                        }
                    },
                    {
                        targets: 1,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            switch (row.is_continue) {
                                case 1 :
                                    return '首次投资';
                                case 2 :
                                    return '非首次';
                                case 3 :
                                    return '续投';
                                case 4 :
                                    return '无需填写';
                            }
                        }
                    },
                    {
                        targets: 2,
                        searchable: false
                    },
                    {
                        targets: 4,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return row.gender == 'M' ? '男' : '女';
                        }
                    }
                ],
                order: [[5, "desc"]],
                language: {url: "{{ load_asset('plugins/datatables/localisation/Chinese.json') }}"},
                processing: true,
                serverSide: true,
                ajax: '{!! route("clients.data") !!}',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "全部"]],
                initComplete: function() {
                    $('#clienttable_filter > label > input').attr('placeholder', '搜索身份证号');
                }
            });

            $('#clienttable tbody').on('click', 'tr', function () {
                $(this).toggleClass('selected');
            } );
            $('#packageModal').on('show.bs.modal', function () {
                var str = ''
                var rows = ct.rows('.selected').data();
                $.each(rows, function(k, v) {
                    str += '<tr><td>'+v.contractno+'</td><td>'+v.client
                            +'</td><td style="display:none;">'
                            +'<input type="text" name="contractnos[]" value="'
                            +v.contractno+'"></td></tr>';
                });
                $('#package-list').empty();
                $('#package-list').html(str);
            });
            $('#select-all').on('click', function(e) {
                $('clienttable tbody tr').click();
            });
        });
    </script>
    @endpush

@endsection
