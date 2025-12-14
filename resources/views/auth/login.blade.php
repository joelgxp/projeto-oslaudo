@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<h1 class="auth-title">Login</h1>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label for="email" class="form-label">E-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input">
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
        <label>
            <input type="checkbox" name="remember" class="form-checkbox">
            <span>Lembrar-me</span>
        </label>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Entrar</button>
    </div>

    <div class="auth-footer">
        <a href="{{ route('register') }}" class="auth-link">Não tem uma conta? Registre-se</a>
    </div>
</form>
@endsection

