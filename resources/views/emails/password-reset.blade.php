@extends('emails.index')
@section('title', 'Réinitialisation de votre mot de passe')
@section('content')
    @php
        $user = $data['user'] ?? [];
    @endphp
    <h2>Réinitialisation de votre mot de passe</h2>
    <p>Bonjour {{ trim(($user->prenom ?? '') . ' ' . ($user->nom ?? '')) }},</p>
    <p>Vous avez demandé la réinitialisation de votre mot de passe.
    </p>
    <div class="text-center">
        <a href="{{ $data['url'] ?? '' }}" class="btn">Réinitialiser mon mot de passe</a>
    </div>
    <p><strong>Attention :</strong> Ce lien expirera dans {{ $data['expire_time'] ?? '30' }} minutes.</p>
    <p>Si vous n'avez pas demandé cette réinitialisation, ignorez cet e-mail.</p>
    <p>Merci,<br>L'équipe {{ config('app.name') }}</p>
@endsection
