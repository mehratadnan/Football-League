@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>League</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Team Name</th>
                <th>P</th>
                <th>W</th>
                <th>D</th>
                <th>L</th>
                <th>GF</th>
                <th>GA</th>
                <th>GD</th>
                <th>P</th>
            </tr>

            </thead>
            <tbody>
            @foreach ($data['league'] as $info)
                <tr>
                    <td>{{ $info->team->name }}</td>
                    <td>{{ $info->played }}</td>
                    <td>{{ $info->won }}</td>
                    <td>{{ $info->drawn }}</td>
                    <td>{{ $info->lost }}</td>
                    <td>{{ $info->goals_for}}</td>
                    <td>{{ $info->goals_against}}</td>
                    <td>{{ $info->goal_difference}}</td>
                    <td>{{ $info->points}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h1>Championship Prodictions</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Team Name</th>
                <th>%</th>
            </tr>

            </thead>
            <tbody>
            @foreach ($data['league'] as $info)
                <tr>
                    <td>{{ $info->team->name }}</td>
                    <td>{{ $info->championship_percentage }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if(!empty($data['week']))
            <h1>{{$data['week']}} Week</h1>
            <table class="table">
                <thead>
                <tr>
                    <th>Home Team Name</th>
                    <th>Away Team Name</th>
                    <th>Date</th>
                </tr>

                </thead>
                <tbody>
                @foreach ($data['fixtures'] as $fixture)
                    <tr>
                        <td>{{ $fixture->homeTeam->name }}</td>
                        <td>{{ $fixture->awayTeam->name }}</td>
                        <td>{{ $fixture->date_time }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            <a href="{{ route('simulation.nextWeek' ,['week' => ($data['week'])])}}" class="btn btn-success">Next Week</a>
            <a href="{{ route('simulation.nextWeek' ,['week' => "all" ])}}" class="btn btn-success">All Week</a>
        @endif
        <a href="{{ route('league.reset')}}" class="btn btn-success">Reset Data</a>




    @if(!empty($data['oldFixtures']))
            <h1>List the results of the matches</h1>
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Matches</th>
                    <th></th>
                    <th></th>
                    <th>Date</th>
                </tr>

                </thead>
                <tbody>
                @foreach ($data['oldFixtures'] as $fixture)
                    <tr>
                        <td>{{ $fixture->homeTeam->name }}</td>
                        <td>{{ $fixture->result->home_team_score }}</td>
                        <td>-</td>
                        <td>{{ $fixture->result->away_team_score }}</td>
                        <td>{{ $fixture->awayTeam->name }}</td>
                        <td>{{ $fixture->date_time }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        @endif

    </div>
@endsection
