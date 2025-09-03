@extends('layouts.app')

@section('title', 'Calendario de Visitas - Sistema de Visitas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-calendar-check text-success me-2"></i>
        Calendario de Visitas
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



<!-- Leyenda -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-info-circle me-2"></i>Leyenda
        </h5>
    </div>
    <div class="card-body">
                 <div class="row">
             <div class="col-md-4">
                 <div class="d-flex align-items-center mb-2">
                     <div class="calendar-legend-item bg-danger me-2"></div>
                     <span>Días No Disponibles</span>
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="d-flex align-items-center mb-2">
                     <div class="calendar-legend-item bg-warning me-2"></div>
                     <span>Días Agendados</span>
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="d-flex align-items-center mb-2">
                     <div class="calendar-legend-item bg-success me-2"></div>
                     <span>Días Disponibles</span>
                 </div>
             </div>
         </div>
    </div>
</div>

<!-- Calendario -->
<div class="card">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

<!-- Modal de Detalles de Visita -->
<div class="modal fade" id="visitModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Detalles de la Visita
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="visitModalBody">
                <!-- Contenido dinámico -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="#" class="btn btn-primary" id="viewDetailsBtn">
                    <i class="fas fa-external-link-alt me-1"></i>Ver Detalles Completos
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<style>
.calendar-legend-item {
    width: 20px;
    height: 20px;
    border-radius: 4px;
    display: inline-block;
}

 .fc-event {
     cursor: pointer;
     border: none;
     font-size: 0.9rem;
     font-weight: 600;
     border-radius: 4px;
     box-shadow: 0 2px 4px rgba(0,0,0,0.1);
 }

.fc-event:hover {
    opacity: 0.8;
    transform: scale(1.02);
    transition: all 0.2s ease;
}

.fc-day-disabled {
    background-color: #f8f9fa !important;
    color: #6c757d !important;
}

.fc-day-disabled .fc-day-number {
    color: #6c757d !important;
}

.fc-toolbar-title {
    font-size: 1.5rem !important;
    font-weight: 600;
}

.fc-button-primary {
    background-color: #007bff !important;
    border-color: #007bff !important;
}

.fc-button-primary:hover {
    background-color: #0056b3 !important;
    border-color: #0056b3 !important;
}

 .fc-daygrid-day.fc-day-today {
     background-color: rgba(0, 123, 255, 0.15) !important;
     border: 2px solid #007bff !important;
 }
 
 .fc-daygrid-day {
     border: 1px solid #e9ecef !important;
 }
 
 .fc-daygrid-day:hover {
     background-color: rgba(0, 123, 255, 0.05) !important;
 }

 .fc-daygrid-day-number {
     font-weight: 600;
     font-size: 1.1rem;
     color: #333 !important;
 }
 
 .fc-day-disabled .fc-daygrid-day-number {
     color: #721c24 !important;
     font-weight: 700;
 }
 
 /* Forzar estilos para fines de semana */
 .fc-daygrid-day.fc-day-sun,
 .fc-daygrid-day.fc-day-sat {
     background-color: #f8d7da !important;
 }
 
 .fc-daygrid-day.fc-day-sun .fc-daygrid-day-number,
 .fc-daygrid-day.fc-day-sat .fc-daygrid-day-number {
     color: #721c24 !important;
     font-weight: 700;
 }
 
 .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
     color: #007bff !important;
     font-weight: 700;
 }

 .fc-event-title {
     font-weight: 600;
     color: #fff !important;
     text-shadow: 0 1px 2px rgba(0,0,0,0.3);
 }
 
 /* Estilos para días disponibles */
 .fc-daygrid-day.available-day .fc-daygrid-day-number {
     color: #155724 !important;
     font-weight: 700;
 }
 
 /* Mejorar contraste general */
 .fc-daygrid-day {
     min-height: 80px;
 }
 
 .fc-daygrid-day-number {
     padding: 4px 6px;
     border-radius: 3px;
     background-color: rgba(255, 255, 255, 0.8);
 }

/* Responsive */
@media (max-width: 768px) {
    .fc-toolbar {
        flex-direction: column;
        gap: 10px;
    }
    
    .fc-toolbar-chunk {
        display: flex;
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos de eventos
    const events = @json($events);
    const unavailableDays = @json($unavailableDays);
    
    // Crear array de días no disponibles para FullCalendar
    const disabledDates = unavailableDays.map(day => {
        return {
            start: day.date,
            end: day.date,
            display: 'background',
            color: '#dc3545', // Rojo para todos los días no disponibles
            title: day.reason,
            type: day.type
        };
    });
    
    // Combinar eventos y días no disponibles
    const allEvents = [...events, ...disabledDates];
    
    // Inicializar FullCalendar
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
        },
        events: allEvents,
        eventClick: function(info) {
            if (info.event.display === 'background') {
                // Es un día no disponible
                showUnavailableDayModal(info.event.title, info.event.start);
            } else {
                // Es una visita
                showVisitModal(info.event.extendedProps.visit);
            }
        },
        dayCellDidMount: function(arg) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const currentDate = new Date(arg.date);
            currentDate.setHours(0, 0, 0, 0);
            const dayOfWeek = currentDate.getDay();
            const isWeekend = dayOfWeek === 0 || dayOfWeek === 6; // 0 = domingo, 6 = sábado
            
            // Verificar si es un día pasado (incluyendo días de meses anteriores)
            if (currentDate < today) {
                arg.el.classList.add('fc-day-disabled');
                arg.el.title = 'Día pasado';
                arg.el.style.backgroundColor = '#f8d7da';
                arg.el.style.color = '#721c24';
                
                // Agregar evento de click para días pasados
                arg.el.addEventListener('click', function() {
                    showUnavailableDayModal('Día pasado', arg.date);
                });
            }
            // Verificar si es un fin de semana (SIN IMPORTAR EL MES - siempre en rojo)
            else if (isWeekend) {
                arg.el.classList.add('fc-day-disabled');
                arg.el.title = 'Fin de semana';
                arg.el.style.backgroundColor = '#f8d7da';
                arg.el.style.color = '#721c24';
                
                // Agregar evento de click para fines de semana
                arg.el.addEventListener('click', function() {
                    showUnavailableDayModal('Fin de semana', arg.date);
                });
            }
            // Verificar si es un día no disponible del mes actual (festivos)
            else {
                const dateStr = arg.date.toISOString().split('T')[0];
                const unavailableDay = unavailableDays.find(day => day.date === dateStr);
                
                if (unavailableDay) {
                    arg.el.classList.add('fc-day-disabled');
                    arg.el.title = unavailableDay.reason;
                    arg.el.style.backgroundColor = '#f8d7da';
                    arg.el.style.color = '#721c24';
                    
                    // Agregar evento de click para días festivos
                    arg.el.addEventListener('click', function() {
                        showUnavailableDayModal(unavailableDay.reason, arg.date);
                    });
                }
                // Marcar días disponibles (días futuros que no son fines de semana ni festivos)
                else if (currentDate >= today) {
                    // Verificar si no hay eventos en este día
                    const hasEvents = events.some(event => {
                        const eventDate = new Date(event.start);
                        eventDate.setHours(0, 0, 0, 0);
                        return eventDate.getTime() === currentDate.getTime();
                    });
                    
                    if (!hasEvents) {
                        arg.el.style.backgroundColor = '#d4edda';
                        arg.el.style.color = '#155724';
                        arg.el.title = 'Día disponible para agendar';
                        arg.el.classList.add('available-day');
                    }
                }
            }
        },
        eventDidMount: function(info) {
            if (info.event.display === 'background') {
                info.el.style.opacity = '0.3';
            }
        },

        height: 'auto',
        aspectRatio: 1.35,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        firstDay: 0, // Domingo
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana'
        }
    });
    
         calendar.render();
     
     // Forzar aplicación de estilos a fines de semana después del renderizado
     setTimeout(function() {
         const weekendCells = document.querySelectorAll('.fc-day-sun, .fc-day-sat');
         weekendCells.forEach(function(cell) {
             const dayNumber = cell.querySelector('.fc-daygrid-day-number');
             if (dayNumber) {
                 const currentDate = new Date(cell.getAttribute('data-date'));
                 const today = new Date();
                 today.setHours(0, 0, 0, 0);
                 currentDate.setHours(0, 0, 0, 0);
                 
                 // Solo aplicar si no es un día pasado
                 if (currentDate >= today) {
                     cell.style.backgroundColor = '#f8d7da';
                     cell.style.color = '#721c24';
                     dayNumber.style.color = '#721c24';
                     dayNumber.style.fontWeight = '700';
                     cell.title = 'Fin de semana';
                     
                     // Agregar evento de click
                     cell.addEventListener('click', function() {
                         showUnavailableDayModal('Fin de semana', currentDate);
                     });
                 }
             }
         });
     }, 100);
    
    // Función para mostrar modal de visita
    function showVisitModal(visit) {
        const modalBody = document.getElementById('visitModalBody');
        const viewDetailsBtn = document.getElementById('viewDetailsBtn');
        
        modalBody.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary">Información de la Visita</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>#${visit.id}</td>
                        </tr>
                        <tr>
                            <td><strong>Estado:</strong></td>
                            <td>
                                ${getStatusBadge(visit.status)}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Fecha:</strong></td>
                            <td>${formatDate(visit.preferred_date)}</td>
                        </tr>
                        <tr>
                            <td><strong>Hora Inicio:</strong></td>
                            <td>${visit.preferred_start_time}</td>
                        </tr>
                        <tr>
                            <td><strong>Hora Fin:</strong></td>
                            <td>${visit.preferred_end_time}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary">Información del Visitante</h6>
                    <p><strong>Nombre:</strong> ${visit.user.name}</p>
                    <p><strong>Email:</strong> ${visit.contact_email}</p>
                    <p><strong>Teléfono:</strong> ${visit.contact_phone}</p>
                    <p><strong>Institución:</strong> ${visit.institution_name}</p>
                    <p><strong>Propósito:</strong> ${visit.visit_purpose}</p>
                </div>
            </div>
        `;
        
        viewDetailsBtn.href = `/admin/visits/${visit.id}/details`;
        
        document.getElementById('visitModal').classList.remove('hidden');
        modal.show();
    }
    
    // Función para mostrar modal de día no disponible
    function showUnavailableDayModal(reason, date) {
        const modalBody = document.getElementById('visitModalBody');
        const viewDetailsBtn = document.getElementById('viewDetailsBtn');
        
        modalBody.innerHTML = `
            <div class="text-center">
                <i class="fas fa-ban fa-3x text-danger mb-3"></i>
                <h5 class="text-danger">Día No Disponible</h5>
                <p class="lead">${reason}</p>
                <p class="text-muted">${formatDate(date)}</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    No se pueden programar visitas en este día.
                </div>
            </div>
        `;
        
        viewDetailsBtn.style.display = 'none';
        
        document.getElementById('visitModal').classList.remove('hidden');
        modal.show();
    }
    
    // Función para obtener badge de estado
    function getStatusBadge(status) {
        const badges = {
            'pending': '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Pendiente</span>',
            'approved': '<span class="badge bg-success"><i class="fas fa-check me-1"></i>Aprobada</span>',
            'completed': '<span class="badge bg-info"><i class="fas fa-flag-checkered me-1"></i>Completada</span>',
            'rejected': '<span class="badge bg-danger"><i class="fas fa-times me-1"></i>Rechazada</span>'
        };
        return badges[status] || '';
    }
    
    // Función para formatear fecha
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
});
</script>
@endpush
