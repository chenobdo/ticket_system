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
        <li class="active">展示用户</li>
      </ol>
    </section>

    <section class="content">
        
        @include('admin.layouts.partials.alerts')

          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">展示用户</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body">
                
            <div class="form-group">
                <strong>姓名:</strong>
                {{ $user->fullname }}
            </div>

            <div class="form-group">
                <strong>邮箱:</strong>
                {{ $user->email }}
            </div>

            <div class="form-group">
                <strong>角色:</strong>
					@foreach($user->roles as $v)
						<label class="label label-success">{{ $v->display_name }}</label>
					@endforeach
            </div>

                			<a class="btn bg-purple" href="{{ route('users.edit',$user->id) }}"><i class="fa fa-edit"> 编辑</i></a>
                			{!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline','class'=>'deleteuser']) !!}
                            {{ Form::button('<i class="fa fa-remove"> 删除</i>', array('class'=>'btn btn-danger', 'type'=>'submit')) }}
                        	{!! Form::close() !!}            
            
          </div>	
          </div>
    </section>
  </div>

@endsection