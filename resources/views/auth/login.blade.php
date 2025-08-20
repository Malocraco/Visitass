@extends('layouts.auth')

@section('title', 'Iniciar Sesión - Sistema de Visitas')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h4>
            <i class="fas fa-sign-in-alt me-2"></i>
            Iniciar Sesión
        </h4>
    </div>
    
    <div class="auth-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-1"></i>
                    Correo Electrónico
                </label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-1"></i>
                    Contraseña
                </label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" 
                       class="form-check-input" 
                       id="remember" 
                       name="remember">
                <label class="form-check-label" for="remember">
                    Recordarme
                </label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Iniciar Sesión
                </button>
            </div>
        </form>
    </div>
    
    <div class="auth-footer">
        <p class="mb-0">
            ¿No tienes una cuenta? 
            <a href="{{ route('register') }}">
                Regístrate aquí
            </a>
        </p>
    </div>
</div>
@endsection
