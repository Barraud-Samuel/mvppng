@extends('layouts.app')
@section('content')
<h2>matchs</h2>
{{--@if(count($matchs)>0)
    @foreach($matchs as $match)
        @foreach($pronostics as $pronostic)
            @if($match->id === $pronostic->match_id)
                @include('pages.actionMatch.updateMatch')
            @else
                probleme ici
                @include('pages.actionMatch.createMatchs')
            @endif
        @endforeach

        @if(count($pronostics)>0)

        @else
            @include('pages.actionMatch.createMatchs')
        @endif
    @endforeach
@else
    <p>Pas de matchs de prévu (</p>
@endif--}}

@if(count($allMatch)>0)
    @foreach($matchsWithProno as $matchWithProno)
        @foreach($allProno as $Prono)
            @if($matchWithProno->id === $Prono->match_id)
                @include('pages.actionMatch.updateMatch')
            @endif
        @endforeach
    @endforeach
    @foreach($matchsWhithoutProno as $matchWhithoutProno)
        @include('pages.actionMatch.createMatchs')
    @endforeach
@else
    <p>Pas de matchs de prévu :(</p>
@endif
@endsection
