<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activiteiten</title>

    @vite(['resources/css/app.css'])
</head>
<body>
    <!-- container -->
    <div class="layoutContainer">
        <!-- navbar -->
        <header>
            <nav>
                <div class="logo">
                    <a href="/"> <image src="{{ Vite::asset('resources/images/logo_covadis_2016.png') }}" alt="logo"></a>
                </div>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/covadis-activities">Covadis Activities</a></li>
                    <li><a href="/ended-activities">Ended Activities</a></li>
                </ul>
            </nav>
        </header>

        <!-- Main content goes here -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/covadis-activities">Covadis Activities</a></li>
                <li><a href="/ended-activities">Ended Activities</a></li>
            </ul>
        </footer>
    </div>

</body>
</html>
