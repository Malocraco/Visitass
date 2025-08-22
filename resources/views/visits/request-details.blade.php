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
                    <div class="ms-auto">
                        <a href="{{ route('visits.my-requests') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>
                            Volver
                        </a>
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
                                        <div class="col-8">{{ \Carbon\Carbon::parse($visit->preferred_date)->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Hora:</strong></div>
                                        <div class="col-8">{{ \Carbon\Carbon::parse($visit->preferred_start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($visit->preferred_end_time)->format('H:i') }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Propósito:</strong></div>
                                        <div class="col-8">{{ $visit->visit_purpose }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Solicitado:</strong></div>
                                        <div class="col-8">{{ \Carbon\Carbon::parse($visit->created_at)->format('d/m/Y H:i') }}</div>
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

                        <!-- Servicios Adicionales -->
                        @if($visit->restaurant_service)
                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">
                                            <i class="fas fa-utensils me-2"></i>
                                            Servicios Adicionales
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-4"><strong>Restaurante:</strong></div>
                                            <div class="col-8">
                                                <span class="badge bg-success">Solicitado</span>
                                            </div>
                                        </div>
                                        @if($visit->restaurant_participants)
                                            <div class="row mb-2">
                                                <div class="col-4"><strong>Personas:</strong></div>
                                                <div class="col-8">{{ $visit->restaurant_participants }} personas</div>
                                            </div>
                                        @endif
                                        @if($visit->restaurant_notes)
                                            <div class="row mb-2">
                                                <div class="col-4"><strong>Notas:</strong></div>
                                                <div class="col-8">{{ $visit->restaurant_notes }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Requisitos y Actividades -->
                        @if($visit->special_requirements || $visit->other_activities)
                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">
                                            <i class="fas fa-star me-2"></i>
                                            Requisitos y Actividades
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @if($visit->special_requirements)
                                            <div class="mb-3">
                                                <strong>Requisitos Obligatorios:</strong>
                                                <div class="mt-2">
                                                    @php
                                                        // Dividir los requisitos por actividad
                                                        $requirements = explode('📋', $visit->special_requirements);
                                                        array_shift($requirements); // Remover el primer elemento vacío
                                                    @endphp
                                                    
                                                    @foreach($requirements as $requirement)
                                                        @php
                                                            $lines = explode("\n", trim($requirement));
                                                            $activityName = trim($lines[0], ':');
                                                            $activityRequirements = array_slice($lines, 1);
                                                        @endphp
                                                        
                                                        <div class="requirement-card mb-3">
                                                            <div class="requirement-header">
                                                                <i class="fas fa-clipboard-list me-2"></i>
                                                                {{ $activityName }}
                                                            </div>
                                                            <div class="requirement-body">
                                                                <ul class="mb-0">
                                                                    @foreach($activityRequirements as $req)
                                                                        @if(trim($req) !== '')
                                                                            <li>{{ trim($req, '• ') }}</li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if($visit->other_activities)
                                            <div class="mb-3">
                                                <strong>Otras Actividades:</strong>
                                                <p class="mb-0 mt-2">{{ $visit->other_activities }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para los cuadros de requisitos obligatorios */
.requirement-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 15px;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.requirement-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.requirement-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 12px 20px;
    border-radius: 8px 8px 0 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.requirement-header i {
    font-size: 18px;
}

.requirement-body {
    padding: 20px;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    line-height: 1.6;
    color: #495057;
}

.requirement-body ul {
    margin: 0;
    padding-left: 20px;
}

.requirement-body li {
    margin-bottom: 8px;
    position: relative;
}

.requirement-body li:before {
    content: "•";
    color: #007bff;
    font-weight: bold;
    position: absolute;
    left: -15px;
}

/* Animación de entrada para los cuadros */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.requirement-card {
    animation: slideInUp 0.3s ease-out;
}

/* Responsive para los cuadros */
@media (max-width: 768px) {
    .requirement-header {
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .requirement-body {
        padding: 15px;
        font-size: 13px;
    }
}
</style>
@endsection
