<!DOCTYPE html>
<html lang="es">
<head>
    @include('scripts.head')
</head>
<body>

@include('sections.header')

@include('sections.navigation')

@yield('content')

@include('sections.footer')

@include('scripts.javascript')


</body>
</html>
