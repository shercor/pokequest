<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pokédex</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Carga de Bootstrap mediante CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Importación de fuente de videojuegos Google Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=VT323&display=swap" rel="stylesheet">

</head>
<body style="background-color: #F0F0F0; font-family: 'VT323', monospace;">
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
