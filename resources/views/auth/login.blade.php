@extends('layouts.publico')

@section('title', 'Iniciar Sesión - SuperFast')

@section('content')
    @include('auth.stitch-auth-content', [
        'defaultMode' => 'login',
        'defaultRole' => request('role') === 'merchant' ? 'merchant' : 'buyer'
    ])
@endsection
