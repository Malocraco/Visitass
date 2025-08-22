@extends('layouts.app')

@section('title', 'Mis Solicitudes de Visita - Sistema de Visitas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Mis Solicitudes de Visita
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($visits->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fecha de Visita</th>
                                        <th>Institución</th>
                                        <th>Estado</th>
                                        <th>Solicitado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($visits as $visit)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ \Carbon\Carbon::parse($visit->preferred_date)->format('d/m/Y') }}</div>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($visit->preferred_start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($visit->preferred_end_time)->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $visit->institution_name }}</div>
                                                <small class="text-muted">{{ ucfirst($visit->institution_type) }}</small>
                                            </td>
                                            <td>
                                                @switch($visit->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-clock me-1"></i>
                                                            Pendiente
                                                        </span>
                                                        @break
                                                    @case('approved')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>
                                                            Aprobada
                                                        </span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times me-1"></i>
                                                            Rechazada
                                                        </span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-calendar-check me-1"></i>
                                                            Completada
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ ucfirst($visit->status) }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($visit->created_at)->format('d/m/Y H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <a href="{{ route('visits.show', $visit->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
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
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No tienes solicitudes de visita</h5>
                            <p class="text-muted">Comienza creando tu primera solicitud de visita a la institución.</p>
                            <a href="{{ route('visits.request') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Crear Primera Solicitud
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
