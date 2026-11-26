<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FinTrack') · FinTrack</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
@livewireStyles
    @fluxAppearance
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
    <main class="min-h-screen flex items-center justify-center px-4 py-10">
        @yield('content')
    </main>
    @livewireScripts
@fluxScripts
</body>
</html>
