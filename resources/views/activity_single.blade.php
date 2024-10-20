@extends('layout')
@section('content')
<div class="container">
    @vite(['resources/css/activity.css'])
    <!-- Activity Details Section -->
    <h1>{{ $activity->name }}</h1>

    <!-- Display the image of the activity -->
    @if($activity->image)
        <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->name }}" style="max-width: 50%; height: auto; margin-bottom: 20px;">
    @endif

    <!-- Back Button -->
    <button id="backBtn" class="btn btn-primary mb-3" onclick="window.history.back()">Terug</button>

    <div class="detailInfo">
        <p><strong>Locatie:</strong> {{ $activity->location }}</p>
        <p><strong>Beschikbaarheid van eten en drinken:</strong> {{ $activity->food_and_drinks_available ? 'Ja' : 'Nee' }}</p>

        <!-- Only show description if it exists -->
        @if(!empty($activity->description))
            <p><strong>Beschrijving:</strong> {{ $activity->description }}</p>
        @endif

        <p><strong>Startdatum en -tijd:</strong> {{ \Carbon\Carbon::parse($activity->start_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur</p>
        <p><strong>Einddatum en -tijd:</strong> {{ \Carbon\Carbon::parse($activity->end_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur</p>
        <p><strong>Kosten:</strong> &euro;{{ number_format($activity->cost, 2, ',', '.') }}</p>
        <p><strong>Minimum aantal deelnemers:</strong> {{ $activity->min_participants }}</p>
        <p><strong>Maximum aantal deelnemers:</strong> {{ $activity->max_participants }}</p>
        <p><strong>Voor wie:</strong>
            {{ $activity->is_for_covadis_members ? 'Alleen voor Covadis-leden' : 'Iedereen' }}
        </p>
    </div>

    <!-- Share Button -->
    <button id="shareBtn" class="btn btn-secondary mb-3">Deel deze activiteit</button>

    <!-- Display success message if registration is successful -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Button to show the registration form -->
    <button id="showRegistrationFormBtn" class="btn btn-primary mb-3">Schrijf je in voor deze activiteit</button>

    <!-- Registration form, hidden by default -->
    <div id="registrationForm" style="display: none;">
        <h2>Inschrijven voor activiteit</h2>
        <form action="{{ route('activity.register', $activity->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Naam:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="surname">Achternaam:</label>
                <input type="text" name="surname" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Inschrijven</button>
        </form>
    </div>

    <!-- List of registered people -->
    <h2>Ingeschreven personen:</h2>
    @if($registrations->isEmpty())
        <p>Er zijn nog geen inschrijvingen voor deze activiteit.</p>
    @else
        <ul>
            @foreach($registrations as $registration)
                <li>{{ $registration->name }} {{ $registration->surname }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Delete Activity Form -->
    <form action="{{ route('activity.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze activiteit wilt verwijderen?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Activiteit verwijderen</button>
    </form>
</div>
@endsection

<!-- Inline script to toggle the registration form visibility -->
<script>
    document.getElementById('showRegistrationFormBtn').addEventListener('click', function() {
        var form = document.getElementById('registrationForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    // Script to make sharing a link with text functional
    document.getElementById('shareBtn').addEventListener('click', function() {
        // Carbon is used to make date formatting easier. Starts off by converting database data.
        const activityUrl = "{{ url()->current() }}";  // Get the current URL of the activity
        const activityTitle = "{{ $activity->name }}";  // Get the activity name
        const activityLocation = "{{ $activity->location }}";  // Get the location
        const foodAndDrinks = "{{ $activity->food_and_drinks_available ? 'Ja' : 'Nee' }}";  // Food and Drinks availability
        const activityDescription = "{{ $activity->description }}";  // Activity description
        const startDate = "{{ \Carbon\Carbon::parse($activity->start_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur";  // Start date
        const endDate = "{{ \Carbon\Carbon::parse($activity->end_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur";  // End date
        const cost = "€{{ number_format($activity->cost, 2, ',', '.') }}";  // Activity cost

        const activityDetails = `
        Locatie: ${activityLocation}
        Eten&Drinken: ${foodAndDrinks}
        Beschrijving: ${activityDescription}
        Start: ${startDate}
        Eind: ${endDate}
        Kosten: ${cost}`;

        // Check if Web Share API is supported
        if (navigator.share) {
            navigator.share({
                title: activityTitle,
                text: `${activityTitle}\n\n${activityDetails}`,
                url: activityUrl
            }).then(() => {
                console.log('Activity shared successfully!');
            }).catch((error) => {
                console.error('Error sharing activity:', error);
            });
        } else {
            // Fallback to copying to clipboard
            const textArea = document.createElement('textarea');
            textArea.value = `${activityTitle}\n\n${activityDetails}\n\nLink: ${activityUrl}`;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('De activiteit beschrijving is gekopieerd naar het klembord!');
        }
    });

</script>
