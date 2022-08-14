<!DOCTYPE html>
<html>
    <head>
        <title>ISMART STORE</title>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{-- <link href="{{asset('user/public/css/bootstrap/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('user/public/css/bootstrap/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/> --}}
        <link href="{{asset('user/public/reset.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('user/public/css/carousel/owl.carousel.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('user/public/css/carousel/owl.theme.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('user/public/css/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('user/public/style.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('user/public/responsive.css')}}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
        <link href="{{asset('user/public/css/lightslider.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('user/public/css/readAll.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('user/public/css/thumbnail.css')}}" rel="stylesheet" type="text/css"/>
    

        @yield('css')
        {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
        <script src="{{asset('user/public/js/jquery-2.2.4.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('user/public/js/elevatezoom-master/jquery.elevatezoom.js')}}" type="text/javascript"></script>
        <script src="{{asset('user/public/js/bootstrap/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('user/public/js/carousel/owl.carousel.js')}}" type="text/javascript"></script>
        <script src="{{asset('user/public/js/main.js')}}" type="text/javascript"></script>
        <script src="{{asset('user/public/js/lightslider.js')}}" type="text/javascript"></script>
        <script src="{{asset('user/public/js/readAll.js')}}" type="text/javascript"></script>
       
        @yield('js')
    </head>
    <body>
        <div id="site">
            <div id="container">
                <div id="header-wp">
                    @include('user.component.head_top')
                   @include('user.component.head_body')
                </div>
                @yield('content')
                @include('user.component.footer_wp')
                </div>
                @include('user.component.menu_reponse')
                <div id="btn-top"><img src="{{asset('user/public/images/icon-to-top.png')}}" alt=""/></div>
                <div id="fb-root"></div>
                <script>(function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id))
                            return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                </script>
                </body>
                </html>