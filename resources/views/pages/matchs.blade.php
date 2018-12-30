@extends('layouts.app')
@section('content')
<h2>matchs</h2>
{{--Ajout de classe active en fontioon de l'url--}}
<nav class="nav nav-pills mb-3 justify-content-end ">
    <a class=" nav-link {{ Request::segment(2) === 'incomming' ? 'active' : null }}" href="/matchs/incomming">A venir</a>
    <a class=" nav-link {{ Request::segment(2) === 'running' ? 'active' : null }}" href="/matchs/running">En cours</a>
    <a class=" nav-link {{ Request::segment(2) === 'finished' ? 'active' : null }}" href="/matchs/finished">Termminé</a>
</nav>
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
