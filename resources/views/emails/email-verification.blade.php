@extends('emails.index')
@section('title', 'Vérification de votre adresse email')
@section('content')
    @php
        $user = $data['user'] ?? [];
    @endphp
    <h2>Vérification de votre adresse email</h2>
    <p>Bonjour {{ trim(($user->prenom ?? '') . ' ' . ($user->nom ?? '')) }},</p>
    <p>Merci de vous être inscrit sur notre plateforme. Veuillez confirmer votre adresse e-mail pour activer
        votre compte.
    </p>
    <div class="text-center">
        <a href="{{ $data['url'] ?? '' }}" class="btn">Vérifier mon e-mail</a>
    </div>
    <p><strong>Attention :</strong> Ce lien expirera dans {{ $data['expire_time'] ?? '30' }} minutes.</p>
    <p>Si vous n'avez pas créé de compte, aucune autre action n'est requise.</p>
    <p>Merci,<br>L'équipe {{ config('app.name') }}</p>
@endsection
