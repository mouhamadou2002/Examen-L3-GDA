@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mon panier</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(empty($cart))
        <p>Votre panier est vide.</p>
        <a href="{{ route('shop.index') }}" class="btn btn-primary">Voir le catalogue</a>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <tr>
                        <td>
                            @if($item['image'])
                                <img src="{{ asset('storage/products/' . $item['image']) }}" width="60" alt="{{ $item['name'] }}">
                            @endif
                            {{ $item['name'] }}
                        </td>
                        <td>{{ number_format($item['price'], 0, ',', ' ') }} F CFA</td>
                        <td>
                            <form action="{{ route('shop.updateCart', $id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control" style="width:70px;display:inline-block;">
                                <button type="submit" class="btn btn-sm btn-primary">OK</button>
                            </form>
                        </td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} F CFA</td>
                        <td>
                            <form action="{{ route('shop.removeFromCart', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Retirer ce produit ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h4>Total : {{ number_format($total, 0, ',', ' ') }} F CFA</h4>
        <a href="{{ route('shop.checkout') }}" class="btn btn-success">Valider la commande</a>
    @endif
</div>
@endsection 