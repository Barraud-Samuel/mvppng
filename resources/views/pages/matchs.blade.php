@extends('layouts.app')
@section('content')
<h2>matchs</h2>
@if(count($matchs)>0)
    @foreach($matchs as $match)
        <div class="card text-center mt-3">
            <div class="card-title">
                <p class="pt-3">jour de la competition : {{$match->matchday}}

                    <span class="badge badge-dark">a planifier</span>
                </p>
            </div>
            <div class="row">
                <div class="col-5">
                    <p>{{$match->homeTeamName}}</p>
                    <p>{{$match->result_goalsHomeTeam}}</p>
                    <p>
                        @foreach($pronostics as $pronostic)
                            @if($match->id === $pronostic->match_id)
                                {{$pronostic->homeTeam_prono}}
                            @endif
                        @endforeach
                    </p>
                    {!! Form::open(['action' => 'MatchsController@store','method'=>'POST']) !!}
                    <div class="form-group px-5">
                        {{Form::label('score','score')}}
                        {{Form::number('score','',['class'=>'form-control','placeholder'=>'score'])}}
                        {{Form::text('id',$match->id,['class'=>'form-control','placeholder'=>'id'])}}
                        {{Form::submit('Save',['class'=>'btn btn-primary mt-2'])}}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-2">
                    <p></p>
                    <p>vs</p>
                </div>
                <div class="col-5">
                    <p>{{$match->awayTeamName}}</p>
                    <p>{{$match->result_goalsAwayTeam}}</p>
                    <p>
                        @foreach($pronostics as $pronostic)
                            @if($match->id === $pronostic->match_id)
                                {{$pronostic->awayTeam_prono}}
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
        {{$matchs->links()}}
    @endforeach
@else
    <p>Pas de matchs de prévu (</p>
@endif
@endsection
