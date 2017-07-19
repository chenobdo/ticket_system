<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width">
    <title>{{ site_name() }}</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ load_asset('bootstrap/css/bootstrap.min.css') }}">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ load_asset('plugins/font-awesome/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ load_asset('plugins/ionicons/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ load_asset('dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="{{ load_asset('plugins/iCheck/square/blue.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>    

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}"><b>{{ site_name() }}</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">重置密码</p>

         <form role="form" method="POST" action="{{ url('/password/email') }}" _lpchecked="1">
            {!! csrf_field() !!}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" placeholder="Email"> 
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                  <div class="row">
                    <div class="col-xs-8">
                      <button type="submit" class="btn btn-primary btn-block btn-flat">发送密码重置链接</button>
                    </div>
                    <!-- /.col -->
                  </div>
                    <a href="{{ url('/') }}">回主页</a><br>
        </form>
                   </div>
                  <!-- /.login-box-body -->
                </div>
                <!-- /.login-box -->          
        
                <!-- jQuery 2.2.3 -->
                <script src="{{ load_asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
                <!-- Bootstrap 3.3.6 -->
                <script src="{{ load_asset('bootstrap/js/bootstrap.min.js') }}"></script>
                <!-- iCheck -->
                <script src="{{ load_asset('plugins/iCheck/icheck.min.js') }}"></script>

                </body>
                </html> 
