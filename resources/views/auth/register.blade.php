@extends('layouts.auth')

@section('title', 'Registro - Sistema de Visitas')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h4>
            <i class="fas fa-user-plus me-2"></i>
            Registro de Visitante
        </h4>
    </div>
    
    <div class="auth-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <!-- Información Personal -->
                        <h5 class="mb-3 text-primary">
                            <i class="fas fa-user me-2"></i>
                            Información Personal
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1"></i>
                                    Nombre Completo *
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>
                                    Correo Electrónico *
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Teléfono *
                                </label>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}" 
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="institution_type" class="form-label">
                                    <i class="fas fa-building me-1"></i>
                                    Tipo de Institución *
                                </label>
                                <select class="form-select @error('institution_type') is-invalid @enderror" 
                                        id="institution_type" 
                                        name="institution_type" 
                                        required>
                                    <option value="">Seleccione...</option>
                                    <option value="empresa" {{ old('institution_type') == 'empresa' ? 'selected' : '' }}>
                                        Empresa
                                    </option>
                                    <option value="universidad" {{ old('institution_type') == 'universidad' ? 'selected' : '' }}>
                                        Universidad
                                    </option>
                                    <option value="colegio" {{ old('institution_type') == 'colegio' ? 'selected' : '' }}>
                                        Colegio
                                    </option>
                                    <option value="otro" {{ old('institution_type') == 'otro' ? 'selected' : '' }}>
                                        Otro
                                    </option>
                                </select>
                                @error('institution_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="institution_name" class="form-label">
                                <i class="fas fa-university me-1"></i>
                                Nombre de la Institución *
                            </label>
                            <input type="text" 
                                   class="form-control @error('institution_name') is-invalid @enderror" 
                                   id="institution_name" 
                                   name="institution_name" 
                                   value="{{ old('institution_name') }}" 
                                   required>
                            @error('institution_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Información de Seguridad -->
                        <h5 class="mb-3 text-primary mt-4">
                            <i class="fas fa-shield-alt me-2"></i>
                            Información de Seguridad
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>
                                    Contraseña *
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
                                <small class="form-text text-muted">
                                    Mínimo 8 caracteres
                                </small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-1"></i>
                                    Confirmar Contraseña *
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="terms" 
                                   name="terms" 
                                   required>
                            <label class="form-check-label" for="terms">
                                Acepto los <a href="#" class="text-decoration-none">términos y condiciones</a> *
                            </label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>
                                Crear Cuenta
                            </button>
                        </div>
                    </form>
                </div>
    
    <div class="auth-footer">
        <p class="mb-0">
            ¿Ya tienes una cuenta? 
            <a href="{{ route('login') }}">
                Inicia sesión aquí
            </a>
        </p>
    </div>
</div>

<!-- Información adicional -->
<div class="text-center mt-4">
    <div class="alert alert-info">
        <h6 class="alert-heading">
            <i class="fas fa-info-circle me-2"></i>
            ¿Por qué registrarse?
        </h6>
        <ul class="mb-0 text-start">
            <li>Solicita visitas a la institución de forma fácil y rápida</li>
            <li>Recibe notificaciones sobre el estado de tus solicitudes</li>
            <li>Accede al historial completo de tus visitas</li>
            <li>Comunícate directamente con los administradores</li>
        </ul>
    </div>
</div>
@endsection
