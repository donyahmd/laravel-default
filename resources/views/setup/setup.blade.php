<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Setup - Aplikasi Web</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/AdminLTE/css/_all-skins.min.css') }}"> --}}
    <!-- CustomCSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/setup.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ URL::to('/') }}" class="navbar-brand text-center">
                            <img src="{{ asset('assets/image/uw/logo-40px.png') }}" alt="Utamaweb Logo">
                        </a>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>
        <!-- Full Width Column -->
        <div class="content-wrapper">
            <div class="container">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <b>Setup</b>
                        <small>Aplikasi Web</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Setup</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="callout callout-info">
                        <p>Pastikan semua library <b>Web Server</b> telah diinstall dan di configurasi dengan baik. Lalu
                            lakukan Setup aplikasi ini.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            @foreach ($errors->all() as $error)
                                    {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="box box-warning">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Configurasi</h3>
                                </div>
                                <div class="box-body">
                                    {!! Form::open(['action' => 'SetupController@setup']) !!}
                                    <div class="form-group @error('APP_NAME') has-error @enderror">
                                        {{ Form::label('APP_NAME', 'Application Name') }}
                                        {{ Form::text('APP_NAME', null, [
                                            'class'         =>  'form-control',
                                            'placeholder'   =>  'Ex: Utamaweb'
                                        ]) }}
                                        @error('APP_NAME')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('APP_URL') has-error @enderror">
                                        {{ Form::label('APP_URL', 'Application URL') }}
                                        {{ Form::text('APP_URL', null, [
                                            'class'         =>  'form-control',
                                            'placeholder'   =>  'Ex: http://localhost'
                                        ]) }}
                                        @error('APP_URL')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('DB_CONNECTION') has-error @enderror">
                                        {{ Form::label('DB_CONNECTION', 'Database Connection') }}
                                        {{ Form::select('DB_CONNECTION', array('mysql' => 'MySQL', 'sqlite' => 'SQLite', 'pgsql' => 'PostgreSQL', 'sqlsrv' => 'SQL Server'), 'mysql', [
                                            'class' =>  'form-control'
                                        ]) }}
                                        @error('DB_CONNECTION')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('DB_HOST') has-error @enderror">
                                        {{ Form::label('DB_HOST', 'Database Host') }}
                                        {{ Form::text('DB_HOST', '127.0.0.1', [
                                            'class'         =>  'form-control',
                                            'placeholder'   =>  'Ex: 127.0.0.1'
                                        ]) }}
                                        @error('DB_HOST')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('DB_PORT') has-error @enderror">
                                        {{ Form::label('DB_PORT', 'Database Port') }}
                                        {{ Form::text('DB_PORT', '3306', [
                                            'class'         =>  'form-control',
                                            'placeholder'   =>  'Ex: 3306'
                                        ]) }}
                                        @error('DB_PORT')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('DB_DATABASE') has-error @enderror">
                                        {{ Form::label('DB_DATABASE', 'Database Name') }}
                                        {{ Form::text('DB_DATABASE', null, [
                                            'class'         =>  'form-control',
                                            'placeholder'   =>  'Ex: db_application'
                                        ]) }}
                                        @error('DB_DATABASE')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('DB_USERNAME') has-error @enderror">
                                        {{ Form::label('DB_USERNAME', 'Username') }}
                                        {{ Form::text('DB_USERNAME', 'root', [
                                            'class'         =>  'form-control',
                                            'placeholder'   =>  'Ex: root'
                                        ]) }}
                                        @error('DB_USERNAME')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('DB_PASSWORD') has-error @enderror">
                                        {{ Form::label('DB_PASSWORD', 'Password') }}
                                        {{ Form::password('DB_PASSWORD', [
                                            'class'         =>  'form-control',
                                            'placeholder'   =>  'Kosongkan jika tidak memakai password'
                                        ]) }}
                                        @error('DB_PASSWORD')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('APP_ENV') has-error @enderror">
                                        {{ Form::label('APP_ENV', 'Application Environment') }}
                                        {{ Form::select('APP_ENV', array('local' => 'Local', 'production' => 'Production',), 'local', [
                                            'class' =>  'form-control'
                                        ]) }}
                                        @error('APP_ENV')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-default btn-block btn-success btn-lg" style="margin-top:20px;"><b>Install</b></button>
                                    {!! Form::close() !!}
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="container">
                <div class="pull-right hidden-xs">
                    <strong>Copyright &copy; 2020 <a href="https://utamaweb.com/">Utamaweb.com</a></strong>
                </div>
            </div>
            <!-- /.container -->
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/AdminLTE/js/adminlte.min.js') }}"></script>
</body>

</html>
