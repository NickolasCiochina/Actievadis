@extends('layout')
@section('content')
<div class="container">
    @vite(['resources/css/activity.css'])
    <div class="row">
        <div class="col-md-12">
            <h1>Afgelopen Activiteiten</h1>
        </div>
    </div>

    <div class="row mt-4">
        @if ($endedActivities->isEmpty())
            <div class="col-md-12">
                <div class="alert alert-info">
                    Er zijn momenteel geen afgelopen activiteiten.
                </div>
            </div>
        @else
            @foreach ($endedActivities as $activity)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('activity.show', $activity->id) }}" class="cardLink">
                        <div class="card h-100 shadow-sm">
                            @if ($activity->image)
                                <img src="{{ asset('storage/' . $activity->image) }}" class="card-img-top" alt="{{ $activity->name }}" style="max-height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top card-placeholder" style="height: 200px; background-color: #f0f0f0;"></div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $activity->name }}</h5>
                                <p class="card-text">
                                    Geëindigd op: {{ \Carbon\Carbon::parse($activity->end_date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur
                                </p>
                            </div>
                        </div>
                    </a>
                </div>            
            @endforeach
        @endif
    </div>
</div>
@endsection
