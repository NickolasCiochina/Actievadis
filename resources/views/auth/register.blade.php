@extends('layout')
@section('content')
<div class="container">
    @vite(['resources/css/activity.css'])
    <h1>Registreren</h1>
    <form action="{{ route('user.register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Naam:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="surname">Achternaam:</label>
            <input type="text" name="surname" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Wachtwoord:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Bevestig Wachtwoord:</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="is_covadis_member">Ben je een Covadis-lid?</label>
            <input type="checkbox" name="is_covadis_member" value="1">
        </div>
        <button type="submit" class="btn btn-primary">Registreren</button>
    </form>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error messages -->
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
