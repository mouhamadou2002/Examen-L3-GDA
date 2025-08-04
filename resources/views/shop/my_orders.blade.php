@extends('layouts.app')

@section('content')
<div class="container">
    @if(auth()->user()->notifications->count() > 0)
        <div class="mb-4">
            <h4>Notifications récentes</h4>
            <ul class="list-group mb-3">
                @foreach(auth()->user()->unreadNotifications as $notification)
                    @if(isset($notification->data['order_id']))
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @if(isset($notification->data['payment']))
                                Paiement confirmé pour la commande #{{ $notification->data['order_id'] }} - {{ number_format($notification->data['total'], 0, ',', ' ') }} F CFA
                            @elseif(isset($notification->data['status']))
                                Statut de la commande #{{ $notification->data['order_id'] }} mis à jour : {{ ucfirst($notification->data['status']) }}
                            @else
                                Confirmation de la commande #{{ $notification->data['order_id'] }} - {{ number_format($notification->data['total'], 0, ',', ' ') }} F CFA
                            @endif
                            <form method="POST" action="{{ route('shop.notifications.read', $notification->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-success">Marquer comme lue</button>
                            </form>
                        </li>
                    @endif
                @endforeach
                @if(auth()->user()->unreadNotifications->count() == 0)
                    <li class="list-group-item">Aucune nouvelle notification.</li>
                @endif
            </ul>
        </div>
    @endif
    <h1>Mes commandes</h1>
    @if($orders->isEmpty())
        <p>Vous n'avez pas encore passé de commande.</p>
        <a href="{{ route('shop.index') }}" class="btn btn-primary">Voir le catalogue</a>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Paiement</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $order->total }} €</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</td>
                        <td>{{ $order->payment_status == 'paye' ? 'Payé' : 'Non payé' }}</td>
                        <td><a href="{{ route('shop.orderDetail', $order->id) }}" class="btn btn-sm btn-info">Détail</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection 