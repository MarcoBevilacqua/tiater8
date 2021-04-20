<!DOCTYPE HMTL>
<html>
<head>
		<title>Tiater</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
		<script type="text/javascript" src="{{ URL::asset('javascripts/bootstrap-datepicker.js')}}"></script>
		<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-theme.css') }}" media="screen">
		<link rel="stylesheet" href="{{ URL::asset('stylesheets/bootstrap-sticky-footer.css') }}" media="screen">
		<link rel="stylesheet" href="{{ URL::asset('stylesheets/admin/fonts/font-awesome/css/font-awesome.min.css') }}"  type="text/css">
		<noscript>

		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8." /><![endif]-->
	</head>
    <body>

        <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{URL::to('/')}}">Tiater <span class="text-hide"> v 0.0.1</span></a>
                </div>
                <!-- /.navbar-header -->
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#"><i class="fa fa-user fa-fw"></i> Profilo Utente</a>
                                </li>
                                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Impostazioni</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Esci</a>
                                </li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                    <!-- /.dropdown -->
                </ul>
                </div>
                <!-- /.navbar-top-links -->
                </div>
            </nav>
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>