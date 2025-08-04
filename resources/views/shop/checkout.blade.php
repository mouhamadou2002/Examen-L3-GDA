@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Validation de la commande</h1>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('shop.placeOrder') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="delivery_address" class="form-label">Adresse de livraison</label>
            <input type="text" name="delivery_address" class="form-control" value="{{ old('delivery_address') }}" required>
        </div>
        <div class="mb-3">
            <label for="payment_mode" class="form-label">Mode de paiement</label>
            <select name="payment_mode" class="form-control" required>
                <option value="">-- Choisir --</option>
                <option value="en_ligne" {{ old('payment_mode') == 'en_ligne' ? 'selected' : '' }}>Paiement en ligne</option>
                <option value="a_la_livraison" {{ old('payment_mode') == 'a_la_livraison' ? 'selected' : '' }}>Paiement à la livraison</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Confirmer la commande</button>
        <a href="{{ route('shop.cart') }}" class="btn btn-secondary">Retour au panier</a>
    </form>
</div>
@endsection 