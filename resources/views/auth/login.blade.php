<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>

    <link rel="stylesheet" type="text/css" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

</head>
<body>
    <div class="main">
        <div class="container">
            <center>
                <div class="middle">
                    <div id="login">
                        @if(session()->has('danger'))
                        <div style="background-color: red;width: 100%;color: white">{{session('danger')}}</div>
                        <br/>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <p><span class="fa fa-user"></span><input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="off" autofocus Placeholder="Usuario"></p>
                                    @error('name')
                                        <div class="alert alert-danger" role="alert" style="background-color: #f8d7da;margin-bottom: 1%">
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <p><span class="fa fa-lock"></span><input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" Placeholder="Password">
                                    </p>
                                    @error('password')
                                        <div class="alert alert-danger" style="background-color: #f8d7da">
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4" style="font-size: 14px">
                                    @if (Route::has('password.request'))
                                        <a style="width:48%; text-align:left;  display: inline-block;" class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Olvide mi Constraseña') }}
                                        </a>
                                    @endif
                                    <span style="width:50%; text-align:right;  display: inline-block;"><input type="submit" value="Iniciar Sesión" class="btn btn-primary"></span>
                                    
                                </div>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                    </div> <!-- end login -->
                    <div class="logo"><a href="/">@include('layouts.nombreEmpresa')</a>
                      <div class="clearfix"></div>
                    </div> 
                </div>
            </center>
        </div>
    </div>
</body>
</html>