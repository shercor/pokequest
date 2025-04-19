<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pokédex</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap desde CDN (opcional) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS (incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body style="background-color: #F0F0F0;">
    <nav class="navbar navbar-light bg-light mb-4" style="border-bottom: solid #ccc 1px; background-color: #ee1515 !important; height: 120px; border-bottom: solid #222224 25px;">
        <div class="container">
            <a class="navbar-brand" href="#">Pokédex Laravel</a>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>
</body>
</html>
