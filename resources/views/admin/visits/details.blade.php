@extends('layouts.app')

@section('title', 'Detalles de Visita #' . $visit->id . ' - Sistema de Visitas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-eye text-primary me-2"></i>
        Detalles de Visita #{{ $visit->id }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.visits.all') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Volver
            </a>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                <i class="fas fa-print me-1"></i>Imprimir
            </button>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información Principal -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Información de la Visita
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Detalles de la Visita</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td>#{{ $visit->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Estado:</strong></td>
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
                            </tr>
                            <tr>
                                <td><strong>Fecha de Visita:</strong></td>
                                <td>{{ $visit->preferred_date->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Hora:</strong></td>
                                <td>{{ $visit->preferred_start_time->format('H:i') }} - {{ $visit->preferred_end_time->format('H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Duración:</strong></td>
                                <td>{{ $visit->duration }} horas</td>
                            </tr>
                            <tr>
                                <td><strong>Número de Personas:</strong></td>
                                <td>{{ $visit->number_of_people }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Propósito y Descripción</h6>
                        <p><strong>Propósito:</strong></p>
                        <p class="text-muted">{{ $visit->purpose }}</p>
                        
                        @if($visit->description)
                            <p><strong>Descripción Adicional:</strong></p>
                            <p class="text-muted">{{ $visit->description }}</p>
                        @endif
                        
                        @if($visit->special_requirements)
                            <p><strong>Requerimientos Especiales:</strong></p>
                            <p class="text-muted">{{ $visit->special_requirements }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Actividades -->
        @if($visit->activities->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>Actividades Solicitadas
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($visit->activities as $activity)
                    <div class="col-md-6 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="fas fa-check-circle me-1"></i>{{ $activity->name }}
                                </h6>
                                <p class="card-text text-muted">{{ $activity->description }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>Duración: {{ $activity->duration }} minutos
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Horarios -->
        @if($visit->schedules->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Horarios Programados
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Actividad</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                                <th>Responsable</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visit->schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->activity_name }}</td>
                                <td>{{ $schedule->start_time }}</td>
                                <td>{{ $schedule->end_time }}</td>
                                <td>{{ $schedule->responsible_person }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Asistentes -->
        @if($visit->attendees->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>Asistentes
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visit->attendees as $attendee)
                            <tr>
                                <td>{{ $attendee->name }}</td>
                                <td>{{ $attendee->email }}</td>
                                <td>{{ $attendee->phone }}</td>
                                <td>{{ $attendee->role }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar con Información del Visitante y Acciones -->
    <div class="col-md-4">
        <!-- Información del Visitante -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>Información del Visitante
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fas fa-user-circle fa-4x text-primary"></i>
                </div>
                <h6 class="text-center">{{ $visit->user->name }}</h6>
                <p class="text-center text-muted">{{ $visit->user->email }}</p>
                
                <hr>
                
                <div class="mb-3">
                    <strong><i class="fas fa-phone me-1"></i>Teléfono:</strong><br>
                    <span class="text-muted">{{ $visit->user->phone }}</span>
                </div>
                
                <div class="mb-3">
                    <strong><i class="fas fa-building me-1"></i>Institución:</strong><br>
                    <span class="text-muted">{{ $visit->user->institution_name }}</span><br>
                    <small class="text-muted">{{ ucfirst($visit->user->institution_type) }}</small>
                </div>
                
                <div class="mb-3">
                    <strong><i class="fas fa-calendar me-1"></i>Registrado:</strong><br>
                    <span class="text-muted">{{ $visit->user->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Historial de Estados -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>Historial de Estados
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Solicitud Creada</h6>
                            <p class="timeline-text">{{ $visit->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($visit->approved_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Visita Aprobada</h6>
                            <p class="timeline-text">{{ $visit->approved_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($visit->rejected_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-danger"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Visita Rechazada</h6>
                            <p class="timeline-text">{{ $visit->rejected_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($visit->completed_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Visita Completada</h6>
                            <p class="timeline-text">{{ $visit->completed_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Notas del Administrador -->
        @if($visit->admin_notes || $visit->rejection_reason || $visit->completion_notes)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-sticky-note me-2"></i>Notas del Administrador
                </h5>
            </div>
            <div class="card-body">
                @if($visit->admin_notes)
                    <div class="mb-3">
                        <strong>Notas Generales:</strong>
                        <p class="text-muted">{{ $visit->admin_notes }}</p>
                    </div>
                @endif
                
                @if($visit->rejection_reason)
                    <div class="mb-3">
                        <strong>Motivo del Rechazo:</strong>
                        <p class="text-danger">{{ $visit->rejection_reason }}</p>
                    </div>
                @endif
                
                @if($visit->completion_notes)
                    <div class="mb-3">
                        <strong>Notas de Completado:</strong>
                        <p class="text-muted">{{ $visit->completion_notes }}</p>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Acciones -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>Acciones
                </h5>
            </div>
            <div class="card-body">
                @if($visit->status == 'pending')
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                            <i class="fas fa-check me-1"></i>Aprobar Visita
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times me-1"></i>Rechazar Visita
                        </button>
                    </div>
                @elseif($visit->status == 'approved')
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#completeModal">
                            <i class="fas fa-flag-checkered me-1"></i>Marcar como Completada
                        </button>
                    </div>
                @else
                    <div class="text-center">
                        <p class="text-muted">No hay acciones disponibles para este estado.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modales para acciones -->
@if($visit->status == 'pending')
    <!-- Modal Aprobar -->
    <div class="modal fade" id="approveModal" tabindex="-1">
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
                        <p><strong>Fecha:</strong> {{ $visit->preferred_date->format('d/m/Y') }}</p>
                        
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
    <div class="modal fade" id="rejectModal" tabindex="-1">
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
                        <p><strong>Fecha:</strong> {{ $visit->preferred_date->format('d/m/Y') }}</p>
                        
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
    <div class="modal fade" id="completeModal" tabindex="-1">
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
                        <p><strong>Fecha:</strong> {{ $visit->preferred_date->format('d/m/Y') }}</p>
                        
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

@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    padding-left: 10px;
}

.timeline-title {
    margin: 0;
    font-size: 0.9rem;
    font-weight: 600;
}

.timeline-text {
    margin: 0;
    font-size: 0.8rem;
    color: #6c757d;
}
</style>
@endpush

