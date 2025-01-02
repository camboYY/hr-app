<!-- resources/views/components/layout.blade.php -->
 
<html>
    <head>
        <title>{{ $title ?? 'Welcome' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex justify-center items-center h-screen">
        {{ $slot }}
    </body>
</html>