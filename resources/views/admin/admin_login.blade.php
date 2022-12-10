<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng nhập Quản trị viên - MinMovies</title>
    <base href="{{ asset('')}}/public/admin/login/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700italic,700,400italic,300italic,300'
        rel='stylesheet' type='text/css'>
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('user/css/bootstrap.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('adm/login/css/main.css')}}">
</head>

<body>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-lg-12 login-key">
                    <i class="fa fa-key" aria-hidden="true"></i>
                </div>
                <div class="col-lg-12 login-title">
                    Đăng nhập quản trị viên
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form method="post" action="{{ route('admin.postLogin') }}">
                        @csrf
                        @if (session('thongbao_admin'))
                        <div class="alert alert-{{ session('thongbao_level') }}" style="border-radius:0px;">
                            <h5 class="text-center">{!! session('thongbao_admin') !!}</h5>
                        </div>
                        @endif
                            <div class="form-group">
                                <label class="form-control-label">USERNAME</label>
                                <input type="text" name="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">PASSWORD</label>
                                <input type="password" name="password" class="form-control" i>
                            </div>

                            <div class="col-lg-12 loginbttm text-center mb-2">
                                <button type="submit" class="btn btn-outline-primary">LOGIN</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
        </div>
    <!--===============================================================================================-->
    <script src="{{asset('adm/vendor/jquery/jquery.min.js')}}"></script>
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <script src="{{asset('adm/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <!--===============================================================================================-->

</body>

</html>
