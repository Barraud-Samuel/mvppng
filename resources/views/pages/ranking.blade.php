@extends('layouts.app')
@section('content')
    <h2>Classements</h2>
    <table class="table table-dark">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Utilisateur</th>
            <th scope="col">email</th>
        </thead>
        <tbody>
            @foreach($userAll as $indexkey => $user)
                @if($user->id == $currentUser->id)
                    <tr class="bg-primary">
                        <td>{{$indexkey +1}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                    </tr>
                @else
                    <tr>
                        <td>{{$indexkey +1}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection
