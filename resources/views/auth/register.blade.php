@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 4rem auto;">
    <div class="card">
        <h1 style="margin-bottom: 2rem; text-align: center; font-size: 1.875rem; font-weight: 700;">Registro</h1>

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
                <button type="submit" class="btn btn-primary" style="width: 100%;">Registrar</button>
            </div>

            <div style="text-align: center; margin-top: 1rem;">
                <a href="{{ route('login') }}" class="navbar-link">Já tem uma conta? Faça login</a>
            </div>
        </form>
    </div>
</div>
@endsection

