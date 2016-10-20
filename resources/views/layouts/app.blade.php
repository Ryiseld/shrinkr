<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shrinkr') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://use.fontawesome.com/3d5c01ed12.js"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        @include('layouts.partials._navbar')
        
        <div class="container">
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">{!! session('success') !!}</div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">{!! session('error') !!}</div>
                @endif

                @yield('content')  
            </div>
        </div>

        <div class="footer">
            Made with &#9825; by <a href="https://github.com/Ryiseld">Orel Lazri</a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/js/social.js"></script>
    @yield('scripts')
</body>
</html>
