@extends('layouts.master')

@section('title', 'Welcome')

@section('content')

  <div class="content-wrapper">
    <div class="container">
        
      <section class="content-header">
        <h1>
          {{ site_name() }}
          <small>欢迎 </small>
        </h1>
      </section>

      <section class="content">

        <header class="jumbotron hero-spacer">
            <h1>欢迎进入 {{ site_name() }}!</h1>
            <p>{{ site_name() }} 是一个24小时工单跟踪系统. 它基于 the awesome Laravel Framwork. 包括 账号登陆, 角色 & 权限, 工单系统, email模板 等等.</p>
            @if (Auth::guest())
            <p><a href="/signup" class="btn bg-purple">注册</a></p>
            @else
            <p><a href="/account" class="btn bg-purple">我的账户</a></p>
            @endif
        </header>

        <!-- Marketing Icons Section -->
        {{--<div class="row">--}}

            {{--<div class="col-md-4">--}}
                {{--<div class="panel">--}}
                    {{--<div class="panel-heading">--}}
                        {{--<h4><i class="fa fa-fw fa-check"></i> Laravel 5.2</h4>--}}
                    {{--</div>--}}
                    {{--<div class="panel-body">--}}
                        {{--<p>Laravel is a free, open-source PHP web framework, created by Taylor Otwell and intended for the development of web applications following the model–view–controller (MVC) architectural pattern.</p>--}}
                        {{--<a href="https://laravel.com" class="btn bg-purple">Learn More</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-4">--}}
                {{--<div class="panel">--}}
                    {{--<div class="panel-heading">--}}
                        {{--<h4><i class="fa fa-fw fa-gift"></i> Free &amp; Open Source</h4>--}}
                    {{--</div>--}}
                    {{--<div class="panel-body">--}}
                        {{--<p>Open-source software (OSS) is computer software with its source code made available with a license in which the copyright holder provides the rights to study, change, and distribute the software to anyone.</p>--}}
                        {{--<a href="https://en.wikipedia.org/wiki/Open-source_software" class="btn bg-purple">Learn More</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-4">--}}
                {{--<div class="panel">--}}
                    {{--<div class="panel-heading">--}}
                        {{--<h4><i class="fa fa-fw fa-compass"></i> AdminLTE 2.3.0</h4>--}}
                    {{--</div>--}}
                    {{--<div class="panel-body">--}}
                        {{--<p>AdminLTE is a popular open source WebApp template for admin dashboards and control panels. It is a responsive HTML template that is based on the CSS framework Bootstrap 3.</p>--}}
                        {{--<a href="https://almsaeedstudio.com/preview" class="btn bg-purple">Learn More</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <!-- /.row -->

      </section> 
    </div>
  </div>
@stop