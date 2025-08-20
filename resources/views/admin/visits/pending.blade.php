@extends('layouts.app')

@section('title', 'Solicitudes Pendientes - Sistema de Visitas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-clock text-warning me-2"></i>
        Solicitudes Pendientes
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

@if($pendingVisits->count() > 0)
    <div class="row">
        @foreach($pendingVisits as $visit)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-warning">
                <div class="card-header bg-warning text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="fas fa-clock me-1"></i>
                            Solicitud #{{ $visit->id }}
                        </h6>
                        <span class="badge bg-warning text-dark">Pendiente</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Visitante:</strong><br>
                        <i class="fas fa-user me-1"></i>{{ $visit->user->name }}<br>
                        <i class="fas fa-envelope me-1"></i>{{ $visit->user->email }}<br>
                        <i class="fas fa-phone me-1"></i>{{ $visit->user->phone }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Institución:</strong><br>
                        <i class="fas fa-building me-1"></i>{{ $visit->user->institution_name }}<br>
                        <small class="text-muted">{{ ucfirst($visit->user->institution_type) }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Propósito:</strong><br>
                        <p class="mb-1">{{ Str::limit($visit->purpose, 100) }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Fecha de Visita:</strong><br>
                        <i class="fas fa-calendar me-1"></i>{{ $visit->visit_date->format('d/m/Y') }}<br>
                        <i class="fas fa-clock me-1"></i>{{ $visit->visit_time }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Actividades:</strong><br>
                        @foreach($visit->activities as $activity)
                            <span class="badge bg-info me-1">{{ $activity->name }}</span>
                        @endforeach
                    </div>
                    
                    <div class="mb-3">
                        <strong>Solicitado:</strong><br>
                        <small class="text-muted">{{ $visit->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group w-100" role="group">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal{{ $visit->id }}">
                            <i class="fas fa-check me-1"></i>Aprobar
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $visit->id }}">
                            <i class="fas fa-times me-1"></i>Rechazar
                        </button>
                        <a href="{{ route('admin.visits.details', $visit->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye me-1"></i>Ver
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal Aprobar -->
        <div class="modal fade" id="approveModal{{ $visit->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-check me-2"></i>Aprobar Visita
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
                                <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" placeholder="Agregar notas adicionales..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i>Aprobar Visita
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
                            <i class="fas fa-times me-2"></i>Rechazar Visita
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
                                <textarea class="form-control @error('rejection_reason') is-invalid @enderror" 
                                          id="rejection_reason" 
                                          name="rejection_reason" 
                                          rows="3" 
                                          required 
                                          placeholder="Especificar el motivo del rechazo..."></textarea>
                                @error('rejection_reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="admin_notes" class="form-label">Notas del Administrador (opcional):</label>
                                <textarea class="form-control" id="admin_notes" name="admin_notes" rows="2" placeholder="Agregar notas adicionales..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times me-1"></i>Rechazar Visita
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $pendingVisits->links() }}
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
        <h3 class="text-success">¡Excelente!</h3>
        <p class="lead text-muted">No hay solicitudes pendientes en este momento.</p>
        <p class="text-muted">Todas las solicitudes han sido procesadas.</p>
    </div>
@endif
@endsection

