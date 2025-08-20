@extends('layouts.app')

@section('title', 'Detalles de Solicitud - Sistema de Visitas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-eye me-2"></i>
                        Detalles de la Solicitud de Visita
                    </h4>
                    <div>
                        <a href="{{ route('visits.my-requests') }}" class="btn btn-light me-2">
                            <i class="fas fa-arrow-left me-2"></i>
                            Volver
                        </a>
                        @if($visit->status === 'pending')
                            <button class="btn btn-danger" onclick="cancelRequest()">
                                <i class="fas fa-times me-2"></i>
                                Cancelar
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Estado de la solicitud -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle fa-2x me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Estado de la Solicitud</h6>
                                        @switch($visit->status)
                                            @case('pending')
                                                <span class="badge bg-warning fs-6">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Pendiente de Revisión
                                                </span>
                                                <p class="mb-0 mt-1">Tu solicitud está siendo revisada por nuestros administradores.</p>
                                                @break
                                            @case('approved')
                                                <span class="badge bg-success fs-6">
                                                    <i class="fas fa-check me-1"></i>
                                                    Aprobada
                                                </span>
                                                <p class="mb-0 mt-1">¡Tu solicitud ha sido aprobada! Prepárate para tu visita.</p>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger fs-6">
                                                    <i class="fas fa-times me-1"></i>
                                                    Rechazada
                                                </span>
                                                <p class="mb-0 mt-1">Tu solicitud no pudo ser aprobada. Revisa los detalles.</p>
                                                @break
                                            @case('completed')
                                                <span class="badge bg-info fs-6">
                                                    <i class="fas fa-calendar-check me-1"></i>
                                                    Completada
                                                </span>
                                                <p class="mb-0 mt-1">La visita se ha completado exitosamente.</p>
                                                @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Información General -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Información General
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Fecha:</strong></div>
                                        <div class="col-8">{{ \Carbon\Carbon::parse($visit->visit_date)->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Hora:</strong></div>
                                        <div class="col-8">{{ $visit->visit_time }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Grupo:</strong></div>
                                        <div class="col-8">{{ $visit->group_size }} personas</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Propósito:</strong></div>
                                        <div class="col-8">{{ $visit->visit_purpose }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Solicitado:</strong></div>
                                        <div class="col-8">{{ \Carbon\Carbon::parse($visit->requested_at)->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-address-card me-2"></i>
                                        Información de Contacto
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Contacto:</strong></div>
                                        <div class="col-8">{{ $visit->contact_person }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Teléfono:</strong></div>
                                        <div class="col-8">{{ $visit->contact_phone }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Email:</strong></div>
                                        <div class="col-8">{{ $visit->contact_email }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Institución:</strong></div>
                                        <div class="col-8">{{ $visit->institution_name }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Tipo:</strong></div>
                                        <div class="col-8">{{ ucfirst($visit->institution_type) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actividades Seleccionadas -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-list-check me-2"></i>
                                        Actividades Seleccionadas
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @if($visit->activities->count() > 0)
                                        <div class="row">
                                            @foreach($visit->activities as $activity)
                                                <div class="col-12 mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                        <div>
                                                            <strong>{{ $activity->name }}</strong>
                                                            <br>
                                                            <small class="text-muted">{{ $activity->description }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">No se seleccionaron actividades específicas.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Información de Transporte -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-car me-2"></i>
                                        Información de Transporte
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Método:</strong></div>
                                        <div class="col-8">{{ ucfirst(str_replace('_', ' ', $visit->transportation_method)) }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Llegada:</strong></div>
                                        <div class="col-8">{{ $visit->arrival_time }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Salida:</strong></div>
                                        <div class="col-8">{{ $visit->departure_time }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Requisitos Especiales -->
                        @if($visit->special_requirements || $visit->dietary_restrictions || $visit->accessibility_needs)
                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">
                                            <i class="fas fa-star me-2"></i>
                                            Requisitos Especiales
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @if($visit->special_requirements)
                                            <div class="mb-3">
                                                <strong>Requisitos Especiales:</strong>
                                                <p class="mb-0">{{ $visit->special_requirements }}</p>
                                            </div>
                                        @endif
                                        @if($visit->dietary_restrictions)
                                            <div class="mb-3">
                                                <strong>Restricciones Alimentarias:</strong>
                                                <p class="mb-0">{{ $visit->dietary_restrictions }}</p>
                                            </div>
                                        @endif
                                        @if($visit->accessibility_needs)
                                            <div class="mb-3">
                                                <strong>Necesidades de Accesibilidad:</strong>
                                                <p class="mb-0">{{ $visit->accessibility_needs }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Contacto de Emergencia -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Contacto de Emergencia
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Nombre:</strong></div>
                                        <div class="col-8">{{ $visit->emergency_contact_name }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Teléfono:</strong></div>
                                        <div class="col-8">{{ $visit->emergency_contact_phone }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Relación:</strong></div>
                                        <div class="col-8">{{ $visit->emergency_contact_relationship }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Historial de la Solicitud -->
                    @if($visit->logs->count() > 0)
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">
                                            <i class="fas fa-history me-2"></i>
                                            Historial de la Solicitud
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="timeline">
                                            @foreach($visit->logs->sortBy('created_at') as $log)
                                                <div class="timeline-item">
                                                    <div class="timeline-marker"></div>
                                                    <div class="timeline-content">
                                                        <h6 class="mb-1">{{ $log->description }}</h6>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #007bff;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #007bff;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 15px;
    width: 2px;
    height: calc(100% + 5px);
    background-color: #e9ecef;
}
</style>
@endsection
