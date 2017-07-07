@extends('admin.layouts.master')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">
            <h1>后台<small>客户</small></h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <iclass="fa fa-dashboard"></i> 后台
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

                <div class="box-body table-responsive">
                    <div class="col-md-12">
                        <table class="table table-hover" id="clienttable">
                            <thead>
                            <tr>
                                <th>checkbox</th>
                                <th>合同编号</th>
                                <th>出借人姓名</th>
                                <th>出借金额</th>
                                <th>导入时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody class="table-striped"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{--<a class="btn bg-purple" href="{{ route('permissions.create') }}">创建新权限</a>--}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">导入</button>
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

    @push('scripts')
    <script>
        $(function () {
            var ClientsShowUrl = '{{ url("admin/clients/") }}';

            var ct = $("#clienttable").DataTable({
                columns: [
                    { data: null, orderable: false},
                    { data: "contractno", name: "contractno" },
                    { data: "client", name: "client" },
                    { data: "loan_amount", name: "loan_amount" },
                    { data: "created_at", name: "created_at" },
                    { data: null}
                ],
                columnDefs: [
                    {
                        targets: 0,
                        render: function(data, type, row, meta) {
                            return '<input type="checkbox" name="checklist" value="' + row.id + '" />'
                        }
                    },
                    {
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return '<a href="'+ ClientsShowUrl + '/' +row.id +'">'+row.client+'</a>'
                        }
                    },
                    {
                        targets: 3,
                        render: function(data, type, row, meta) {
                            return (row.loan_amount || 0).toString().replace(/(\d)(?=(?:\d{3})+$)/g, '$1,');
                        }
                    },
                    {
                        targets: -1,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return '<a type="button" href="#" onclick="del("'+row.id+'","'+row.contractno+'")">删除</a>';
                        }
                    }
                ],
                formatNumber: function ( toFormat ) {
                    return toFormat.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "'");
                },
                order: [[4, "desc"]],
                language: {url: "{{ load_asset('plugins/datatables/localisation/Chinese.json') }}"},
                processing: true,
                serverSide: true,
                ajax: '{!! route("clients.data") !!}',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "全部"]]
            });

            function del(id, contractno) {
                alert(id + ' ' + contractno);
            }
        });
    </script>
    @endpush

@endsection
