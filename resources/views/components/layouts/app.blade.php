<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Quadro de Insights' }}</title>
    
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased">
    {{ $slot }}
</body>
</html>
