@extends('layouts.app')

@section('title', 'Editar Rol - Sistema de Visitas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-tag text-primary me-2"></i>
        Editar Rol
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-tag me-2"></i>Información del Rol
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-tag me-1"></i>Nombre del Rol
                                </label>
                                                                 <input type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name', $role->name) }}" 
                                        {{ in_array($role->name, ['superadmin', 'administrador', 'visitante']) ? 'readonly' : '' }}
                                        required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                                                 <div class="form-text">
                                     <i class="fas fa-info-circle me-1"></i>
                                     @if(in_array($role->name, ['superadmin', 'administrador', 'visitante']))
                                         Nombre del rol del sistema (no editable).
                                     @else
                                         Nombre único para identificar el rol.
                                     @endif
                                 </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    <i class="fas fa-align-left me-1"></i>Descripción
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="3">{{ old('description', $role->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Descripción opcional del rol y sus responsabilidades.
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-key me-1"></i>Permisos Asignados
                        </label>
                        <div class="row">
                            @foreach($permissions as $permission)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="permissions[]" 
                                           value="{{ $permission->id }}" 
                                           id="permission_{{ $permission->id }}"
                                           {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        <strong>{{ ucfirst($permission->name) }}</strong>
                                        @if($permission->description)
                                            <br><small class="text-muted">{{ $permission->description }}</small>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @error('permissions')
                            <div class="text-danger mt-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Selecciona los permisos que tendrán los usuarios con este rol.
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Actualizar Rol
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
                    <i class="fas fa-info-circle me-2"></i>Información del Rol
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>ID:</strong> #{{ $role->id }}
                </div>
                <div class="mb-3">
                    <strong>Fecha de Creación:</strong><br>
                                         {{ $role->created_at ? $role->created_at->format('d/m/Y H:i') : 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Última Actualización:</strong><br>
                                         {{ $role->updated_at ? $role->updated_at->format('d/m/Y H:i') : 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Usuarios Asignados:</strong><br>
                    <span class="badge bg-primary">{{ $role->users()->count() }} usuarios</span>
                </div>
                <div class="mb-3">
                    <strong>Permisos Actuales:</strong><br>
                    <span class="badge bg-success">{{ $role->permissions()->count() }} permisos</span>
                </div>
                
                                 @if(in_array($role->name, ['superadmin', 'administrador', 'visitante']))
                 <div class="alert alert-warning">
                     <i class="fas fa-exclamation-triangle me-1"></i>
                     <strong>Nota:</strong> Este es un rol del sistema. Los cambios se aplicarán a todos los usuarios con este rol.
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
                        <li>Los cambios en permisos se aplicarán inmediatamente.</li>
                        <li>Verifica que los permisos asignados sean apropiados.</li>
                        <li>Los usuarios con este rol tendrán acceso a las funciones seleccionadas.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
