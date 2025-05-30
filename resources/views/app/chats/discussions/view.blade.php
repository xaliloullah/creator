@extends('dashboard.modules.chats.index')
@section('title', 'Chats')
@section('content')
    @livewire('chats.messages', ['discussion' => $discussion])
@endsection