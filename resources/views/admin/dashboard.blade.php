@extends('admin.layouts.master')

@section('content')

   <div class="content-wrapper">
        <section class="content-header">
            <h1>
                后台
                <small>面板</small>
            </h1>
      
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 后台</a></li>
            </ol>
        </section>


    <section class="content">
        
        @include('admin.layouts.partials.alerts')

    
    @permission('manage-tickets')
      <div class="row">
        
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-folder-open"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">创建的工单</span>
              <span class="info-box-number">{{ $count_open_ticket }}</span>
            </div>
          </div>
        </div>
  
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-check-square"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">关闭的工单</span>
              <span class="info-box-number">{{ $count_closed_ticket }}</span>
            </div>
          </div>
        </div>
 
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-folder"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">进行中的工单</span>
              <span class="info-box-number">{{ $count_inprogress_ticket }}</span>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-history"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">重开的工单</span>
              <span class="info-box-number">{{ $count_reopened_ticket }}</span>
            </div>
          </div>
        </div>
        
     </div>
     @endpermission
     
      <div class="row">
          
        @permission('manage-permissions')
        <div class="col-lg-4 col-xs-6">
          <div class="small-box bg-teal">
            <div class="inner">
              <h3>{{ $count_permissions }}</h3>
              <p>权限</p>
            </div>
            <div class="icon">
              <i class="fa fa-key"></i>
            </div>
            <a href="{{ route('permissions.index') }}" class="small-box-footer">
              更多信息 <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        @endpermission

        @permission('manage-users')
        <div class="col-lg-4 col-xs-6">
          <div class="small-box bg-maroon">
            <div class="inner">
              <h3>{{ $count_users }}</h3>
              <p>用户</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="{{ route('users.index') }}" class="small-box-footer">
              更多信息 <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        @endpermission
        
        @permission('manage-roles')
        <div class="col-lg-4 col-xs-6">
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>{{ $count_roles }}</h3>
              <p>角色</p>
            </div>
            <div class="icon">
              <i class="fa fa-archive"></i>
            </div>
            <a href="{{ route('roles.index') }}" class="small-box-footer">
              更多信息 <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        @endpermission
      </div>
    </section>
   </div>

@stop