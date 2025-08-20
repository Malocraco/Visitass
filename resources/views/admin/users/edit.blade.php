@extends('layouts.app')

@section('title', 'Editar Usuario - Sistema de Visitas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-edit text-primary me-2"></i>
        Editar Usuario
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
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
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
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>Nueva Contraseña
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Deja en blanco para mantener la contraseña actual.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-1"></i>Confirmar Nueva Contraseña
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation">
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
                                        <option value="{{ $role->id }}" 
                                                {{ old('role_id', $user->getPrimaryRole()->id ?? '') == $role->id ? 'selected' : '' }}>
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
                                        value="{{ old('contact_phone', $user->phone) }}">
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
                               value="{{ old('institution_name', $user->institution_name) }}">
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
                            <i class="fas fa-save me-1"></i>Actualizar Usuario
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
                    <i class="fas fa-info-circle me-2"></i>Información del Usuario
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>ID:</strong> #{{ $user->id }}
                </div>
                <div class="mb-3">
                    <strong>Fecha de Registro:</strong><br>
                    {{ $user->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="mb-3">
                    <strong>Última Actualización:</strong><br>
                    {{ $user->updated_at->format('d/m/Y H:i') }}
                </div>
                
                @if($user->id === auth()->id())
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    <strong>Nota:</strong> Estás editando tu propia cuenta.
                </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-shield-alt me-2"></i>Seguridad
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb me-1"></i>Consejos:</h6>
                    <ul class="mb-0">
                        <li>Solo cambia la contraseña si es necesario.</li>
                        <li>Verifica que el rol asignado sea el correcto.</li>
                        <li>Los cambios se aplicarán inmediatamente.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
