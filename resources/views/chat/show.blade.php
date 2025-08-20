@extends('layouts.app')

@section('title', 'Chat - ' . $chatRoom->subject)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-comments text-primary me-2"></i>
        Chat: {{ $chatRoom->subject }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('chat.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Volver
            </a>
        </div>
        @if((auth()->user()->isSuperAdmin() || auth()->user()->isAdmin()) && $chatRoom->isActive())
        <div class="btn-group me-2">
            <form action="{{ route('chat.close', $chatRoom->room_id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-warning" 
                        onclick="return confirm('¿Estás seguro de cerrar este chat?')">
                    <i class="fas fa-times me-1"></i>Cerrar
                </button>
            </form>
            <form action="{{ route('chat.resolve', $chatRoom->room_id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-success" 
                        onclick="return confirm('¿Marcar como resuelto?')">
                    <i class="fas fa-check me-1"></i>Resolver
                </button>
            </form>
        </div>
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

<div class="row">
    <!-- Información del Chat -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Información del Chat
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Estado:</strong><br>
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
                </div>
                
                <div class="mb-3">
                    <strong>Visitante:</strong><br>
                    <div class="d-flex align-items-center mt-1">
                        <i class="fas fa-user-circle fa-2x text-primary me-2"></i>
                        <div>
                            <div class="fw-bold">{{ $chatRoom->visitor->name }}</div>
                            <small class="text-muted">{{ $chatRoom->visitor->email }}</small>
                        </div>
                    </div>
                </div>
                
                @if($chatRoom->admin)
                <div class="mb-3">
                    <strong>Administrador:</strong><br>
                    <div class="d-flex align-items-center mt-1">
                        <i class="fas fa-user-shield fa-2x text-success me-2"></i>
                        <div>
                            <div class="fw-bold">{{ $chatRoom->admin->name }}</div>
                            <small class="text-muted">{{ $chatRoom->admin->email }}</small>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="mb-3">
                    <strong>Creado:</strong><br>
                    <small class="text-muted">{{ $chatRoom->created_at->format('d/m/Y H:i') }}</small>
                </div>
                
                @if($chatRoom->last_message_at)
                <div class="mb-3">
                    <strong>Último mensaje:</strong><br>
                    <small class="text-muted">{{ $chatRoom->last_message_at->format('d/m/Y H:i') }}</small>
                </div>
                @endif
                
                <div class="mb-3">
                    <strong>Total mensajes:</strong><br>
                    <span class="badge bg-info">{{ $chatRoom->messages->count() }}</span>
                </div>
            </div>
        </div>
        
        <!-- Estado de conexión -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-wifi me-2"></i>Estado de Conexión
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <span class="fw-bold">Visitante:</span>
                    @if($chatRoom->visitor_online)
                        <span class="badge bg-success">Online</span>
                    @else
                        <span class="badge bg-secondary">Offline</span>
                    @endif
                </div>
                <div class="mb-2">
                    <span class="fw-bold">Administrador:</span>
                    @if($chatRoom->admin_online)
                        <span class="badge bg-success">Online</span>
                    @else
                        <span class="badge bg-secondary">Offline</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Área de Chat -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-comments me-2"></i>Conversación
                </h6>
            </div>
            <div class="card-body p-0">
                <!-- Mensajes -->
                <div id="chat-messages" class="chat-messages" style="height: 400px; overflow-y: auto; padding: 1rem;">
                    @foreach($chatRoom->messages as $message)
                    <div class="message {{ $message->sender_id === auth()->id() ? 'message-own' : 'message-other' }}">
                        <div class="message-content">
                            <div class="message-header">
                                <span class="message-sender">
                                    @if($message->isFromAdmin())
                                        <i class="fas fa-user-shield text-success me-1"></i>
                                    @else
                                        <i class="fas fa-user text-primary me-1"></i>
                                    @endif
                                    {{ $message->sender->name }}
                                </span>
                                <span class="message-time">{{ $message->getFormattedTime() }}</span>
                            </div>
                            <div class="message-text">{{ $message->message }}</div>
                            @if($message->hasAttachment())
                            <div class="message-attachment">
                                <a href="{{ $message->getAttachmentUrl() }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-paperclip me-1"></i>{{ $message->attachment_name }}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Formulario de envío -->
                @if($chatRoom->isActive())
                <div class="chat-input p-3 border-top">
                    <form id="message-form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <textarea class="form-control" id="message-input" name="message" 
                                              placeholder="Escribe tu mensaje..." rows="2" required></textarea>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex gap-2">
                                    <label for="attachment" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-paperclip me-1"></i>Adjuntar
                                    </label>
                                    <input type="file" id="attachment" name="attachment" style="display: none;" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <span id="file-name" class="text-muted small"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <div class="p-3 border-top bg-light">
                    <div class="text-center text-muted">
                        <i class="fas fa-lock fa-2x mb-2"></i>
                        <p class="mb-0">Este chat está cerrado y no se pueden enviar más mensajes.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.chat-messages {
    background-color: #f8f9fa;
}

.message {
    margin-bottom: 1rem;
    display: flex;
}

.message-own {
    justify-content: flex-end;
}

.message-other {
    justify-content: flex-start;
}

.message-content {
    max-width: 70%;
    padding: 0.75rem;
    border-radius: 1rem;
    position: relative;
}

.message-own .message-content {
    background-color: #007bff;
    color: white;
    border-bottom-right-radius: 0.25rem;
}

.message-other .message-content {
    background-color: white;
    border: 1px solid #dee2e6;
    border-bottom-left-radius: 0.25rem;
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.message-sender {
    font-weight: bold;
}

.message-time {
    opacity: 0.7;
}

.message-text {
    word-wrap: break-word;
}

.message-attachment {
    margin-top: 0.5rem;
}

.message-own .message-attachment .btn {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
}

.message-own .message-attachment .btn:hover {
    background-color: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.4);
    color: white;
}
</style>
@endpush

@push('scripts')
<script>
let lastMessageId = {{ $chatRoom->messages->last() ? $chatRoom->messages->last()->id : 0 }};
let isTyping = false;

// Función para enviar mensaje
document.getElementById('message-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();
    
    if (!message) return;
    
    // Deshabilitar formulario
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    
    fetch('{{ route("chat.send-message", $chatRoom->room_id) }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Limpiar formulario
            messageInput.value = '';
            document.getElementById('file-name').textContent = '';
            document.getElementById('attachment').value = '';
            
            // Agregar mensaje a la vista
            addMessageToView(data.message, true);
            
            // Actualizar último mensaje
            lastMessageId = data.message.id;
        } else {
            alert('Error al enviar mensaje: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar mensaje');
    })
    .finally(() => {
        // Rehabilitar formulario
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Función para agregar mensaje a la vista
function addMessageToView(message, isOwn = false) {
    const messagesContainer = document.getElementById('chat-messages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${isOwn ? 'message-own' : 'message-other'}`;
    
    const attachmentHtml = message.attachment_path ? 
        `<div class="message-attachment">
            <a href="/storage/${message.attachment_path}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-paperclip me-1"></i>${message.attachment_name}
            </a>
        </div>` : '';
    
    messageDiv.innerHTML = `
        <div class="message-content">
            <div class="message-header">
                <span class="message-sender">
                    ${message.sender_type === 'admin' ? 
                        '<i class="fas fa-user-shield text-success me-1"></i>' : 
                        '<i class="fas fa-user text-primary me-1"></i>'}
                    ${message.sender.name}
                </span>
                <span class="message-time">${message.formatted_time}</span>
            </div>
            <div class="message-text">${message.message}</div>
            ${attachmentHtml}
        </div>
    `;
    
    messagesContainer.appendChild(messageDiv);
    scrollToBottom();
}

// Función para hacer scroll al final
function scrollToBottom() {
    const messagesContainer = document.getElementById('chat-messages');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Función para obtener nuevos mensajes
function getNewMessages() {
    fetch('{{ route("chat.get-messages", $chatRoom->room_id) }}')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const newMessages = data.messages.filter(msg => msg.id > lastMessageId);
            
            newMessages.forEach(message => {
                const isOwn = message.sender_id === {{ auth()->id() }};
                addMessageToView(message, isOwn);
                lastMessageId = message.id;
            });
        }
    })
    .catch(error => {
        console.error('Error getting messages:', error);
    });
}

// Actualizar estado online
function updateOnlineStatus(online) {
    fetch('{{ route("chat.online-status") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ online: online })
    });
}

// Configurar eventos
document.addEventListener('DOMContentLoaded', function() {
    scrollToBottom();
    
    // Obtener nuevos mensajes cada 3 segundos
    setInterval(getNewMessages, 3000);
    
    // Actualizar estado online cada 30 segundos
    setInterval(() => updateOnlineStatus(true), 30000);
    
    // Marcar como online al cargar
    updateOnlineStatus(true);
    
    // Marcar como offline al cerrar
    window.addEventListener('beforeunload', () => updateOnlineStatus(false));
});

// Manejar archivos adjuntos
document.getElementById('attachment').addEventListener('change', function() {
    const fileName = this.files[0] ? this.files[0].name : '';
    document.getElementById('file-name').textContent = fileName;
});

// Auto-resize del textarea
document.getElementById('message-input').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 100) + 'px';
});
</script>
@endpush
