<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    @include('scripts.head')
</head>
<body>
<div id="app">
    @include('sections.navigation_user')

    @include('sections.header')

    @include('sections.navigation')

    @include('sections.disclaimer')

    @yield('content')

    @include('sections.footer')
</div>
@include('scripts.javascript')

@yield('javascript')

</body>
</html>
