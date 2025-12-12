@extends('layouts.app')

@section('content')
<div class="card">
    <h1 style="margin-bottom: 1.5rem; font-size: 2rem; font-weight: 700;">Dashboard - Cliente</h1>
    
    <p style="font-size: 1.125rem; color: #6b7280; margin-bottom: 2rem;">
        Bem-vindo, <strong>{{ $user->name }}</strong>!
    </p>

    <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem; margin-top: 2rem;">
        <p style="color: #6b7280;">Área do cliente em desenvolvimento.</p>
    </div>
</div>
@endsection

