<!DOCTYPE HMTL>
<html>
<head>
		<title>Tiater</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script type="text/javascript" src="{{ URL::asset('javascripts/jquery-1.11.1.js')}}"></script>
		<script type="text/javascript" src="{{ URL::asset('javascripts/bootstrap.js')}}"></script>
		<script type="text/javascript" src="{{ URL::asset('javascripts/bootstrap-datepicker.js')}}"></script>
		<link rel="stylesheet" href="{{ URL::asset('stylesheets/bootstrap.css') }}" >
		<link rel="stylesheet" href="{{ URL::asset('stylesheets/bootstrap-theme.css') }}" media="screen">
		<link rel="stylesheet" href="{{ URL::asset('stylesheets/bootstrap-sticky-footer.css') }}" media="screen">
		<link rel="stylesheet" href="{{ URL::asset('stylesheets/admin/fonts/font-awesome/css/font-awesome.min.css') }}"  type="text/css">
		<noscript>

		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
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