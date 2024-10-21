@extends('layout')
@section('content')
<div class="container">
    @vite(['resources/css/activity.css'])
    <h1>Inloggen</h1>
    <form action="{{ route('user.login') }}" method="POST" class="logregForm">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Wachtwoord:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Inloggen</button>
    </form>

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
