@extends('layouts.auth')

@section('title', 'Registro')

@section('content')
<h1 class="auth-title">Registro</h1>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group">
        <label for="name" class="form-label">Nome</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-input">
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="email" class="form-label">E-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-input">
        @error('email')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password" class="form-label">Senha</label>
        <input id="password" type="password" name="password" required class="form-input">
        @error('password')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required class="form-input">
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Registrar</button>
    </div>

    <div class="auth-footer">
        <a href="{{ route('login') }}" class="auth-link">Já tem uma conta? Faça login</a>
    </div>
</form>
@endsection

