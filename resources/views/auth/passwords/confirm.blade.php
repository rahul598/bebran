@extends('layouts.app')

@section('content')
<div class="sign-in-form manage-web">
    <div class="s-lft">
        <div class="sign-in-lft">
            <img src="{{asset('/frontend/images/12.png')}}" />
        </div>
    </div>
    <div class="s-rgt">
        <div class="back-link"><a href="{{ URL::previous()!=URL::current()?URL::previous():url('/') }}"><img src="{{asset('/frontend/images/left.png')}}" /> &nbsp;&nbsp;Go Back</a></div>
        <div class="sign-in-rgt">
            <h2>Confirm Password!</h2>
            <p>Please confirm your password before continuing.</p>
            @include('frontend.message') 
            <form method="POST" action="{{ route('password.confirm') }}" class="customValidate">
                @csrf
                <label>Password</label>
                <div class="pass">
                    <input id="password" type="password" class="password @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"><div class="ey"><i id="eye_gpass" class="fa fa-eye-slash"></i></div>
                </div>
                                @endif 
                <button type="submit">Confirm</button>
                <div class="do-txt">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Confirm Password | {{config('site.title')}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin_lte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin_lte/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_lte/custom.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="{{url('/')}}" class="h1">
          @if( config('site.logo')!='' && File::exists(public_path('uploads/'.config('site.logo'))) )
            <img src="{{ asset('/uploads/'.config('site.logo')) }}" class="user-image" alt="User Image" style="width: 100%;">
          @else
            <p>H<b>ome</b></p>
          @endif
        </a>
      </div>
      <div class="card-body">
        <h2 class="login-box-msg">Confirm Password!</h2>
        <p class="login-box-msg">Please confirm your password before continuing.</p>
        <!-- if there are login errors, show them here -->
        @if($errors->has('email') || $errors->has('password') || $errors->has('authentication') || $errors->has('errormsg'))   
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i> Alert!</h4>
          {{ $errors->first('email') }}
          {{ $errors->first('password') }}
          {{ $errors->first('authentication') }}
          {{ $errors->first('errormsg') }}
        </div>
        @endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
            <form method="POST" action="{{ route('password.confirm') }}" class="customValidate">
          @csrf
          <div class="input-group mb-3">
            <input id="password" type="password" class="password @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
          </div>
          <div class="row">
            <div class="col-6">
        @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="btn">Forgot Your Password?</a>
        @endif
            </div>
            <!-- /.col -->
            <div class="col-6">

              <button type="submit" class="btn btn-primary btn-block">
                {{ __('Confirm') }}
              </button>
            </div>
          <!-- /.col -->
          </div>
        </form>

        <!--<p class="mb-1">-->
        <!--</p>-->
        <!-- <p class="mb-0">
          <a href="register.html" class="text-center">Register a new membership</a>
        </p> -->
      </div>
    <!-- /.card-body -->
    </div>
  <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="{{ asset('admin_lte/plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('admin_lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('admin_lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('admin_lte/dist/js/adminlte.js') }}"></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js'></script>
  <script>
  $(function () {
    jQuery(".customValidate").validate();
    jQuery(".customValidate2").validate();
  });
  </script>
</body>
</html>


