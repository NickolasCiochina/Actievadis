<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Button to trigger the form visibility -->
            <button id="showFormBtn" class="btn btn-primary mb-3">Voeg een activiteit toe</button>

            <!-- Form is hidden by default -->
            <div id="activityForm" style="display: none;">
                <h2>Nieuwe activiteit toevoegen</h2>
                <form action="{{ route('activity.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Naam van de activiteit:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Locatie:</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="food_and_drinks_available">Beschikbaarheid van eten en drinken:</label>
                        <select name="food_and_drinks_available" class="form-control" required>
                            <option value="1">Ja</option>
                            <option value="0">Nee</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Beschrijving van de activiteit:</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Datum en tijdstip van aanvang:</label>
                        <input type="datetime-local" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Datum en tijdstip van het einde:</label>
                        <input type="datetime-local" name="end_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="cost">Kosten:</label>
                        <input type="number" step="0.01" name="cost" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Activiteit Toevoegen</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Check if there are activities, and if not, display a message -->
        @if($activities->isEmpty())
            <div class="col-md-12">
                <div class="alert alert-info">
                    Er zijn momenteel geen activiteiten beschikbaar.
                </div>
            </div>
        @else
            @foreach($activities as $activity)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body" style="border:1px solid black; border-radius: 10%; margin: 20px;">
                            <h5 class="card-title">
                                <a href="{{ route('activity.show', $activity->id) }}">
                                    {{ $activity->name }}
                                </a>
                            </h5>
                            <p class="card-text">
                                {{ \Carbon\Carbon::parse($activity->start_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<!-- Inline Script to toggle the form visibility -->
<script>
    document.getElementById('showFormBtn').addEventListener('click', function() {
        var form = document.getElementById('activityForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
</script>
