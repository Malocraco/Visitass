@extends('layouts.app')

@section('title', 'Mi Cuenta - Sistema de Visitas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-cog text-primary me-2"></i>
        Mi Cuenta
    </h1>
</div>



<!-- Pestañas de Configuración -->
<ul class="nav nav-tabs" id="settingsTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
            <i class="fas fa-user me-2"></i>Perfil
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
            <i class="fas fa-key me-2"></i>Contraseña
        </button>
    </li>

</ul>

<div class="tab-content" id="settingsTabsContent">
    <!-- Pestaña Perfil -->
    <div class="tab-pane fade show active" id="profile" role="tabpanel">
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>Información del Perfil
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.profile') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1"></i>Nombre Completo
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>Correo Electrónico
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-1"></i>Teléfono
                                </label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="institution_name" class="form-label">
                                    <i class="fas fa-building me-1"></i>Institución
                                </label>
                                <input type="text" 
                                       class="form-control @error('institution_name') is-invalid @enderror" 
                                       id="institution_name" 
                                       name="institution_name" 
                                       value="{{ old('institution_name', $user->institution_name) }}">
                                @error('institution_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Actualizar Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Pestaña Contraseña -->
    <div class="tab-pane fade" id="password" role="tabpanel">
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-key me-2"></i>Cambiar Contraseña
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">
                            <i class="fas fa-lock me-1"></i>Contraseña Actual
                        </label>
                        <input type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" 
                               name="current_password" 
                               required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-key me-1"></i>Nueva Contraseña
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Mínimo 8 caracteres
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-key me-1"></i>Confirmar Nueva Contraseña
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Recomendaciones de seguridad:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Usa al menos 8 caracteres</li>
                            <li>Combina letras mayúsculas y minúsculas</li>
                            <li>Incluye números y símbolos</li>
                            <li>Evita información personal</li>
                        </ul>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-1"></i>Cambiar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

</div>

<!-- Información de la Cuenta -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Información de la Cuenta
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <strong>Rol:</strong><br>
                        @if($user->getPrimaryRole())
                            @switch($user->getPrimaryRole()->name)
                                @case('superadmin')
                                    <span class="badge bg-danger">👑 Super Administrador</span>
                                    @break
                                @case('administrador')
                                    <span class="badge bg-warning text-dark">🛡️ Administrador</span>
                                    @break
                                @case('visitante')
                                    <span class="badge bg-primary">👤 Visitante</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ ucfirst($user->getPrimaryRole()->name) }}</span>
                            @endswitch
                        @else
                            <span class="badge bg-secondary">Sin rol asignado</span>
                        @endif
                    </div>
                    <div class="col-6">
                        <strong>Estado:</strong><br>
                        <span class="badge bg-success">Activo</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <strong>Miembro desde:</strong><br>
                        <span class="text-muted">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="col-6">
                        <strong>Último acceso:</strong><br>
                        <span class="text-muted">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-shield-alt me-2"></i>Seguridad de la Cuenta
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Cuenta verificada</strong>
                        <br>
                        <small>Tu cuenta está completamente verificada y segura</small>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-clock me-2"></i>
                        <strong>Sesión activa</strong>
                        <br>
                        <small>Tu sesión está activa y segura</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Activar la primera pestaña por defecto
document.addEventListener('DOMContentLoaded', function() {
    var firstTab = document.querySelector('#settingsTabs .nav-link');
    var firstTabContent = document.querySelector('#settingsTabsContent .tab-pane');
    
    if (firstTab && firstTabContent) {
        firstTab.classList.add('active');
        firstTabContent.classList.add('show', 'active');
    }
});
</script>
@endpush
