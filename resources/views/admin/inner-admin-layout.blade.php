<!DOCTYPE HMTL>
<html>
<head>
    <title>Tiater - Area Amministrativa</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
    <script type="text/javascript">
    var APP_URL = "{{(url('/'))}}";
    </script>
    <script type="text/javascript" src="{{ URL::asset('javascripts/jquery-1.11.1.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('javascripts/bootstrap.js')}}"></script>

    <script type="text/javascript" src="{{ URL::asset('javascripts/admin/sb-admin-2.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('javascripts/admin/plugins/metisMenu/metisMenu.min.js')}}"></script>
    <link rel="stylesheet" href="{{ URL::asset('stylesheets/bootstrap.css') }}" >
    <link rel="stylesheet" href="{{ URL::asset('stylesheets/bootstrap-theme.css') }}" media="screen">
    <link rel="stylesheet" href="{{ URL::asset('stylesheets/bootstrap-sticky-footer.css') }}" media="screen">
    <link rel="stylesheet" href="{{ URL::asset('stylesheets/admin/sb-admin-2.css') }}" >
    <link rel="stylesheet" href="{{ URL::asset('stylesheets/style.css') }}" >
    <link rel="stylesheet" href="{{ URL::asset('stylesheets/tiater.css') }}" >

    {{-- FONTS --}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Raleway:300,500' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="{{ URL::asset('stylesheets/admin/plugins/metisMenu/metisMenu.min.css') }}" >
    <link rel="stylesheet" href="{{ URL::asset('stylesheets/admin/fonts/font-awesome/css/font-awesome.min.css') }}"  type="text/css">
		<noscript>

		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
	</head>
    <body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
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
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <!-- /input-group -->
                            <h3><i class="fa fa-user"></i>{{Auth::user()->name}}</h3></li>
                        <li><a class="active" href="{{URL::to('/')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                        <li>
                            <a href="#"><i class="fa fa-cog fa-fw"></i> Prenotazioni<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{{URL::to('book/create')}}">Aggiungi prenotazione</a></li>
                                <li><a href="{{URL::to('search/booking')}}">Cerca Prenotazione</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#">
                            <i class="fa fa-table fa-fw"></i> Amministrazione<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{URL::to("show")}}">Spettacoli</a>
                                </li>
                                <li>
                                    <a href="{{URL::to("viewer")}}">Soci</a>
                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        @yield('content')
    </div>
    </body>
</html>