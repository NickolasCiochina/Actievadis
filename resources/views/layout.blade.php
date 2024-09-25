<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activiteiten</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- container -->
     <div class="container">
        <!-- navbar -->
         <header>
            <div class="logo">
                <a href="/"> <image src="{{ Vite::asset('resources/images/logo_covadis_2016.png') }}" alt="logo"></a>
            </div>
            <ul>
                <li>Home</li>
                <li>Activiteiten</li>
                <li>Item3</li>
            </ul>
         </header>

         @yield('content')
        <!-- Footer -->
         <footer>
            <ul>
                <li>Item1</li>
                <li>Item2</li>
                <li>Item3</li>
            </ul>
         </footer>
        
    </div>

</body>
</html>