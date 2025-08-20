@extends('layouts.app')

@section('title', 'Dashboard - Super Administrador')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    
</div>

<!-- Mensaje de Bienvenida -->
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-user-shield fa-4x text-primary mb-3"></i>
            </div>
                <h2 class="text-primary mb-3">¡Bienvenido, SuperAdministrador!</h2>
                <p class="lead text-muted mb-3">Tienes el control total del sistema.</p>
                                       <p class="text-muted mb-4">
                           Gestiona usuarios, supervisa actividades, revisa reportes y asegura que todo funcione de manera óptima.
                       </p>    
            </div>
        </div>
    </div>
</div>
@endsection
