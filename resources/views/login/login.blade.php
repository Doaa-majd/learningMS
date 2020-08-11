<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->

<!-- course-login40:16  -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <title>LearnPLUS | Learning Management System HTML Template</title>
    <link rel="shortcut icon" href="{{ asset('front-assets/images/favicon.ico') }}" type="image/x-icon" />
  <link rel="apple-touch-icon" href="{{ asset('front-assets/images/apple-touch-icon.png') }}" />
  <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('front-assets/images/apple-touch-icon-57x57.png') }}" />
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('front-assets/images/xapple-touch-icon-72x72.png.pagespeed.ic.lf5d8kCpOf.png') }}" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('front-assets/images/xapple-touch-icon-76x76.png.pagespeed.ic.ATZZpSeito.png') }}" />
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('front-assets/images/xapple-touch-icon-114x114.png.pagespeed.ic.Fi5O5s2tzL.png') }}" />
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('front-assets/images/xapple-touch-icon-120x120.png.pagespeed.ic.uPQH0sygdV.png') }}" />
  <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('front-assets/images/xapple-touch-icon-144x144.png.pagespeed.ic.yZ9-_sm5OF.png') }}" />
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('front-assets/images/xapple-touch-icon-152x152.png.pagespeed.ic.gThaVrKtXF.png') }}" />
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('front-assets/images/xapple-touch-icon-180x180.png.pagespeed.ic.Q8Pmsj5fQM.png') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/rs-plugin/css/A.settings.css.pagespeed.cf.xeOyGChsgq.css') }}" media="screen" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/fonts.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/A.menu.css.pagespeed.cf.0_hLwXzYkZ.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/A.carousel.css%2bbxslider.css%2cMcc.jgeTii-u52.css.pagespeed.cf.STKSIMl7GF.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/style.css') }}" />
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login">
    <div id="loader">
        <div class="loader-container">
            <img src="{{ asset('front-assets/images/site.gif')}}" alt="" class="loader-site">
        </div>
    </div>
    <div id="wrapper">
        <div class="container">
            <div class="row login-wrapper">
                <div class="col-md-6 col-md-offset-3">
                    <div class="logo logo-center">
                        <a href="/"><img src="{{ asset('front-assets/images/xlogin-logo.png.pagespeed.ic.rk5LaeLYSz.png')}}" alt=""></a>
                    </div>
                    <div class="panel panel-login">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a href="#" class="active" id="login-form-link">Login</a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="#" id="register-form-link">Register</a>
                                </div>
                            </div>
                            <hr>
                        </div> 
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="login-form" method="POST" action="{{ route('login') }}" role="form" style="display: block;">
                                        @csrf
                                        <div class="form-group">
                                                <input id="email" placeholder="Email Adress" tabindex="1" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                                <input id="password" placeholder="Password" tabindex="2" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                        </div>
                                        <div class="form-group text-center">
                                            <input class="" tabindex="3" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label for="remember"> &nbsp; Remember Me</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    
                                                        <button type="submit" class="form-control btn btn-default">
                                                            {{ __('Login') }}
                                                        </button>
                                                        @if (Route::has('password.request'))
                                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                                            {{ __('Forgot Your Password?') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center">
                                                        <a href="#" tabindex="5" class="forgot-password">Forgot
                                                            Password?</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form method="POST" action="{{ route('register') }}" id="register-form" 
                                    role="form" style="display: none;">
                                        @csrf
            
                                        <div class="form-group">
                                        
                                            <input id="name" placeholder="Enter your name" tabindex="1" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input id="email" placeholder="Email Adress" tabindex="1" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                                <input id="password" placeholder="Password" tabindex="2" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <input id="password-confirm" placeholder="Confirm Password" tabindex="2" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                        <button type="submit" class="form-control btn btn-default btn-block">
                                                            {{ __('Register') }}
                                                        </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('front-assets/js/jquery.min.js.pagespeed.jm.iDyG3vc4gw.js') }}"></script>
    <script src="{{ asset('front-assets/js/bootstrap.min.js%2bretina.js%2bwow.js.pagespeed.jc.pMrMbVAe_E.js') }}"></script>
    <script>
        eval(mod_pagespeed_gFRwwUbyVc);
    </script>
    <script>
        eval(mod_pagespeed_rQwXk4AOUN);
    </script>
    <script>
        eval(mod_pagespeed_U0OPgGhapl);
    </script>
  <script src="{{ asset('front-assets/js/carousel.js%2bcustom.js.pagespeed.jc.nVhk-UfDsv.js') }}"></script>
  <script>
        eval(mod_pagespeed_6Ja02QZq$f);
    </script>
    <script>
        eval(mod_pagespeed_KxQMf5X6rF);
    </script>
</body>

<!-- course-login40:17  -->

</html>