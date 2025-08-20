@extends('layouts.app')

@section('title', 'Todas las Visitas - Sistema de Visitas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tasks text-primary me-2"></i>
        Todas las Visitas
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                <i class="fas fa-print me-1"></i>Imprimir
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download me-1"></i>Exportar
            </button>
        </div>
    </div>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['total'] }}</h4>
                        <p class="mb-0">Total Visitas</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['pending'] }}</h4>
                        <p class="mb-0">Pendientes</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
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
                        <h4 class="mb-0">{{ $stats['approved'] }}</h4>
                        <p class="mb-0">Aprobadas</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['completed'] }}</h4>
                        <p class="mb-0">Completadas</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-flag-checkered fa-2x"></i>
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
            <i class="fas fa-filter me-2"></i>Filtros
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.visits.all') }}" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label">Estado</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Todos los estados</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprobada</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completada</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rechazada</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date_from" class="form-label">Fecha Desde</label>
                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label for="date_to" class="form-label">Fecha Hasta</label>
                <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label">Buscar</label>
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nombre, email, institución...">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>Filtrar
                </button>
                <a href="{{ route('admin.visits.all') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Limpiar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tabla de Visitas -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Lista de Visitas
        </h5>
    </div>
    <div class="card-body">
        @if($visits->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Visitante</th>
                            <th>Institución</th>
                            <th>Fecha Visita</th>
                            <th>Estado</th>
                            <th>Actividades</th>
                            <th>Solicitado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visits as $visit)
                        <tr>
                            <td>
                                <strong>#{{ $visit->id }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $visit->user->name }}</strong><br>
                                    <small class="text-muted">{{ $visit->user->email }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $visit->user->institution_name }}</strong><br>
                                    <small class="text-muted">{{ ucfirst($visit->user->institution_type) }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <i class="fas fa-calendar me-1"></i>{{ $visit->visit_date->format('d/m/Y') }}<br>
                                    <small class="text-muted">{{ $visit->visit_time }}</small>
                                </div>
                            </td>
                            <td>
                                @switch($visit->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock me-1"></i>Pendiente
                                        </span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Aprobada
                                        </span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-info">
                                            <i class="fas fa-flag-checkered me-1"></i>Completada
                                        </span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times me-1"></i>Rechazada
                                        </span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @foreach($visit->activities->take(2) as $activity)
                                    <span class="badge bg-secondary me-1">{{ $activity->name }}</span>
                                @endforeach
                                @if($visit->activities->count() > 2)
                                    <span class="badge bg-secondary">+{{ $visit->activities->count() - 2 }}</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $visit->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.visits.details', $visit->id) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($visit->status == 'pending')
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-success" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#approveModal{{ $visit->id }}"
                                                title="Aprobar">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal{{ $visit->id }}"
                                                title="Rechazar">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                    
                                    @if($visit->status == 'approved')
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#completeModal{{ $visit->id }}"
                                                title="Marcar como completada">
                                            <i class="fas fa-flag-checkered"></i>
                                        </button>
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
                {{ $visits->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">No hay visitas</h3>
                <p class="text-muted">No se encontraron visitas con los filtros aplicados.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modales para acciones -->
@foreach($visits as $visit)
    @if($visit->status == 'pending')
        <!-- Modal Aprobar -->
        <div class="modal fade" id="approveModal{{ $visit->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-check me-2"></i>Aprobar Visita #{{ $visit->id }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.visits.approve', $visit->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p><strong>¿Estás seguro de que deseas aprobar esta visita?</strong></p>
                            <p><strong>Visitante:</strong> {{ $visit->user->name }}</p>
                            <p><strong>Fecha:</strong> {{ $visit->visit_date->format('d/m/Y') }}</p>
                            
                            <div class="mb-3">
                                <label for="admin_notes" class="form-label">Notas del Administrador (opcional):</label>
                                <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i>Aprobar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Modal Rechazar -->
        <div class="modal fade" id="rejectModal{{ $visit->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-times me-2"></i>Rechazar Visita #{{ $visit->id }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.visits.reject', $visit->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p><strong>¿Estás seguro de que deseas rechazar esta visita?</strong></p>
                            <p><strong>Visitante:</strong> {{ $visit->user->name }}</p>
                            <p><strong>Fecha:</strong> {{ $visit->visit_date->format('d/m/Y') }}</p>
                            
                            <div class="mb-3">
                                <label for="rejection_reason" class="form-label">Motivo del Rechazo: <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="admin_notes" class="form-label">Notas del Administrador (opcional):</label>
                                <textarea class="form-control" id="admin_notes" name="admin_notes" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times me-1"></i>Rechazar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    
    @if($visit->status == 'approved')
        <!-- Modal Completar -->
        <div class="modal fade" id="completeModal{{ $visit->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-flag-checkered me-2"></i>Completar Visita #{{ $visit->id }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.visits.complete', $visit->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p><strong>¿Estás seguro de que deseas marcar esta visita como completada?</strong></p>
                            <p><strong>Visitante:</strong> {{ $visit->user->name }}</p>
                            <p><strong>Fecha:</strong> {{ $visit->visit_date->format('d/m/Y') }}</p>
                            
                            <div class="mb-3">
                                <label for="completion_notes" class="form-label">Notas de Completado (opcional):</label>
                                <textarea class="form-control" id="completion_notes" name="completion_notes" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-flag-checkered me-1"></i>Completar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection

