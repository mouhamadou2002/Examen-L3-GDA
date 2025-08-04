@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5">
            @if($product->image)
                <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
            @endif
        </div>
        <div class="col-md-7">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <p class="card-text"><strong>{{ number_format($product->price, 0, ',', ' ') }} F CFA</strong></p>
            <p class="mb-2">
                @if($product->stock > 10)
                    <span class="badge bg-success">Stock restant : {{ $product->stock }}</span>
                @elseif($product->stock > 0)
                    <span class="badge bg-warning text-dark">Stock faible : {{ $product->stock }}</span>
                @else
                    <span class="badge bg-danger">Rupture de stock</span>
                @endif
            </p>
            @auth
                <form action="{{ route('shop.addToCart', $product->id) }}" method="POST" class="mt-3">
                    @csrf
                    <div class="mb-3">
                        <label for="quantity">Quantité :</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width:100px;display:inline-block;">
                    </div>
                    <button type="submit" class="btn btn-success">Ajouter au panier</button>
                    <a href="{{ route('shop.index') }}" class="btn btn-secondary">Retour</a>
                </form>
            @else
                <div class="alert alert-info mt-3">
                    <a href="{{ route('login') }}">Connectez-vous</a> pour ajouter ce produit au panier et commander.
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection 