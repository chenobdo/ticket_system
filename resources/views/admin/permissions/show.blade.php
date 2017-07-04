@extends('admin.layouts.master')
 
@section('content')

  <div class="content-wrapper">

    <section class="content-header">
      <h1>
        后台
        <small>权限</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> 后台</a></li>
        <li class="active">权限</li>
      </ol>
    </section>

    <section class="content">
        
        @include('admin.layouts.partials.alerts')

          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">权限</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body">
                
            <div class="form-group">
                <strong>名字:</strong>
                {{ $permission->name }}
            </div>

            <div class="form-group">
                <strong>昵称:</strong>
                {{ $permission->display_name }}
            </div>

            <div class="form-group">
                <strong>描述:</strong>
                {{ $permission->description }}
            </div>
			<a class="btn bg-purple" href="{{ route('permissions.edit',$permission->id) }}"><i class="fa fa-edit"> 标记</i></a>
			{!! Form::open(['method' => 'DELETE','route' => ['permissions.destroy', $permission->id],'style'=>'display:inline','class'=>'delete']) !!}
            {{ Form::button('<i class="fa fa-remove"> 删除</i>', array('class'=>'btn btn-danger', 'type'=>'submit')) }}
        	{!! Form::close() !!}
        </div>
          </div>	
    </section>
  </div>

@endsection