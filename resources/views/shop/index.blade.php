@extends('layouts.app')

@section('content')
<div class="row justify-content-center mb-4">
    <div class="col-md-10">
        <div class="card p-4 mb-4 text-center bg-light border-0 shadow-sm">
            <h1 class="mb-2 text-primary">Bienvenue sur Kay Dieund !</h1>
            <p class="lead mb-0">Découvrez nos produits et faites votre shopping en toute simplicité.</p>
        </div>
    </div>
</div>
@if(request('category'))
    <div class="alert alert-info d-flex align-items-center justify-content-between mb-4">
        <div>
            <strong>Filtré par catégorie :</strong> {{ $categories->find(request('category'))->name ?? '' }}
        </div>
        <a href="{{ route('shop.index') }}" class="btn btn-sm btn-outline-primary">Retirer le filtre</a>
    </div>
@endif
<div class="row">
    @forelse($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card card-product h-100">
                @if($product->image)
                    <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                @endif
                <div class="card-body text-center">
                    <h5 class="card-title mb-2">{{ $product->name }}</h5>
                    <p class="card-text small text-muted">{{ Str::limit($product->description, 60) }}</p>
                    <p class="card-text mb-2"><span class="fw-bold text-primary" style="font-size:1.2em;">{{ number_format($product->price, 0, ',', ' ') }} F CFA</span></p>
                    <a href="{{ route('shop.show', $product->id) }}" class="btn btn-primary w-100">Voir le produit</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <p>Aucun produit disponible pour le moment.</p>
        </div>
    @endforelse
</div>
<div class="d-flex justify-content-center mt-4">
    {{ $products->withQueryString()->links() }}
</div>
@endsection 