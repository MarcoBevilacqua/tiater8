<!DOCTYPE HMTL>
<html>
<head>
		<title>Tiater - Area Amministrativa</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<script type="text/javascript">
        var APP_URL = "{{(url('/'))}}";
        </script>
		<link href='http://fonts.googleapis.com/css?family=Raleway:300,500' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Abel|Raleway:200,300" rel="stylesheet" type="text/css">
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
                            <h3>
                            <i class="fa fa-user"></i>{{Auth::user()->name}}</h3>
                        </li>
                        <li>
                            <a class="active" href="{{URL::to('/')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-cog fa-fw"></i> Prenotazioni<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{URL::to('book/create')}}">Aggiungi prenotazione</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('search/booking')}}">Cerca Prenotazione</a>
                                </li>
                                <!--
                                <li>
                                    <a href="{{URL::to('book/all')}}">Gestisci Prenotazioni</a>
                                </li>
                                -->
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="tables.html">
                            <i class="fa fa-table fa-fw"></i> Amministrazione<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{URL::to('show')}}">Spettacoli</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('viewer')}}">Soci</a>
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