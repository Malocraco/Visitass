@extends('layouts.app')

@section('title', 'Gestión de Usuarios - Sistema de Visitas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users text-primary me-2"></i>
        Gestión de Usuarios
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Nuevo Usuario
        </a>
    </div>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $users->total() }}</h4>
                        <small>Total Usuarios</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                                                 <h4 class="mb-0">{{ $users->filter(function($user) { return $user->roles->where('name', 'visitante')->count() > 0; })->count() }}</h4>
                        <small>Visitantes</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                                                 <h4 class="mb-0">{{ $users->filter(function($user) { return $user->roles->where('name', 'administrador')->count() > 0; })->count() }}</h4>
                        <small>Administradores</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-shield fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                                                 <h4 class="mb-0">{{ $users->filter(function($user) { return $user->roles->where('name', 'superadmin')->count() > 0; })->count() }}</h4>
                        <small>Super Admins</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-crown fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Buscar</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Nombre, email, institución...">
            </div>
            <div class="col-md-3">
                <label for="role" class="form-label">Rol</label>
                <select class="form-select" id="role" name="role">
                    <option value="">Todos los roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="institution_type" class="form-label">Tipo de Institución</label>
                <select class="form-select" id="institution_type" name="institution_type">
                    <option value="">Todos los tipos</option>
                    <option value="empresa" {{ request('institution_type') == 'empresa' ? 'selected' : '' }}>Empresa</option>
                    <option value="universidad" {{ request('institution_type') == 'universidad' ? 'selected' : '' }}>Universidad</option>
                    <option value="colegio" {{ request('institution_type') == 'colegio' ? 'selected' : '' }}>Colegio</option>
                    <option value="otro" {{ request('institution_type') == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="sort_by" class="form-label">Ordenar por</label>
                <select class="form-select" id="sort_by" name="sort_by">
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Fecha de registro</option>
                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nombre</option>
                    <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                    <option value="institution_name" {{ request('sort_by') == 'institution_name' ? 'selected' : '' }}>Institución</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="sort_order" class="form-label">Orden</label>
                <select class="form-select" id="sort_order" name="sort_order">
                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descendente</option>
                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>Filtrar
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Limpiar
                </a>
                @if(request()->hasAny(['search', 'role', 'institution_type', 'sort_by', 'sort_order']))
                    <span class="badge bg-info ms-2">
                        <i class="fas fa-filter me-1"></i>Filtros activos
                    </span>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Tabla de Usuarios -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Lista de Usuarios
        </h5>
    </div>
    <div class="card-body">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Institución</th>
                        <th>Teléfono</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->id === auth()->id())
                                        <span class="badge bg-info ms-1">Tú</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                                                 <td>
                             @if($user->getPrimaryRole())
                                 @switch($user->getPrimaryRole()->name)
                                     @case('superadmin')
                                         <span class="badge bg-danger">
                                             <i class="fas fa-crown me-1"></i>Super Admin
                                         </span>
                                         @break
                                     @case('administrador')
                                         <span class="badge bg-warning text-dark">
                                             <i class="fas fa-user-shield me-1"></i>Administrador
                                         </span>
                                         @break
                                     @case('visitante')
                                         <span class="badge bg-success">
                                             <i class="fas fa-user me-1"></i>Visitante
                                         </span>
                                         @break
                                     @default
                                         <span class="badge bg-secondary">{{ $user->getPrimaryRole()->name }}</span>
                                 @endswitch
                             @else
                                 <span class="badge bg-secondary">Sin rol</span>
                             @endif
                         </td>
                        <td>{{ $user->institution_name ?? 'N/A' }}</td>
                                                 <td>{{ $user->phone ?? 'N/A' }}</td>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if($user->id !== auth()->id())
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                                <form id="delete-form-{{ $user->id }}" 
                                      action="{{ route('admin.users.destroy', $user) }}" 
                                      method="POST" 
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-users fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No hay usuarios registrados</h5>
            <p class="text-muted">Comienza creando el primer usuario del sistema.</p>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Crear Usuario
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres eliminar al usuario <strong id="userName"></strong>?</p>
                <p class="text-danger">
                    <i class="fas fa-info-circle me-1"></i>
                    Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fas fa-trash me-1"></i>Eliminar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-submit del formulario cuando cambien los filtros
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('select');
    
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            form.submit();
        });
    });
});

function confirmDelete(userId, userName) {
    document.getElementById('userName').textContent = userName;
    document.getElementById('confirmDelete').onclick = function() {
        document.getElementById('delete-form-' + userId).submit();
    };
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
