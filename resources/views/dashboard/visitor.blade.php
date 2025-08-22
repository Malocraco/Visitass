@extends('layouts.app')

@section('title', 'Dashboard - Visitante')

@section('content')

<!-- Mensaje de Bienvenida -->
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-user fa-4x text-primary mb-3"></i>
                </div>
                <h2 class="text-primary mb-3">¡Bienvenido, {{ $user->name }}!</h2>
                <p class="lead text-muted mb-3">Gestiona tus solicitudes de visita y mantén comunicación con los administradores.</p>
                <p class="text-muted mb-4">
                    Solicita visitas a nuestra institución, revisa el estado de tus solicitudes, 
                    coordina detalles con los administradores y mantén un historial de tus visitas.
                </p>    
            </div>
        </div>
    </div>
</div>
    
@endsection
