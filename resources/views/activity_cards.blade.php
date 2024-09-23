<div class="container">
    <div class="row">
        @foreach($activities as $activity)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $activity->name }}</h5>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($activity->date)->locale('nl')->isoFormat('D MMMM YYYY, HH:mm') }} uur                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
