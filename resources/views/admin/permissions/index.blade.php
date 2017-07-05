@extends('admin.layouts.master')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">
            <h1>后台<small>权限</small></h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <iclass="fa fa-dashboard"></i> 后台
                    </a>
                </li>
                <li class="active">权限</li>
            </ol>
        </section>

        <section class="content">

            @include('admin.layouts.partials.alerts')

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">权限</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <div class="col-md-12">
                        <table class="table table-hover" id="permissiontable">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>名字</th>
                                <th>昵称</th>
                                <th>描述</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--@foreach ($permissions as $key => $permission)--}}
                                {{--<tr>--}}
                                    {{--<td>{{ $permission->id }}</td>--}}
                                    {{--<td>--}}
                                        {{--<a href="{{ route('permissions.show',$permission->id) }}">{{ $permission->name }}</a>--}}
                                    {{--</td>--}}
                                    {{--<td>{{ $permission->display_name }}</td>--}}
                                    {{--<td>{{ $permission->description }}</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a class="btn bg-purple" href="{{ route('permissions.create') }}">
                创建新权限</a>
        </section>
    </div>

    @push('scripts')
    <script>
        $(function () {
            $('#permissiontable').DataTable({
                language: {url: "{{ load_asset('plugins/datatables/localisation/Chinese.json') }}"},
                processing: true,
                serverSide: true,
                ajax: '{!! route('permissions.data') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'display_name', name: 'display_name' },
                    { data: 'description', name: 'description' }
                ]
            });
        });
    </script>
    @endpush

@endsection