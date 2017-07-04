@extends('admin.layouts.master')

@section('content')

  <div class="content-wrapper">

    <section class="content-header">
      <h1>
        后台
        <small>工单</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> 后台</a></li>
        <li class="active">工单</li>
      </ol>
    </section>


    <section class="content">
        
        @include('admin.layouts.partials.alerts')
        
        @include('admin.tickets.buttons')

          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">工单</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body table-responsive">
  <div class="col-md-12">              
                  @if ($tickets->isEmpty())
                        <p>这里没有工单..</p>
                    @else
                        <table class="table table-hover" id="tickettable">
                            <thead>
                                <tr>
                                    <th>工单ID</th>
                                    <th>标题</th>
                                    <th>用户</th>
                                    <th>评论</th>
                                    <th>类型</th>
                                    <th>状态</th>
                                    <th>优先级</th>
                                    <th>创建时间</th>
                                    <th>最近更新</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td><span class="label label-default">#{{ $ticket->ticket_id }}</span></td>
                                    <td>
                                        <a href="{{ url('admin/tickets/'. $ticket->ticket_id) }}">
                                            {{ $ticket->title }}
                                        </a>
                                    </td>  
                                    <td>{{ $ticket->user->fullname }}</td>                                    
                                    <td><span class="badge">{{ count($ticket->comments) }}</span></td>
                                    <td>
                                    @foreach ($categories as $category)
                                        @if ($category->id === $ticket->category_id)
                                            {{ $category->name }}
                                        @endif
                                    @endforeach
                                    </td>
                                    <td>
                                    @foreach ($statuses as $status)
                                        @if ($status->id === $ticket->status_id)
                                            @if ($status->id === 1)
                                            <span class="label label-info"> {{ $status->name }}</span>
                                            @elseif ($status->id === 2)
                                            <span class="label label-warning"> {{ $status->name }}</span>
                                            @elseif ($status->id === 3)
                                            <span class="label label-success"> {{ $status->name }}</span>
                                            @else
                                            <span class="label label-danger"> {{ $status->name }}</span>
                                            @endif                                    
                                        @endif
                                    @endforeach
                                    </td>
                                    <td>
                                    @foreach ($prioritys as $priority)
                                        @if ($priority->id === $ticket->priority_id)
                                            @if ($priority->id === 1)
                                            <p class="bg-danger"> {{ $priority->name }}</p>
                                            @elseif ($priority->id === 2)
                                            <p class="bg-success"> {{ $priority->name }}</p>
                                            @else 
                                            <p class="bg-info"> {{ $priority->name }}</p>
                                            @endif                                        
                                        @endif
                                    @endforeach
                                    </td>   
                                    <td>{{ $ticket->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $ticket->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
        </div>
    </div>
    </section>
  </div>
  
 @push('scripts') 
 <script>
   $(function () {
     $("#tickettable").DataTable({
         "language": "{{ load_asset('plugins/datatables/localisation/Chinese.json') }}",
         "order": [[ 0, "asc" ]]
     });
   });
 </script>  
 @endpush  
  
@endsection