@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Détail de la commande #{{ $order->id }}</h1>
    <p><strong>Client :</strong> {{ $order->user ? $order->user->name : '-' }}</p>
    <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Status :</strong> {{ $order->status }}</p>
    <p><strong>Total :</strong> {{ number_format($order->total, 0, ',', ' ') }} F CFA</p>
    <h3>Produits commandés</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product ? $item->product->name : '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', ' ') }} F CFA</td>
                    <td>{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} F CFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Formulaire de modification du statut de la commande -->
    <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="mb-3">
        @csrf
        @method('PATCH')
        <label for="status">Statut de la commande :</label>
        <select name="status" id="status" class="form-select d-inline w-auto mx-2">
            <option value="en_attente" {{ $order->status == 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="expediee" {{ $order->status == 'expediee' ? 'selected' : '' }}>Expédiée</option>
            <option value="livree" {{ $order->status == 'livree' ? 'selected' : '' }}>Livrée</option>
            <option value="annulee" {{ $order->status == 'annulee' ? 'selected' : '' }}>Annulée</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Mettre à jour</button>
    </form>

    <!-- Formulaire de modification du statut de paiement -->
    <form action="{{ route('orders.updatePayment', $order) }}" method="POST" class="mb-3">
        @csrf
        @method('PATCH')
        <label for="payment_status">Statut de paiement :</label>
        <select name="payment_status" id="payment_status" class="form-select d-inline w-auto mx-2">
            <option value="non_paye" {{ $order->payment_status == 'non_paye' ? 'selected' : '' }}>Non payé</option>
            <option value="paye" {{ $order->payment_status == 'paye' ? 'selected' : '' }}>Payé</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Mettre à jour</button>
    </form>
    <a href="{{ route('invoice.download', $order->id) }}" class="btn btn-success mb-2" target="_blank">Télécharger la facture PDF</a>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Retour à la liste</a>
</div>
@endsection 