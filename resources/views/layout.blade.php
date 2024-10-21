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
                    <a href="/"> 
                        <image src="{{ Vite::asset('resources/images/logo_covadis_2016.png') }}" alt="logo">
                    </a>
                </div>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/covadis-activities">Covadis Activities</a></li>
                    <li><a href="/ended-activities">Ended Activities</a></li>
                    
                    <!-- Add dynamic user links here -->
                    @guest
                        <li><a href="{{ route('user.login') }}">Inloggen</a></li>
                        <li><a href="{{ route('user.register') }}">Registreren</a></li>
                    @else
                        <li>
                            <form action="{{ route('user.logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link">Uitloggen</button>
                            </form>
                        </li>
                    @endguest
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
