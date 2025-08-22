@extends('layouts.app')

@section('title', 'Crear Usuario - Sistema de Visitas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-plus text-primary me-2"></i>
        Crear Nuevo Usuario
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit me-2"></i>Información del Usuario
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
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
                                       value="{{ old('name') }}" 
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
                                       value="{{ old('email') }}" 
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
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>Contraseña
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
                                    Mínimo 8 caracteres con mayúsculas, minúsculas y números.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-1"></i>Confirmar Contraseña
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role_id" class="form-label">
                                    <i class="fas fa-user-tag me-1"></i>Rol
                                </label>
                                <select class="form-select @error('role_id') is-invalid @enderror" 
                                        id="role_id" 
                                        name="role_id" 
                                        required>
                                    <option value="">Seleccionar rol...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            @switch($role->name)
                                                @case('superadmin')
                                                    👑 Super Administrador
                                                    @break
                                                @case('administrador')
                                                    🛡️ Administrador
                                                    @break
                                                @case('visitante')
                                                    👤 Visitante
                                                    @break
                                                @default
                                                    {{ ucfirst($role->name) }}
                                            @endswitch
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact_phone" class="form-label">
                                    <i class="fas fa-phone me-1"></i>Teléfono
                                </label>
                                <input type="text" 
                                       class="form-control @error('contact_phone') is-invalid @enderror" 
                                       id="contact_phone" 
                                       name="contact_phone" 
                                       value="{{ old('contact_phone') }}">
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="institution_name" class="form-label">
                            <i class="fas fa-building me-1"></i>Institución
                        </label>
                        <input type="text" 
                               class="form-control @error('institution_name') is-invalid @enderror" 
                               id="institution_name" 
                               name="institution_name" 
                               value="{{ old('institution_name') }}">
                        @error('institution_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Campo opcional. Solo aplica para visitantes.
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Crear Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Información
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb me-1"></i>Consejos:</h6>
                    <ul class="mb-0">
                        <li>Asigna el rol apropiado según las responsabilidades del usuario.</li>
                        <li>La contraseña debe ser segura y única.</li>
                        <li>El email debe ser válido y único en el sistema.</li>
                        <li>Los campos de institución y teléfono son opcionales.</li>
                    </ul>
                </div>
                
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-1"></i>Roles del Sistema:</h6>
                    <ul class="mb-0">
                        <li><strong>Super Admin:</strong> Control total del sistema</li>
                        <li><strong>Administrador:</strong> Gestión de visitas y reportes</li>
                        <li><strong>Visitante:</strong> Solicitar y gestionar visitas</li>
                    </ul>
                </div>
                
                <div class="alert alert-info">
                    <h6><i class="fas fa-shield-alt me-1"></i>Restricción de Seguridad:</h6>
                    <p class="mb-0">
                        <i class="fas fa-lock me-1"></i>
                        <strong>El rol de Super Administrador no se puede asignar desde esta interfaz</strong> por motivos de seguridad. 
                        Solo los Super Administradores existentes pueden otorgar este privilegio directamente en la base de datos.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
