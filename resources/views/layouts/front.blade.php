<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<!--  33:43  -->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
  <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/custom.css') }}" />
  @yield('css')

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  <div id="loader">
    <div class="loader-container">
      <img src="images/site.gif" alt="" class="loader-site">
    </div>
  </div>
  <div id="wrapper">
    <div class="topbar">
      <div class="container">
        <div class="row">
          <div class="col-md-6 text-left">
            <p><i class="fa fa-graduation-cap"></i> Best learning management platform for ever.</p>
          </div>
          <div class="col-md-6 text-right">
            <ul class="list-inline">
              <li>
                <a class="social" href="#"><i class="fa fa-facebook"></i></a>
                <a class="social" href="#"><i class="fa fa-twitter"></i></a>
                <a class="social" href="#"><i class="fa fa-linkedin"></i></a>
              </li>
             
              @guest
                            <li>
                                <a class="menu-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li>
                                    <a class="menu-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="dropdown">
                                <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                  @if (Auth::user()->type != 'user')
                                     <a class="menu-link" href="{{ route('admin.courses.index') }}">
                                      <i class="fa fa-sign-in"></i> Dashboard </a>
                                      <br>
                                  @endif

                                    <a class="menu-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       <i class="fa fa-sign-in"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
            </ul>
          </div>
        </div>
      </div>
    </div>
    <header class="header">
      <div class="container">
        <div class="hovermenu ttmenu">
          <div class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="fa fa-bars"></span>
              </button>
              <div class="logo">
                <a class="navbar-brand" href="/"><img src="{{ asset('front-assets/images/xlogo.png.pagespeed.ic.vap6Ukaf0i.png')}}"
                    alt=""></a>
              </div>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="dropdown ttmenu-half"><a href="/">Home </a>
                  
                </li>
                <li><a href="page-about.html">About</a></li>
                <li class="dropdown ttmenu-half"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Categories <b
                      class="fa fa-angle-down"></b></a>
                  <ul class="dropdown-menu menu-bg wbg">
                    <li>
                      <div class="ttmenu-content">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="box">
                              <ul>
                                @foreach(App\Category::all() as $category)
                                <li><a href="{{ route('course.courseCategory', [$category->id])}}">{{$category->name}}</a></li>
                                @endforeach
                              </ul>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </li>
                  </ul>
                </li>
                
                <li><a href="blog.html">Blog</a></li>
                <li><a href="page-contact.html">Contact</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                @auth
                <li><a href="{{route('course.showUserCourse')}}"> My Courses</a></li>

                
                @if (Auth::user()->type == 'user')
                <li><a class="btn btn-primary" href="{{ route('user.becomeInstructor') }}"><i class="fa fa-sign-in"></i> Become an instructor</a>
                </li>
                @endif

                @endauth
                <li><a href="{{route('cart')}}"> <i class="fa fa-shopping-cart" style="font-size: 20px"></i></a></li>

              </ul>
            </div>
          </div>
        </div>
      </div>
    </header>
    @yield('content')

    <footer class="dark footer section">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-md-6 col-xs-12">
            <div class="widget">
              <div class="widget-title">
                <h4>About LearnPLUS</h4>
                <hr>
              </div>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s, when an unknown printer took...</p>
              <a href="#" class="btn btn-default">Read More</a>
            </div>
          </div>
          <div class="col-md-3 col-md-6 col-xs-12">
            <div class="widget">
              <div class="widget-title">
                <h4>Recent Tweets</h4>
                <hr>
              </div>
              <div class="twitter-widget">
                <ul class="latest-tweets">
                  <li>
                    <p><a href="#" title="">@Mark</a> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer
                      lorem quam.</p>
                    <span>2 hours ago</span>
                  </li>
                  <li>
                    <p><a href="#" title=""></a> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem
                      quam.</p>
                    <span>2 hours ago</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-md-6 col-xs-12">
            <div class="widget">
              <div class="widget-title">
                <h4>Popular Courses</h4>
                <hr>
              </div>
              <ul class="popular-courses">
                <li>
                  <a href="single-course.html" title=""><img class="img-thumbnail"
                      src="{{ asset('front-assets/upload/xservice_01.png.pagespeed.ic.2iuJZT3CaV.png') }}" alt=""></a>
                </li>
                <li>
                  <a href="single-course.html" title=""><img class="img-thumbnail"
                      src="{{ asset('front-assets/upload/xservice_02.png.pagespeed.ic.c6RThoxSWC.png') }}" alt=""></a>
                </li>
                <li>
                  <a href="single-course.html" title=""><img class="img-thumbnail"
                      src="{{ asset('front-assets/upload/xservice_03.png.pagespeed.ic.E_Ew4wn4ZP.png') }}" alt=""></a>
                </li>
                <li>
                  <a href="single-course.html" title=""><img class="img-thumbnail"
                      src="{{ asset('front-assets/upload/xservice_04.png.pagespeed.ic.NGi9jRXTXk.png') }}" alt=""></a>
                </li>
                <li>
                  <a href="single-course.html" title=""><img class="img-thumbnail"
                      src="{{ asset('front-assets/upload/xservice_05.png.pagespeed.ic.2iuJZT3CaV.png') }}" alt=""></a>
                </li>
                <li>
                  <a href="single-course.html" title=""><img class="img-thumbnail"
                      src="{{ asset('front-assets/upload/xservice_06.png.pagespeed.ic.o2Uniwq-y5.png') }}" alt=""></a>
                </li>
                <li>
                  <a href="single-course.html" title=""><img class="img-thumbnail"
                      src="{{ asset('front-assets/upload/xservice_07.png.pagespeed.ic.H-fRTeeP8u.png') }}" alt=""></a>
                </li>
                <li>
                  <a href="single-course.html" title=""><img class="img-thumbnail"
                      src="{{ asset('front-assets/upload/xservice_08.png.pagespeed.ic.76ek5JLaEY.png') }}" alt=""></a>
                </li>
                <li>
                  <a href="single-course.html" title=""><img class="img-thumbnail"
                      src="{{ asset('front-assets/upload/xservice_09.png.pagespeed.ic.FJcG938KC-.png') }}" alt=""></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-3 col-md-6 col-xs-12">
            <div class="widget">
              <div class="widget-title">
                <h4>Contact Details</h4>
                <hr>
              </div>
              <ul class="contact-details">
                <li><i class="fa fa-link"></i> <a href="#">www.yoursite.com</a></li>
                <li><i class="fa fa-envelope"></i> <a href="mailto:info@yoursite.com">info@yoursite.com</a></li>
                <li><i class="fa fa-phone"></i> +90 123 45 67</li>
                <li><i class="fa fa-fax"></i> +90 123 45 68</li>
                <li><i class="fa fa-home"></i> INC 22 Elizabeth Str. Melbourne. Victoria 8777.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <section class="copyright">
      <div class="container">
        <div class="row">
          <div class="col-md-6 text-left">
            <p><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></p>
          </div>
          <div class="col-md-6 text-right">
            <ul class="list-inline">
              <li><a href="#">Terms of Usage</a></li>
              <li><a href="#">Privacy Policy</a></li>
              <li><a href="#">Sitemap</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
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
  <script src="{{ asset('front-assets/rs-plugin/js/jquery.themepunch.tools.min.js.pagespeed.jm.0PLSBOOLZa.js') }}"></script>
  <script src="{{ asset('front-assets/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
  <script>
    jQuery(document).ready(function(){jQuery('.tp-banner').show().revolution({dottedOverlay:"none",delay:16000,startwidth:1170,startheight:620,hideThumbs:200,thumbWidth:100,thumbHeight:50,thumbAmount:5,navigationType:"none",navigationArrows:"solo",navigationStyle:"preview3",touchenabled:"on",onHoverStop:"on",swipe_velocity:0.7,swipe_min_touches:1,swipe_max_touches:1,drag_block_vertical:false,parallax:"mouse",parallaxBgFreeze:"on",parallaxLevels:[10,7,4,3,2,5,4,3,2,1],parallaxDisableOnMobile:"off",keyboardNavigation:"off",navigationHAlign:"center",navigationVAlign:"bottom",navigationHOffset:0,navigationVOffset:20,soloArrowLeftHalign:"left",soloArrowLeftValign:"center",soloArrowLeftHOffset:20,soloArrowLeftVOffset:0,soloArrowRightHalign:"right",soloArrowRightValign:"center",soloArrowRightHOffset:20,soloArrowRightVOffset:0,shadow:0,fullWidth:"on",fullScreen:"off",spinner:"spinner4",stopLoop:"off",stopAfterLoops:-1,stopAtSlide:-1,shuffle:"off",autoHeight:"off",forceFullWidth:"off",hideThumbsOnMobile:"off",hideNavDelayOnMobile:1500,hideBulletsOnMobile:"off",hideArrowsOnMobile:"off",hideThumbsUnderResolution:0,hideSliderAtLimit:0,hideCaptionAtLimit:0,hideAllCaptionAtLilmit:0,startWithSlide:0,fullScreenOffsetContainer:""});});
  </script>
  <script src="{{ asset('front-assets/js/bxslider.js.pagespeed.jm.X-sF7YFq4Y.js') }}"></script>
  <script type="text/javascript">
    (function($){"use strict";$('.bxslider').bxSlider({mode:'vertical',minSlides:1,maxSlides:1,slideMargin:0,pager:false,nextText:'<i class="fa fa-arrow-down"></i>',prevText:'<i class="fa fa-arrow-up"></i>',speed:1000,auto:true});})(jQuery);
  </script>
    <script src="{{ asset('front-assets/js/custom.js') }}"></script>
    @yield('js')

</body>

<!--  38:47  -->

</html>