<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="SimpleList, sistema de lista">
    <meta name="author" content="Evolutionet Chile">
    <link rel="shortcut icon" href="/img/favicon.ico">
    <title>SimpleList | Login</title>

    <!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/AdminLTE.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/theme.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <section class="container">

        @if(Session::has('error_login'))
        <div class="alert alert-dismissable alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Woou! </strong> {{ Session::get('error_login') }}
        </div>
        @endif
        @if(Session::has('info_login'))
        <div class="alert alert-dismissable alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Yeah! </strong> {{ Session::get('info_login') }}
        </div>
        @endif

        <!-- Login -->
        <div class="form-box" id="login-box">
            <div class="header">Inicio de Sesión</div>
            {{ Form::open(array('url' => '/login')) }}
            {{ Form::token() }}
            <div class="body bg-gray">
                <div class="form-group">
                    {{ Form::text('username', $value = null , $attributes = array(
                        'placeholder' => 'Usuario' ,
                        'class' => 'form-control'
                    )) }}
                </div>
                <div class="form-group">
                    {{ Form::password('password' ,  $attributes = array(
                        'placeholder' => 'Contraseña' ,
                        'class' => 'form-control'
                    )) }}
                </div>
                <div class="form-group">
                    <div class="remember-me">
                        {{ Form::checkbox('remember', "1" , false , $attributes = array(
                            'id' => 'remember',
                            'class' => 'onoffswitch-checkbox'
                        )) }}
                        <span class="text">Recordarme</span>
                    </div>
                </div>
                <div class="footer">
                    {{ Form::submit('Enviar',$attributes = array(
                        'id' => 'submit-form',
                        'class' => 'btn bg-olive btn-block'
                    )) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </section>

    <div class="overlay-loading">
        <span class="loader"></span>
        <span class="loader-text">Cargando</span>
    </div>

    <!-- Scripts -->
    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
        $(document).on('ready',function(){
            $('.overlay-loading').fadeOut();
            setTimeout(function() {
                $('.alert').slideUp();
            }, 3000);
        });
    </script>
</body>
</html>