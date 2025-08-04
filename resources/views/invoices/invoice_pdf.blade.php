<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px;}
        th, td { border: 1px solid #333; padding: 8px; text-align: left;}
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Facture n°{{ $order->id }}</h2>
    <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Client :</strong> {{ $order->user->name }}<br>
       <strong>Email :</strong> {{ $order->user->email }}<br>
       <strong>Adresse de livraison :</strong> {{ $order->delivery_address }}</p>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Produit supprimé' }}</td>
                    <td>{{ number_format($item->price, 0, ',', ' ') }} F CFA</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} F CFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3>Total TTC : {{ number_format($order->total, 0, ',', ' ') }} F CFA</h3>
    <p><strong>Mode de paiement :</strong> {{ $order->payment_mode == 'en_ligne' ? 'En ligne' : 'À la livraison' }}</p>
</body>
</html> 