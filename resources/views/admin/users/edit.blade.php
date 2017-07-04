@extends('admin.layouts.master')
 
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        后台
        <small>用户</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> 后台</a></li>
        <li class="active">编辑用户</li>
      </ol>
    </section>

    <section class="content">
        
        @include('admin.layouts.partials.alerts')

          <div class="box box-default">
              
            <div class="box-header with-border">
              <h3 class="box-title">编辑用户</h3>

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
            	
	        {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}

            <div class="form-group">
                <strong>姓名:</strong>
                {!! Form::text('fullname', null, array('placeholder' => '姓名','class' => 'form-control')) !!}
            </div>

            <div class="form-group">
                <strong>邮箱:</strong>
                {!! Form::text('email', null, array('placeholder' => '邮箱','class' => 'form-control')) !!}
            </div>

            <div class="form-group">
                <strong>密码:</strong>
                {!! Form::password('password', array('placeholder' => '密码','class' => 'form-control')) !!}
            </div>

            <div class="form-group">
                <strong>确认密码:</strong>
                {!! Form::password('confirm-password', array('placeholder' => '确认密码','class' => 'form-control')) !!}
            </div>

            <div class="form-group">
                <strong>角色:</strong>
                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
            </div>

				<button type="submit" class="btn bg-purple">提交</button>

            </div>
         </div>	
  </div>
    </section>
  </div>

	{!! Form::close() !!}
	
@endsection