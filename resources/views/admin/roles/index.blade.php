@extends('admin.layouts.master')
 
@section('content')

  <div class="content-wrapper">

    <section class="content-header">
      <h1>
        后台
        <small>角色</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> 后台</a></li>
        <li class="active">角色</li>
      </ol>
    </section>

    <section class="content">
        
        @include('admin.layouts.partials.alerts')

          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">角色</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body table-responsive">
  <div class="col-md-12">                  
	<table class="table table-hover" id="rolestable">
	  <thead>
		<tr>
			<th>序号</th>
			<th>名称</th>
			<th>昵称</th>
			<th>描述</th>
		</tr>
	  </thead>
	  <tbody>
	@foreach ($roles as $key => $role)
	<tr>
		<td>{{ ++$i }}</td>
		<td><a href="{{ route('roles.show',$role->id) }}">{{ $role->name }}</a></td>
	    <td>{{ $role->display_name }}</td>		
		<td>{{ $role->description }}</td>
	</tr>
	@endforeach
	</tbody>
	</table>
</div>
        </div>
          </div>
          <a class="btn bg-purple" href="{{ route('roles.create') }}"> 创建新角色</a>
    </section>
  </div>

@push('scripts') 
<script>
  $(function () {
    $("#rolestable").DataTable({
        "language": {
            url: "{{ load_asset('plugins/datatables/localisation/Chinese.json') }}"
        }
    });
  });
</script>  
@endpush

@endsection