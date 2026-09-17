@extends('layouts.publico')

@section('title', 'Crear Cuenta - SuperFast')

@section('content')
    @include('auth.stitch-auth-content', [
        'defaultMode' => 'register',
        'defaultRole' => 'buyer'
    ])
@endsection
