@extends('admin.layouts.master')
 
@section('content')

  <div class="content-wrapper">

    <section class="content-header">
      <h1>
        后台
        <small>客户</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> 后台</a></li>
        <li class="active">客户</li>
      </ol>
    </section>

    <section class="content">
        
        @include('admin.layouts.partials.alerts')

          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">客户</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body">
                
            <div class="form-group">
                <strong>合同编号:</strong>
                {{ $client->contractno }}
            </div>

            <div class="form-group">
                <strong>首次投资:</strong>
                {{ $client->is_continue }}
            </div>

            <div class="form-group">
                <strong>出借人:</strong>
                {{ $client->client }}
            </div>
			<a class="btn bg-purple" href="{{ route('clients.edit',$client->id) }}"><i class="fa fa-edit"> 编辑</i></a>
			{!! Form::open(['method' => 'DELETE','route' => ['clients.destroy', $client->id],'style'=>'display:inline','class'=>'delete']) !!}
            {!! Form::button('<i class="fa fa-remove"> 删除</i>', ['class'=>'btn btn-danger', 'type'=>'submit']) !!}
        	{!! Form::close() !!}
        </div>
          </div>	
    </section>
  </div>

@endsection