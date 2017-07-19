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
        <li class="active">创建新权限</li>
      </ol>
    </section>

    <section class="content">
        
        @include('admin.layouts.partials.alerts')

          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">创建新权限</h3>

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
	{!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}

            <div class="form-group">
                <strong>名字:</strong>
                {!! Form::text('name', null, array('placeholder' => '名字','class' => 'form-control')) !!}
            </div>

            <div class="form-group">
                <strong>昵称:</strong>
                {!! Form::text('display_name', null, array('placeholder' => '昵称','class' => 'form-control')) !!}
            </div>

            <div class="form-group">
                <strong>描述:</strong>
                {!! Form::textarea('description', null, array('placeholder' => '描述','class' => 'form-control','style'=>'height:100px')) !!}
            </div>


				<button type="submit" class="btn bg-purple">提交</button>

	</div>
	{!! Form::close() !!}
    </section>
  </div>

@endsection