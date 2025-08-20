@extends('layouts.app')

@section('title', 'Reportes - Sistema de Visitas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-chart-bar text-info me-2"></i>
        Reportes y Estadísticas
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                <i class="fas fa-print me-1"></i>Imprimir
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download me-1"></i>Exportar PDF
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-file-excel me-1"></i>Exportar Excel
            </button>
        </div>
    </div>
</div>

<!-- Filtros de Reporte -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-filter me-2"></i>Filtros de Reporte
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.visits.reports') }}" class="row g-3">
            <div class="col-md-3">
                <label for="report_type" class="form-label">Tipo de Reporte</label>
                <select class="form-select" id="report_type" name="report_type">
                    <option value="general" {{ request('report_type') == 'general' ? 'selected' : '' }}>General</option>
                    <option value="monthly" {{ request('report_type') == 'monthly' ? 'selected' : '' }}>Mensual</option>
                    <option value="institution" {{ request('report_type') == 'institution' ? 'selected' : '' }}>Por Institución</option>
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
                <label for="institution_type" class="form-label">Tipo de Institución</label>
                <select class="form-select" id="institution_type" name="institution_type">
                    <option value="">Todos</option>
                    <option value="empresa" {{ request('institution_type') == 'empresa' ? 'selected' : '' }}>Empresa</option>
                    <option value="universidad" {{ request('institution_type') == 'universidad' ? 'selected' : '' }}>Universidad</option>
                    <option value="colegio" {{ request('institution_type') == 'colegio' ? 'selected' : '' }}>Colegio</option>
                    <option value="otro" {{ request('institution_type') == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>Generar Reporte
                </button>
                <a href="{{ route('admin.visits.reports') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Limpiar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Estadísticas Generales -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="mb-0">{{ $totalVisits }}</h3>
                        <p class="mb-0">Total de Visitas</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-line fa-3x"></i>
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
                        <h3 class="mb-0">{{ $thisMonthVisits }}</h3>
                        <p class="mb-0">Visitas este Mes</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-alt fa-3x"></i>
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
                        <h3 class="mb-0">{{ $thisYearVisits }}</h3>
                        <p class="mb-0">Visitas este Año</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Gráfico de Visitas por Estado -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-pie-chart me-2"></i>Visitas por Estado
                </h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Gráfico de Visitas por Mes -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Visitas por Mes (Últimos 12 meses)
                </h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Top Instituciones Visitantes -->
<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-trophy me-2"></i>Top 10 Instituciones Visitantes
                </h5>
            </div>
            <div class="card-body">
                @if($topInstitutions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Institución</th>
                                    <th>Tipo</th>
                                    <th>Total Visitas</th>
                                    <th>Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topInstitutions as $index => $institution)
                                <tr>
                                    <td>
                                        @if($index == 0)
                                            <i class="fas fa-medal text-warning"></i>
                                        @elseif($index == 1)
                                            <i class="fas fa-medal text-secondary"></i>
                                        @elseif($index == 2)
                                            <i class="fas fa-medal text-bronze"></i>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $institution->user->institution_name }}</strong><br>
                                        <small class="text-muted">{{ $institution->user->name }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ ucfirst($institution->user->institution_type) }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $institution->total }}</strong>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            @php
                                                $percentage = ($institution->total / $totalVisits) * 100;
                                            @endphp
                                            <div class="progress-bar bg-primary" 
                                                 style="width: {{ $percentage }}%">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay datos suficientes para mostrar estadísticas.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Resumen de Estados -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Resumen por Estado
                </h5>
            </div>
            <div class="card-body">
                @foreach($visitsByStatus as $status)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        @switch($status->status)
                            @case('pending')
                                <i class="fas fa-clock text-warning me-2"></i>
                                <span>Pendientes</span>
                                @break
                            @case('approved')
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Aprobadas</span>
                                @break
                            @case('completed')
                                <i class="fas fa-flag-checkered text-info me-2"></i>
                                <span>Completadas</span>
                                @break
                            @case('rejected')
                                <i class="fas fa-times text-danger me-2"></i>
                                <span>Rechazadas</span>
                                @break
                        @endswitch
                    </div>
                    <div>
                        <strong>{{ $status->total }}</strong>
                        <small class="text-muted">({{ number_format(($status->total / $totalVisits) * 100, 1) }}%)</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos para el gráfico de estados
    const statusData = @json($visitsByStatus);
    const statusLabels = [];
    const statusValues = [];
    const statusColors = ['#ffc107', '#28a745', '#17a2b8', '#dc3545'];

    statusData.forEach((item, index) => {
        let label = '';
        switch(item.status) {
            case 'pending': label = 'Pendientes'; break;
            case 'approved': label = 'Aprobadas'; break;
            case 'completed': label = 'Completadas'; break;
            case 'rejected': label = 'Rechazadas'; break;
        }
        statusLabels.push(label);
        statusValues.push(item.total);
    });

    // Gráfico de estados
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusValues,
                backgroundColor: statusColors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Datos para el gráfico mensual
    const monthlyData = @json($visitsByMonth);
    const monthlyLabels = [];
    const monthlyValues = [];

    monthlyData.forEach(item => {
        const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 
                           'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        monthlyLabels.push(`${monthNames[item.month - 1]} ${item.year}`);
        monthlyValues.push(item.total);
    });

    // Gráfico mensual
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Visitas',
                data: monthlyValues,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endpush
