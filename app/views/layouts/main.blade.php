<!-- --------------------------------------------------------
 |                  HIDALGO CASTRO <HC/>                    |
 |                                                          |
 |              http://www.hidalgocastro.com                |
 |                   Por Berni Hidalgo                      |
 |                berni@hidalgocastro.com                   |
 |                                                          |
 |                          </>                             |
 ------------------------------------------------------- -->

<!DOCTYPE html>
<html lang="es">
	<head>
        <meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Berni Hidalgo Castro">
        <meta name="description" content="{{ Setting::get('website.description') }}">
        <meta name="keywords" content="{{ Setting::get('website.keywords') }}">
        
		<title>{{ Setting::get('website.name') }} | {{ $title }}</title>
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
        
        <!-- Styles -->
        {{ HTML::style('styles/main-layout.css') }}
        @if( Setting::get('website.front') != '')
        <style type="text/css">
            #frontend {
                background: url('{{ URL::asset("/images/".Setting::get("website.front")) }}') center center;
            }
        </style>
        @endif
        
        @section('styles')
        @show
	</head>
	<body id="frontend" >
        <!-- Navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" data-toggle="@if (Request::is('/')){{'navbar'}}@endif">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ URL::to('/') }}">{{ Setting::get('website.name') }}</a>
                </div>
            </div>
        </nav>
        <!-- Container -->
        <div class="container">
            <div class="push"></div>
            @yield('content')
            <div class="push"></div>
        </div>
        <!-- Footer -->
        <footer class="footer">
            CopyRight &copy; {{ date('Y') }}. <a href="{{ URL::to('/') }}">{{ Setting::get('website.name') }}</a>.
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



