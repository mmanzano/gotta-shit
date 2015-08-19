<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    @include('scripts.head')
</head>
<body>

@include('sections.header')

@include('sections.navigation')

@include('sections.disclaimer')

@yield('content')

@include('sections.footer')

@include('scripts.javascript')

@yield('javascript')

</body>
</html>
