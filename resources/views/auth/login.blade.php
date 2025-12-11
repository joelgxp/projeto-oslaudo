@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 4rem auto;">
    <div class="card">
        <h1 style="margin-bottom: 2rem; text-align: center; font-size: 1.875rem; font-weight: 700;">Login</h1>

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
                <button type="submit" class="btn btn-primary" style="width: 100%;">Entrar</button>
            </div>

            <div style="text-align: center; margin-top: 1rem;">
                <a href="{{ route('register') }}" class="navbar-link">Não tem uma conta? Registre-se</a>
            </div>
        </form>
    </div>
</div>
@endsection

