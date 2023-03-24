@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Teams</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($teams as $team)
                <tr>
                    <td>{{ $team->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('fixtures.index') }}" class="btn btn-success">Generate Fixtures</a>
    </div>
@endsection

