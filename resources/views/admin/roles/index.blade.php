@extends('layouts.app')

@section('title', 'Roles y Permisos - Sistema de Visitas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-cog text-primary me-2"></i>
        Roles y Permisos
    </h1>
         <div class="btn-toolbar mb-2 mb-md-0">
         <!-- Botón de crear rol removido - solo se mantienen los 3 roles del sistema -->
     </div>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $roles->total() }}</h4>
                        <small>Total Roles</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-tag fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $roles->sum('users_count') }}</h4>
                        <small>Usuarios Asignados</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                                                 <h4 class="mb-0">{{ \App\Models\Permission::count() ?? 0 }}</h4>
                        <small>Permisos Disponibles</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-key fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Roles -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Lista de Roles
        </h5>
    </div>
    <div class="card-body">
        @if($roles->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Usuarios</th>
                        <th>Permisos</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>#{{ $role->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    @switch($role->name)
                                        @case('superadmin')
                                            <i class="fas fa-crown fa-lg text-danger"></i>
                                            @break
                                        @case('administrador')
                                            <i class="fas fa-user-shield fa-lg text-warning"></i>
                                            @break
                                        @case('visitante')
                                            <i class="fas fa-user fa-lg text-success"></i>
                                            @break
                                        @default
                                            <i class="fas fa-user-tag fa-lg text-secondary"></i>
                                    @endswitch
                                </div>
                                <div>
                                    <strong>{{ ucfirst($role->name) }}</strong>
                                    @if($role->name === 'superadmin')
                                        <span class="badge bg-danger ms-1">Sistema</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $role->description ?? 'Sin descripción' }}
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $role->users_count }} usuarios</span>
                        </td>
                                                 <td>
                             @php
                                 $permissionsCount = $role->permissions ? $role->permissions->count() : 0;
                             @endphp
                             @if($permissionsCount > 0)
                                 <span class="badge bg-success">{{ $permissionsCount }} permisos</span>
                             @else
                                 <span class="badge bg-secondary">Sin permisos</span>
                             @endif
                         </td>
                                                 <td>{{ $role->created_at ? $role->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.roles.edit', $role) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                                                 @if(!in_array($role->name, ['superadmin', 'administrador', 'visitante']) && $role->users_count === 0)
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        onclick="confirmDelete({{ $role->id }}, '{{ $role->name }}')"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                                <form id="delete-form-{{ $role->id }}" 
                                      action="{{ route('admin.roles.destroy', $role) }}" 
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
            {{ $roles->links() }}
        </div>
        @else
                 <div class="text-center py-5">
             <i class="fas fa-user-tag fa-3x text-muted mb-3"></i>
             <h5 class="text-muted">No hay roles configurados</h5>
             <p class="text-muted">Los roles del sistema deben ser configurados por el administrador.</p>
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
                <p>¿Estás seguro de que quieres eliminar el rol <strong id="roleName"></strong>?</p>
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
function confirmDelete(roleId, roleName) {
    document.getElementById('roleName').textContent = roleName;
    document.getElementById('confirmDelete').onclick = function() {
        document.getElementById('delete-form-' + roleId).submit();
    };
    
    document.getElementById('deleteModal').classList.remove('hidden');
}
</script>
@endpush
