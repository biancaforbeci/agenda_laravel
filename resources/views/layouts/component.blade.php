<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @yield('title')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('meta')
    @yield('css_assets')

    <link href="{{ asset('css/privatenav.css') }}" rel="stylesheet">
</head>



<body style="font-family: 'Muli', sans-serif !important;">

  @include('layouts.component_navbar')


  @yield('content')


  @include('layouts.component_footer')




    @yield('js_assets')

</body>
</html>
