@extends('layouts.app')

@section('title', 'Visitas Aprobadas - Administrador')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-check-circle text-success me-2"></i>
        Visitas Aprobadas
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.visits.calendar') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-calendar me-1"></i>Ver Calendario
            </a>
            <a href="{{ route('admin.visits.reports') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-chart-bar me-1"></i>Reportes
            </a>
        </div>
    </div>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['total_approved'] }}</h3>
                <p>Total Aprobadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['today_visits'] }}</h3>
                <p>Visitas Hoy</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-day"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['this_week_visits'] }}</h3>
                <p>Esta Semana</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-week"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $stats['completed_visits'] }}</h3>
                <p>Completadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-flag-checkered"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.visits.approved') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Buscar</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Nombre, institución...">
            </div>
            <div class="col-md-3">
                <label for="activity" class="form-label">Actividad</label>
                <select class="form-select" id="activity" name="activity">
                    <option value="">Todas las actividades</option>
                    @foreach(\App\Models\VisitActivity::all() as $activity)
                        <option value="{{ $activity->id }}" {{ request('activity') == $activity->id ? 'selected' : '' }}>
                            {{ $activity->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="date_from" class="form-label">Desde</label>
                <input type="date" class="form-control" id="date_from" name="date_from" 
                       value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label for="date_to" class="form-label">Hasta</label>
                <input type="date" class="form-control" id="date_to" name="date_to" 
                       value="{{ request('date_to') }}">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>Filtrar
                </button>
                <a href="{{ route('admin.visits.approved') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Limpiar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Lista de Visitas Aprobadas -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>
            Lista de Visitas Aprobadas
        </h5>
    </div>
    <div class="card-body">
        @if($approvedVisits->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Visitante</th>
                            <th>Institución</th>
                            <th>Actividades</th>
                            <th>Fecha de Visita</th>
                            <th>Horario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approvedVisits as $visit)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $visit->user->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $visit->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $visit->user->institution_name }}</span>
                                <br>
                                <small class="text-muted">{{ $visit->user->institution_type }}</small>
                            </td>
                            <td>
                                @foreach($visit->activities as $activity)
                                    <span class="badge bg-secondary me-1">{{ $activity->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <strong>{{ $visit->confirmed_date ? $visit->confirmed_date->format('d/m/Y') : 'Pendiente' }}</strong>
                                <br>
                                <small class="text-muted">{{ $visit->confirmed_date ? $visit->confirmed_date->diffForHumans() : 'Fecha por confirmar' }}</small>
                            </td>
                            <td>
                                @if($visit->confirmed_start_time && $visit->confirmed_end_time)
                                    <span class="badge bg-warning">
                                        {{ $visit->confirmed_start_time->format('H:i') }} - {{ $visit->confirmed_end_time->format('H:i') }}
                                    </span>
                                @elseif($visit->preferred_start_time && $visit->preferred_end_time)
                                    <span class="badge bg-secondary">
                                        {{ $visit->preferred_start_time->format('H:i') }} - {{ $visit->preferred_end_time->format('H:i') }}
                                    </span>
                                @else
                                    <span class="text-muted">Por definir</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-success">Aprobada</span>
                                <br>
                                <small class="text-muted">Aprobada el {{ $visit->approved_at->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.visits.details', $visit->id) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#completeModal{{ $visit->id }}"
                                            title="Marcar como completada">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <a href="{{ route('chat.show', $visit->chat_room_id ?? 1) }}" 
                                       class="btn btn-sm btn-outline-info"
                                       title="Chat">
                                        <i class="fas fa-comments"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Modal para marcar como completada -->
                        <div class="modal fade" id="completeModal{{ $visit->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Marcar Visita como Completada</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.visits.complete', $visit->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p><strong>Visitante:</strong> {{ $visit->user->name }}</p>
                                                                                         <p><strong>Fecha:</strong> {{ $visit->confirmed_date ? $visit->confirmed_date->format('d/m/Y') : 'Pendiente' }}</p>
                                            <p><strong>Actividades:</strong> 
                                                @foreach($visit->activities as $activity)
                                                    {{ $activity->name }}{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            </p>
                                            
                                            <div class="mb-3">
                                                <label for="completion_notes" class="form-label">Notas de Completación</label>
                                                <textarea class="form-control" id="completion_notes" name="completion_notes" 
                                                          rows="3" placeholder="Observaciones sobre la visita..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check me-1"></i>Marcar como Completada
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                {{ $approvedVisits->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-check-circle fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No hay visitas aprobadas</h4>
                <p class="text-muted">Las visitas aprobadas por el SuperAdministrador aparecerán aquí.</p>
                <a href="{{ route('admin.visits.calendar') }}" class="btn btn-primary">
                    <i class="fas fa-calendar me-1"></i>Ver Calendario
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-submit del formulario cuando cambien los filtros
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('select, input[type="date"]');
    
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            form.submit();
        });
    });
});
</script>
@endpush
