@extends('layouts.app')

@section('title', 'Dashboard - Administrador')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    
</div>

<!-- Mensaje de Bienvenida -->
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-user-cog fa-4x text-primary mb-3"></i>
                </div>
                <h2 class="text-primary mb-3">¡Bienvenido, Administrador!</h2>
                <p class="lead text-muted mb-3">Gestiona las visitas aprobadas y coordina las actividades.</p>
                <p class="text-muted mb-4">
                    Revisa las visitas aprobadas por el SuperAdministrador, coordina las actividades, 
                    gestiona el calendario y mantén comunicación con los visitantes.
                </p>    
            </div>
        </div>
    </div>
</div>

<!-- Tarjetas de Estadísticas -->
<div class="row mt-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                @php
                    $approvedVisits = \App\Models\Visit::where('status', 'approved')->count();
                @endphp
                <h3>{{ $approvedVisits }}</h3>
                <p>Visitas Aprobadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ route('admin.visits.approved') }}" class="small-box-footer">
                Ver detalles <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                @php
                    $completedVisits = \App\Models\Visit::where('status', 'completed')->count();
                @endphp
                <h3>{{ $completedVisits }}</h3>
                <p>Visitas Completadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-flag-checkered"></i>
            </div>
            <a href="{{ route('admin.visits.approved') }}" class="small-box-footer">
                Ver detalles <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                @php
                    $todayVisits = \App\Models\Visit::where('status', 'approved')
                        ->whereDate('confirmed_date', today())
                        ->count();
                @endphp
                <h3>{{ $todayVisits }}</h3>
                <p>Visitas Hoy</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <a href="{{ route('admin.visits.calendar') }}" class="small-box-footer">
                Ver calendario <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                @php
                    $openChats = \App\Models\ChatRoom::where('status', 'open')->count();
                @endphp
                <h3>{{ $openChats }}</h3>
                <p>Chats Activos</p>
            </div>
            <div class="icon">
                <i class="fas fa-comments"></i>
            </div>
            <a href="{{ route('chat.index') }}" class="small-box-footer">
                Ver chats <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>


@endsection
