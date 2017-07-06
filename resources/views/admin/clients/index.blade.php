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
                                <th>合同编号</th>
                                <th>出借人姓名</th>
                                <th>出借金额</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{--<a class="btn bg-purple" href="{{ route('permissions.create') }}">创建新权限</a>--}}
        </section>
    </div>

    @push('scripts')
    <script>
        $(function () {
            var ClientsShowUrl = '{{ url("admin/clients/") }}';

            $('#client').DataTable({
                language: {url: "{{ load_asset('plugins/datatables/localisation/Chinese.json') }}"},
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('clients.data') !!}',
                    dataSrc: function(json) {
                        $.each(json.data, function(k, v) {
                            v.name = '<a href="'+ ClientsShowUrl + '/' +v.id +'">'+v.client+'</a>';
                            v.op = '';
                        });
                        return json.data;
                    }
                },
                order: [[0, 'desc']],
                columns: [
                    { data: 'contractno', name: 'contractno' },
                    { data: 'client', name: 'client' },
                    { data: 'loan_amount', name: 'loan_amount' },
                    { data: 'op', name: 'op' }
                ]
            });
        });
    </script>
    @endpush

@endsection