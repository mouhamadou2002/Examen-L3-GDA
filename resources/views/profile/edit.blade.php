@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="profile-header">
            <h2 class="mb-2">Mon profil</h2>
            <div class="fw-light">Gérez vos informations personnelles et votre mot de passe</div>
        </div>
        <div class="profile-card">
            <div class="profile-section-title mb-3">Informations personnelles</div>
            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <form method="post" action="{{ route('profile.update') }}" class="profile-form">
                @csrf
                @method('patch')
                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Adresse</label>
                    <input id="address" name="address" type="text" class="form-control" value="{{ old('address', $user->address) }}" autocomplete="address">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Téléphone</label>
                    <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone', $user->phone) }}" autocomplete="phone">
                </div>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary ms-2">Retour à la boutique</a>
            </form>
        </div>
        <div class="profile-card">
            <div class="profile-section-title mb-3">Changer mon mot de passe</div>
            @include('profile.partials.update-password-form')
        </div>
    </div>
</div>
@endsection
