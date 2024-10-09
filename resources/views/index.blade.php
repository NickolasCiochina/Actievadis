<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/wjcss.css', 'resources/js/wjcss.js'])
</head>
<body>
<div class="hero">
        <div class="overlay">
            <h1>Welkom bij Covadis planner</h1>
        </div>
    </div>

    <div class="menu-container">
        <div class="menu">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="/activities">Planning</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Over ons</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <p>Rest van content hier.</p>
    </div>

</body>
</html>
