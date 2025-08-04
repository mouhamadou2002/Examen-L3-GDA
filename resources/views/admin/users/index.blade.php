@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Liste des clients</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->address }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>
                        <a href="{{ route('users.edit', $client) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <a href="{{ route('users.orders', $client) }}" class="btn btn-sm btn-info">Historique</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 