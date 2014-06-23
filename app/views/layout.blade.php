<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        @yield('special-meta')
        <title>@yield('title','SimpeList')</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="/css/theme.css" rel="stylesheet" type="text/css" />
        @yield('styles')

        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="skin-green">
        <!-- Header -->
        <header class="header">
            <!-- Logo -->
            <a href="/" class="logo">
                Swert Admin
            </a>
            <!-- NavBar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <!-- Notifications -->
                <div class="navbar-right">
                    @yield('notifications')
                </div>
            </nav>
        </header>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left Menu -->
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    @yield('menu')
                </section>
            </aside>

            <!-- Contend Main -->
            <aside class="right-side">
                <!-- Encabezado -->
                <section class="content-header">
                    @yield('header')
                </section>

                <!-- Main content -->
                <section class="content">
                    @yield('contend')
                </section>
            </aside>
        </div>

        <!-- Loader -->
        <div class="overlay-loading">
            <span class="loader"></span>
            <span class="loader-text">Cargando</span>
        </div>

        <!-- Scripts -->
        <script src="/js/jquery.js"></script>
        <script>
            var log;
            var values = new Array();
            $(document).on('ready',function(){
                $('.overlay-loading').fadeOut();
                $('.dropdown-toggle').dropdown();
                $('a').click(function(event) {
                    if($(this).attr('href') != "#"){
                        var tmpURL = $(this).attr('href');
                        event.preventDefault();
                        $('.overlay-loading').fadeIn();
                        setTimeout(function() {
                            window.location = tmpURL;
                        }, 800);
                    }
                });
                @yield('scriptsInLine')
            });
        </script>
        <script src="/js/bootstrap.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="/js/app.js" type="text/javascript"></script>

        @yield('scripts')
    </body>
</html>