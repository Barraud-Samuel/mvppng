@extends('layouts.app')
@section('content')
    <h2>Classements</h2>
    <table class="table">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Utilisateur</th>
            <th scope="col">email</th>
        </thead>
        <tbody>
            @foreach($userAll as $indexkey => $user)
                <tr>
                    <td>{{$indexkey +1}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
