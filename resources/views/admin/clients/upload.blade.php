@extends('admin.layouts.master')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                后台222
                <small>角色</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> 后台</a></li>
                <li class="active">创建新角色</li>
            </ol>
        </section>


        <section class="content">

            @include('admin.layouts.partials.alerts')

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">创建新角色</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>注意!</strong> 你的输入有些问题.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {!! Form::open(['route' => 'clients.store','method'=>'POST']) !!}

                        <div class="form-group{{ $errors->has('file_name') ? ' has-error' : '' }}">
                            <label for="gravatar" class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <input type="file" name="file_name" id="file_name">
                                @if ($errors->has('file_name'))
                                    <span class="help-block">{{ $errors->first('file_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-8">
                                <button type="submit" class="btn bg-purple"><i class="fa fa-pencil"></i> 上传</button>
                            </div>
                        </div>
                        {!! csrf_field() !!}

                </div>
                    {!! Form::close() !!}
        </section>
    </div>

@endsection