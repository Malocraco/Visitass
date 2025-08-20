@extends('layouts.app')

@section('title', 'Chats - Sistema de Visitas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-comments text-primary me-2"></i>
        Chats
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @if(!auth()->user()->isSuperAdmin() && !auth()->user()->isAdmin())
        <div class="btn-group me-2">
            <a href="{{ route('chat.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i>Nuevo Chat
            </a>
        </div>
        @endif
        @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())

        @endif
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('chat.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label">Estado</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Todos</option>
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Abierto</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activo</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Cerrado</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resuelto</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label">Buscar</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Asunto o mensaje...">
            </div>
            <div class="col-md-3">
                <label for="date" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="date" name="date" 
                       value="{{ request('date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Lista de Chats -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Lista de Chats
        </h5>
    </div>
    <div class="card-body p-0">
        @if($chatRooms->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Asunto</th>
                        <th>Visitante</th>
                        <th>Administrador</th>
                        <th>Estado</th>
                        <th>Último Mensaje</th>
                        <th>Mensajes</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chatRooms as $chatRoom)
                    <tr>
                        <td>
                            <span class="badge bg-secondary">{{ substr($chatRoom->room_id, 0, 8) }}...</span>
                        </td>
                        <td>
                            <strong>{{ $chatRoom->subject }}</strong>
                            @if($chatRoom->getUnreadCount(auth()->id()) > 0)
                                <span class="badge bg-danger ms-2">{{ $chatRoom->getUnreadCount(auth()->id()) }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle fa-2x text-primary me-2"></i>
                                <div>
                                    <div class="fw-bold">{{ $chatRoom->visitor->name }}</div>
                                    <small class="text-muted">{{ $chatRoom->visitor->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($chatRoom->admin)
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-shield fa-2x text-success me-2"></i>
                                <div>
                                    <div class="fw-bold">{{ $chatRoom->admin->name }}</div>
                                    <small class="text-muted">{{ $chatRoom->admin->email }}</small>
                                </div>
                            </div>
                            @else
                            <span class="text-muted">Sin asignar</span>
                            @endif
                        </td>
                        <td>
                            @switch($chatRoom->status)
                                @case('open')
                                    <span class="badge bg-warning">Abierto</span>
                                    @break
                                @case('active')
                                    <span class="badge bg-primary">Activo</span>
                                    @break
                                @case('closed')
                                    <span class="badge bg-secondary">Cerrado</span>
                                    @break
                                @case('resolved')
                                    <span class="badge bg-success">Resuelto</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            @if($chatRoom->last_message_at)
                            <div>
                                <div class="fw-bold">{{ $chatRoom->last_message_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $chatRoom->last_message_at->format('H:i') }}</small>
                            </div>
                            @else
                            <span class="text-muted">Sin mensajes</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $chatRoom->messages->count() }}</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('chat.show', $chatRoom->room_id) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if((auth()->user()->isSuperAdmin() || auth()->user()->isAdmin()) && $chatRoom->isActive())
                                <form action="{{ route('chat.close', $chatRoom->room_id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-warning" 
                                            onclick="return confirm('¿Estás seguro de cerrar este chat?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                <form action="{{ route('chat.resolve', $chatRoom->room_id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" 
                                            onclick="return confirm('¿Marcar como resuelto?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-comments fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">No hay chats disponibles</h5>
            <p class="text-muted">Cuando se creen chats, aparecerán aquí.</p>
            @if(!auth()->user()->isSuperAdmin() && !auth()->user()->isAdmin())
            <a href="{{ route('chat.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Crear Nuevo Chat
            </a>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Paginación -->
@if($chatRooms->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $chatRooms->links() }}
</div>
@endif
@endsection

@push('scripts')
<script>
// Actualizar estado online cada 30 segundos
setInterval(function() {
    fetch('{{ route("chat.online-status") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ online: true })
    });
}, 30000);

// Marcar como offline cuando se cierre la página
window.addEventListener('beforeunload', function() {
    fetch('{{ route("chat.online-status") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ online: false })
    });
});
</script>
@endpush
