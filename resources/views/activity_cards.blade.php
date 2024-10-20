@extends('layout')
@section('content')
<div class="container">
    @vite(['resources/css/activity.css'])
    <div class="row">
        <div class="col-md-12">
            <!-- Button to trigger the form visibility -->
            <button id="showFormBtn" class="btn btn-primary mb-3">Voeg een activiteit toe</button>

            <!-- Form is hidden by default -->
            <div id="activityForm" style="display: none;" class="p-4 rounded bg-light shadow">
                <h2>Nieuwe activiteit toevoegen</h2>
                <!-- Make sure enctype="multipart/form-data" is added to handle file uploads -->
                <form action="{{ route('activity.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Naam van de activiteit:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="location">Locatie:</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="food_and_drinks_available">Beschikbaarheid van eten en drinken:</label>
                        <select name="food_and_drinks_available" class="form-control" required>
                            <option value="1">Ja</option>
                            <option value="0">Nee</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Beschrijving van de activiteit:</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="min_participants">Minimum aantal deelnemers:</label>
                        <input type="number" name="min_participants" class="form-control" value="2" min="2" max="1000" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="max_participants">Maximum aantal deelnemers:</label>
                        <input type="number" name="max_participants" class="form-control" value="1000" min="2" max="1000" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="start_date">Datum en tijdstip van aanvang:</label>
                        <input type="datetime-local" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="end_date">Datum en tijdstip van het einde:</label>
                        <input type="datetime-local" name="end_date" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="cost">Kosten:</label>
                        <input type="number" step="0.01" name="cost" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="image">Afbeelding van de activiteit:</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <!-- Dropdown for Privéactiviteit -->
                    <div class="form-group mb-3">
                        <label for="is_for_covadis_members">Privéactiviteit binnen Covadis-leden:</label>
                        <select name="is_for_covadis_members" id="is_for_covadis_members" class="form-control" required>
                            <option value="1">Ja</option>
                            <option value="0">Nee</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Activiteit Toevoegen</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @if ($activities->isEmpty())
        <div class="col-md-12">
            <div class="alert alert-info">
                Er zijn momenteel geen activiteiten beschikbaar.
            </div>
        </div>
        @else
        @foreach ($activities as $activity)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm cardLink">
                <!-- Check if image exists -->
                <a href="{{ route('activity.show', $activity->id) }}">
                @if ($activity->image)
                <img src="{{ asset('storage/' . $activity->image) }}" class="card-img-top" alt="{{ $activity->name }}" style="max-height: 200px; object-fit: cover;">
                @else
                <div class="card-img-top card-placeholder" style="height: 200px; background-color: #f0f0f0;"></div>
                @endif
                    <div class="card-body">
                        <h5 class="card-title">

                            {{ $activity->name }}

                        </h5>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($activity->start_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur
                        </p>
                    </div>
                </a>
            </div>
        </div>


        @endforeach
        @endif
    </div>
</div>
@endsection


<!-- Inline Script to toggle the form visibility -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle the visibility of the activity form
        document.getElementById('showFormBtn').addEventListener('click', function() {
            var form = document.getElementById('activityForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });

        // Validate the start and end dates on form submission
        document.querySelector('form').addEventListener('submit', function(event) {
            const startDate = new Date(document.querySelector('input[name="start_date"]').value);
            const endDate = new Date(document.querySelector('input[name="end_date"]').value);
            const now = new Date();

            if (startDate < now) {
                event.preventDefault();
                alert('De startdatum mag niet in het verleden liggen.');
            } else if (startDate >= endDate) {
                event.preventDefault();
                alert('De startdatum moet minimaal 1 minuut vóór de einddatum liggen.');
            }
        });
    });
</script>
