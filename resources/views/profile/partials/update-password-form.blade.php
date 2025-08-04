<form method="post" action="{{ route('password.update') }}" class="profile-form">
        @csrf
        @method('put')
    <div class="mb-3">
        <label for="current_password" class="form-label">Mot de passe actuel</label>
        <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
        @error('current_password', 'updatePassword')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
        </div>
    <div class="mb-3">
        <label for="password" class="form-label">Nouveau mot de passe</label>
        <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
        @error('password', 'updatePassword')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
        </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
        @error('password_confirmation', 'updatePassword')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
        </div>
    <button type="submit" class="btn btn-primary">Enregistrer le nouveau mot de passe</button>
            @if (session('status') === 'password-updated')
        <div class="alert alert-success mt-3">Mot de passe modifié avec succès.</div>
            @endif
    </form>
