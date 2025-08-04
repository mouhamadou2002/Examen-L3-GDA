@extends('layouts.admin')

@section('content')
<div class="container">
    @if(auth()->user()->notifications->count() > 0)
        <div class="mb-4">
            <h4>Notifications récentes</h4>
            <ul class="list-group mb-3">
                @foreach(auth()->user()->unreadNotifications as $notification)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Nouvelle commande de {{ $notification->data['user_name'] }} (Commande #{{ $notification->data['order_id'] }}) - {{ number_format($notification->data['total'], 0, ',', ' ') }} F CFA
                        <form method="POST" action="{{ route('admin.notifications.read', $notification->id) }}">
                            @csrf
                            <button class="btn btn-sm btn-success">Marquer comme lue</button>
                        </form>
                    </li>
                @endforeach
                @if(auth()->user()->unreadNotifications->count() == 0)
                    <li class="list-group-item">Aucune nouvelle notification.</li>
                @endif
            </ul>
        </div>
    @endif
    <div class="alert alert-info">Bienvenue {{ auth()->user()->name }}, vous êtes connecté en tant qu'administrateur sur Kay Dieund !</div>
    <h1>Tableau de bord administrateur</h1>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Chiffre d'affaires</h5>
                    <p class="h3">{{ number_format($totalSales, 0, ',', ' ') }} F CFA</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Commandes</h5>
                    <p class="h3">{{ $ordersCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Produits</h5>
                    <p class="h3">{{ $productsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Clients</h5>
                    <p class="h3">{{ $clientsCount }}</p>
                </div>
            </div>
        </div>
    </div>
    <h3>Top 5 des produits les plus vendus</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité vendue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->total_vendus ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 