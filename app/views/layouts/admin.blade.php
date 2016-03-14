<!-----------------------------------------------------------
 |                  HIDALGO CASTRO <HC/>                    |
 |                                                          |
 |              http://www.hidalgocastro.com                |
 |                   Por Berni Hidalgo                      |
 |                berni@hidalgocastro.com                   |
 |                                                          |
 |                          </>                             |
 ---------------------------------------------------------->

<!DOCTYPE html>
<html lang="es">
	<head>
        <meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Berni Hidalgo Castro">
        <meta name="description" content="">
        <meta name="keywords" content="">

		<title>{{ Setting::get('website.name') }} | {{ $title }}</title>
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
        
        <!-- Styles-->
        {{ HTML::style('styles/admin-layout.css') }}

        @section('styles')
        @show
	</head>
	<body>
        <!-- Navmenu -->
        <aside id="navmenu" class="navmenu navmenu-inverse navmenu-fixed-left offcanvas-sm">
            <a class="navmenu-brand visible-md visible-lg" href="{{ URL::route('home') }}">
                <p>{{ Setting::get('website.name') }}</p>
                <p>{{ Setting::get('website.slogan') }}</p>
            </a>
            @if(!Auth::check())
            <div class="col-xs-12 logo">
                <img class="img-responsive" src="{{ URL::asset('images/tooth.png') }}" alt="{{ Setting::get('website.name') }}"/>
            </div>
            @else
            <ul class="nav navmenu-nav">
                <li><a href="{{ URL::route('dashboard') }}"><i class="fa fa-dashboard"></i> Escritorio</a></li>
                @if(Auth::user()->can("view-calendar"))
                <li><a href="{{ URL::route('calendar') }}"><i class="fa fa-calendar"></i> Calendario</a></li>
                @endif
                @if(Auth::user()->ability(NULL, "add-appointments,edit-appointments,view-appointments,delete-appointments"))
                <li><a href="{{ URL::route('appointment-list') }}"><i class="fa fa-book"></i> Citas</a></li>
                @endif
                @if(Auth::user()->ability(NULL, "add-events,edit-events,view-events,delete-events"))
                <li><a href="{{ URL::route('event-list') }}"><i class="fa fa-bell"></i> Eventos</a></li>
                @endif
                @if(Auth::user()->ability(NULL, "add-patients,edit-patients,view-patients,delete-patients"))
                <li><a href="{{ URL::route('patient-list') }}"><i class="fa fa-users"></i> Pacientes</a></li>
                @endif
                @if(Auth::user()->ability(NULL, "add-users,edit-users,view-users,delete-users"))
                <li><a href="{{ URL::route('user-list') }}"><i class="fa fa-user-md"></i> Usuarios</a></li>
                @endif
                @if(Auth::user()->can("view-reports"))
                <li><a href="{{ URL::route('reports') }}"><i class="fa fa-bar-chart-o"></i> Reportes</a></li>
                @endif
                @if(Auth::user()->can("config-system"))
                <li><a href="{{ URL::route('config-website') }}" ><i class="fa fa-gear"></i> Configuración</a></li>
                @endif
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i> Mi Cuenta 
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu navmenu-nav">
                        <li><a href="{{ URL::route('profile') }}">{{ Auth::user()->person->fullname() }}</a></li>
                        <li><a href="{{ URL::route('change-password') }}">Cambiar Contraseña</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ URL::route('logout') }}">Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
            @endif
        </aside>
        <!-- Navbar -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#navmenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::route('home') }}">{{ Setting::get('website.name') }}</a>
        </div>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <section class="col-xs-12">
                    <div class="page-header">
                        <a class="pull-right hidden-xs" href="http://www.ucr.ac.cr" title="Universidad de Costa Rica" target="_blank">
                            <img src="{{ URL::asset('images/ucr-logo.jpg') }}" alt="Universidad de Costa Rica"/>
                        </a>
                        <h1 class="nowrap">{{ $title }}</h1>
                    </div>
                    @yield('content')
                </section>
            </div>
            <div class="push"></div>
        </div>
        <!-- Footer -->
        <footer class="footer">
            <a href="{{ URL::route('home') }}">{{ Setting::get('website.name') }}</a> {{ date('Y') }}. Todos los derechos reservados.
        </footer>
    
        <!-- Scripts -->
        {{ HTML::script('scripts/raphael.min.js') }}
        {{ HTML::script('scripts/jquery.min.js') }}
        {{ HTML::script('scripts/moment.min.js') }}

        {{ HTML::script('scripts/bootstrap.min.js') }}
        {{ HTML::script('scripts/jasny-bootstrap.min.js') }}

        {{ HTML::script('scripts/components.min.js') }}
        {{ HTML::script('scripts/appstart.js') }}

        @section('scripts')
        @show
	</body>
</html>



