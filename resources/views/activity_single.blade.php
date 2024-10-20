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
        <p style=display flex;align-items center;
        svg version=1.1 id=_x32_ xmlns=httpwww.w3.org2000svg
            xmlnsxlink=httpwww.w3.org1999xlink width=30px height=30px viewBox=0 0 512 512
            xmlspace=preserve
            style type=textcss
                ![CDATA[
                .st0 {
                    fill #000000;
                }
                ]]
            style
            g
                path class=st0
                    d=M147.57,320.188c-0.078-0.797-0.328-1.531-0.328-2.328v-6.828c0-3.25,0.531-6.453,1.594-9.5
                    c0,0,17.016-22.781,25.063-49.547c-8.813-18.594-16.813-41.734-16.813-64.672c0-5.328,0.391-10.484,0.938-15.563
                    c-11.484-12.031-27-18.844-44.141-18.844c-35.391,0-64.109,28.875-64.109,73.75c0,35.906,29.219,74.875,29.219,74.875
                    c1.031,3.047,1.563,6.25,1.563,9.5v6.828c0,8.516-4.969,16.266-12.719,19.813l-46.391,18.953
                    C10.664,361.594,2.992,371.5,0.852,383.156l-0.797,10.203c-0.406,5.313,1.406,10.547,5.031,14.438
                    c3.609,3.922,8.688,6.125,14.016,6.125H94.93l3.109-39.953l0.203-1.078c3.797-20.953,17.641-38.766,36.984-47.672L147.57,320.188z 
                path class=st0 d=M511.148,383.156c-2.125-11.656-9.797-21.563-20.578-26.531l-46.422-18.953
                    c-7.75-3.547-12.688-11.297-12.688-19.813v-6.828c0-3.25,0.516-6.453,1.578-9.5c0,0,29.203-38.969,29.203-74.875
                    c0-44.875-28.703-73.75-64.156-73.75c-17.109,0-32.625,6.813-44.141,18.875c0.563,5.063,0.953,10.203,0.953,15.531
                    c0,22.922-7.984,46.063-16.781,64.656c8.031,26.766,25.078,49.563,25.078,49.563c1.031,3.047,1.578,6.25,1.578,9.5v6.828
                    c0,0.797-0.266,1.531-0.344,2.328l11.5,4.688c20.156,9.219,34,27.031,37.844,47.984l0.188,1.094l3.094,39.969h75.859
                    c5.328,0,10.406-2.203,14-6.125c3.625-3.891,5.438-9.125,5.031-14.438L511.148,383.156z 
                path class=st0 d=M367.867,344.609l-56.156-22.953c-9.375-4.313-15.359-13.688-15.359-23.969v-8.281
                    c0-3.906,0.625-7.797,1.922-11.5c0,0,35.313-47.125,35.313-90.594c0-54.313-34.734-89.234-77.594-89.234
                    c-42.844,0-77.594,34.922-77.594,89.234c0,43.469,35.344,90.594,35.344,90.594c1.266,3.703,1.922,7.594,1.922,11.5v8.281
                    c0,10.281-6.031,19.656-15.391,23.969l-56.156,22.953c-13.047,5.984-22.344,17.984-24.906,32.109l-2.891,37.203h139.672h139.672
                    l-2.859-37.203C390.211,362.594,380.914,350.594,367.867,344.609z 
            g
        svg
        {{ $activity-min_participants }}
    /p>
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
    @if ($registrations->isEmpty())
        <p>Er zijn nog geen inschrijvingen voor deze activiteit.</p>
    @else
        <ul>
            @foreach ($registrations as $registration)
                <li>{{ $registration->name }} {{ $registration->surname }}</li>
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

<!-- Inline script to toggle the registration form visibility -->
<script>
    document.getElementById('showRegistrationFormBtn').addEventListener('click', function() {
        var form = document.getElementById('registrationForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    // Script to make sharing a link with text functional
    document.getElementById('shareBtn').addEventListener('click', function() {
        // Carbon is used to make date formatting easier. Starts off by converting database data.
        const activityUrl = "{{ url()->current() }}"; // Get the current URL of the activity
        const activityTitle = "{{ $activity->name }}"; // Get the activity name
        const activityLocation = "{{ $activity->location }}"; // Get the location
        const foodAndDrinks =
        "{{ $activity->food_and_drinks_available ? 'Ja' : 'Nee' }}"; // Food and Drinks availability
        const activityDescription = "{{ $activity->description }}"; // Activity description
        const startDate =
            "{{ \Carbon\Carbon::parse($activity->start_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur"; // Start date
        const endDate =
            "{{ \Carbon\Carbon::parse($activity->end_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur"; // End date
        const cost = "€{{ number_format($activity->cost, 2, ',', '.') }}"; // Activity cost

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
