@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détail de la commande #{{ $order->id }}</h1>
    <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Adresse de livraison :</strong> {{ $order->delivery_address }}</p>
    <p><strong>Statut :</strong> {{ ucfirst(str_replace('_', ' ', $order->status)) }}</p>
    <p><strong>Paiement :</strong> {{ $order->payment_status == 'paye' ? 'Payé' : 'Non payé' }}</p>
    <p><strong>Mode de paiement :</strong> {{ $order->payment_mode == 'en_ligne' ? 'En ligne' : 'À la livraison' }}</p>
    <h4>Produits commandés :</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Produit supprimé' }}</td>
                    <td>{{ number_format($item->price, 0, ',', ' ') }} F CFA</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} F CFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h4>Total de la commande : {{ number_format($order->total, 0, ',', ' ') }} F CFA</h4>
    <a href="{{ route('invoice.download', $order->id) }}" class="btn btn-primary" target="_blank">Télécharger la facture PDF</a>
    <a href="{{ route('shop.myOrders') }}" class="btn btn-secondary">Retour à mes commandes</a>
</div>
@endsection 