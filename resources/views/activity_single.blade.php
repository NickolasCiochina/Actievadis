@extends('layout')
@section('content')
    <div class="container">
        @vite(['resources/css/activity.css'])
        <!-- Activity Details Section -->
        <h1>{{ $activity->name }}</h1>

        <!-- Display the image of the activity -->
        @if ($activity->image)
            <div class="image-container">
                <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->name }}" class="activity-image">
            </div>
        @endif

        <!-- Back Button -->
        <button id="backBtn" class="btn btn-primary mb-3" onclick="window.history.back()">Terug</button>

        <div class="detailInfo">
            <p><strong>Locatie:</strong> {{ $activity->location }}</p>
            <p><strong>Beschikbaarheid van eten en drinken:</strong>
                {{ $activity->food_and_drinks_available ? 'Ja' : 'Nee' }}</p>

            <!-- Only show description if it exists -->
            @if (!empty($activity->description))
                <p><strong>Beschrijving:</strong> {{ $activity->description }}</p>
            @endif

            <p><strong>Startdatum en -tijd:</strong>
                {{ \Carbon\Carbon::parse($activity->start_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur</p>
            <p><strong>Einddatum en -tijd:</strong>
                {{ \Carbon\Carbon::parse($activity->end_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur</p>
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

        <!-- Display error message if something goes wrong -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Only show the registration button if the activity has not ended and if the maximum number of participants has not been reached -->
        @php
            $registrationsCount = $registrations->count(); // Count how many registrations there are
        @endphp

        @if (\Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($activity->end_date)))
            @if ($registrationsCount < $activity->max_participants)
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
            @else
                <p class="alert alert-warning">Het maximum aantal deelnemers voor deze activiteit is bereikt. Inschrijven is
                    niet meer mogelijk.</p>
            @endif
        @else
            <p class="alert alert-warning">Deze activiteit is afgelopen en inschrijven is niet meer mogelijk.</p>
        @endif

        <!-- List of registered participants -->
        <h2>Ingeschreven personen:</h2>
        @if ($registrations->isEmpty())
            <p>Er zijn nog geen inschrijvingen voor deze activiteit.</p>
        @else
            <ul>
                @foreach ($registrations as $registration)
                    <li>
                        {{ $registration->name }} {{ $registration->surname }}

                        <!-- Check if the logged-in user matches the registration -->
                        @if (auth()->check() && auth()->user()->name == $registration->name && auth()->user()->surname == $registration->surname)
                            <!-- Show a button to unregister -->
                            <form action="{{ route('activity.unregister', ['activity' => $activity->id, 'registration' => $registration->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">X</button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        <!-- Delete Activity Form -->
        <form action="{{ route('activity.destroy', $activity->id) }}" method="POST"
            onsubmit="return confirm('Weet je zeker dat je deze activiteit wilt verwijderen?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Activiteit verwijderen</button>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle the registration form visibility when the button is clicked
        document.getElementById('showRegistrationFormBtn').addEventListener('click', function() {
            var registrationForm = document.getElementById('registrationForm');
            if (registrationForm.style.display === 'none' || registrationForm.style.display === '') {
                registrationForm.style.display = 'block';
            } else {
                registrationForm.style.display = 'none';
            }
        });

        // Script to make sharing a link with text functional
        document.getElementById('shareBtn').addEventListener('click', function() {
            const activityUrl = "{{ url()->current() }}";
            const activityTitle = "{{ $activity->name }}";
            const activityLocation = "{{ $activity->location }}";
            const foodAndDrinks = "{{ $activity->food_and_drinks_available ? 'Ja' : 'Nee' }}";
            const activityDescription = "{{ $activity->description }}";
            const startDate = "{{ \Carbon\Carbon::parse($activity->start_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur";
            const endDate = "{{ \Carbon\Carbon::parse($activity->end_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur";
            const cost = "€{{ number_format($activity->cost, 2, ',', '.') }}";

            const activityDetails = `
            Locatie: ${activityLocation}
            Eten&Drinken: ${foodAndDrinks}
            Beschrijving: ${activityDescription}
            Start: ${startDate}
            Eind: ${endDate}
            Kosten: ${cost}`;

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
                const textArea = document.createElement('textarea');
                textArea.value = `${activityTitle}\n\n${activityDetails}\n\nLink: ${activityUrl}`;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('De activiteit beschrijving is gekopieerd naar het klembord!');
            }
        });
    });
</script>
