<!-- resources/views/fixtures/app.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Fixtures</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Week </th>
                <th>Date</th>
                <th>Home Team</th>
                <th>Away Team</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($fixtures as $fixture)
                <tr>
                    <td>{{ $fixture->week_number }}</td>
                    <td>{{ $fixture->date_time }}</td>
                    <td>{{ $fixture->homeTeam->name }}</td>
                    <td>{{ $fixture->awayTeam->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('simulation.index') }}" class="btn btn-success">Simulation</a>
    </div>
    <br><br>
@endsection
