
<div class="container">
    @vite(['resources/css/activity.css', 'resources/js/activity.js'])
    <!-- Activity Details Section -->
    <h1>{{ $activity->name }}</h1>

    <!-- Display the image of the activity -->
    @if($activity->image)
        <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->name }}" style="max-width: 50%; height: auto; margin-bottom: 20px;">
    @endif

    <button id="showFormBtn" class="btn btn-primary mb-3" onclick="window.history.back()">Terug</button>

    <div class="detailInfo">
    <p><strong>Locatie:</strong> {{ $activity->location }}</p>
    <p><strong>Beschikbaarheid van eten en drinken:</strong> {{ $activity->food_and_drinks_available ? 'Ja' : 'Nee' }}</p>
    <p><strong>Beschrijving:</strong> {{ $activity->description }}</p>
    <p><strong>Startdatum en -tijd:</strong> {{ \Carbon\Carbon::parse($activity->start_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur</p>
    <p><strong>Einddatum en -tijd:</strong> {{ \Carbon\Carbon::parse($activity->end_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur</p>
    <p><strong>Kosten:</strong> &euro;{{ number_format($activity->cost, 2, ',', '.') }}</p>
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
    <button id="showFormBtn" class="btn btn-primary mb-3">Schrijf je in voor deze activiteit</button>

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

<!-- Inline script to toggle the registration form visibility -->
<script>
    document.getElementById('showFormBtn').addEventListener('click', function() {
        var form = document.getElementById('registrationForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    document.getElementById('shareBtn').addEventListener('click', function() {
        const activityUrl = "{{ url()->current() }}";  // Get the current URL of the activity
        const activityTitle = "{{ $activity->name }}";  // Get the activity name
        
        if (navigator.share) {
            navigator.share({
                title: activityTitle,
                url: activityUrl,
                text: `Bekijk deze activiteit: ${activityTitle}`
            }).then(() => {
                console.log('Activity link shared successfully.');
            }).catch(err => {
                console.error('Error sharing the activity link:', err);
            });
        } else {
            // Fallback for browsers that don't support the Web Share API
            const textArea = document.createElement('textarea');
            textArea.value = activityUrl;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('De link is gekopieerd naar het klembord.');
        }
    });
</script>
