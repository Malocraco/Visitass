@extends('layouts.app')

@section('title', 'Solicitar Visita - Sistema de Visitas')

@push('styles')
<style>
/* Estilos del Mini Calendario */
.calendar-container {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.calendar-header {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 10px;
}

.calendar-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
    margin-bottom: 5px;
}

.calendar-day-header {
    text-align: center;
    font-weight: 600;
    font-size: 0.8rem;
    color: #6c757d;
    padding: 8px 4px;
}

.calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
}

.calendar-day {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e9ecef;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    position: relative;
}

.calendar-day:hover {
    background-color: #f8f9fa;
    transform: scale(1.05);
}

.calendar-day.available {
    background-color: #d4edda;
    color: #155724;
    border-color: #c3e6cb;
}

.calendar-day.available:hover {
    background-color: #c3e6cb;
    border-color: #b1dfbb;
}

.calendar-day.occupied {
    background-color: #fff3cd;
    color: #856404;
    border-color: #ffeaa7;
    cursor: not-allowed;
    opacity: 0.8;
}

.calendar-day.occupied:hover {
    transform: none;
    background-color: #fff3cd;
}

.calendar-day.selected {
    background-color: #28a745;
    color: white;
    border-color: #1e7e34;
    box-shadow: 0 0 0 2px rgba(40,167,69,0.25);
}

.calendar-day.selected:hover {
    background-color: #1e7e34;
}

.calendar-day.disabled {
    background-color: #f8f9fa;
    color: #adb5bd;
    cursor: not-allowed;
    opacity: 0.5;
}

.calendar-day.disabled:hover {
    transform: none;
    background-color: #f8f9fa;
}

.calendar-day.past {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
    cursor: not-allowed;
    opacity: 0.7;
}

.calendar-day.past:hover {
    transform: none;
    background-color: #f8d7da;
}

.calendar-day.weekend {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
    cursor: not-allowed;
    opacity: 0.7;
}

.calendar-day.weekend:hover {
    transform: none;
    background-color: #f8d7da;
}

.calendar-day.today {
    border: 2px solid #28a745;
    font-weight: bold;
}

/* Leyenda del calendario */
.calendar-legend {
    margin-top: 10px;
}

.legend-item {
    display: inline-flex;
    align-items: center;
    font-size: 0.8rem;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 2px;
    margin-right: 4px;
    display: inline-block;
}

.legend-color.available {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
}

.legend-color.occupied {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
}

.legend-color.selected {
    background-color: #28a745;
    border: 1px solid #1e7e34;
}

.legend-color.past {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
}

.legend-color.weekend {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
}

/* Responsive */
@media (max-width: 768px) {
    .calendar-container {
        padding: 10px;
    }
    
    .calendar-day {
        font-size: 0.8rem;
    }
    
    .calendar-day-header {
        font-size: 0.7rem;
        padding: 6px 2px;
    }
}

/* Estilos del Reloj Circular */
.clock-container {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.clock-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 15px;
}

.clock {
    width: 200px;
    height: 200px;
    border: 8px solid #007bff;
    border-radius: 50%;
    position: relative;
    background: #f8f9fa;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.hour-marks {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}

.hour-mark {
    position: absolute;
    width: 20px;
    height: 20px;
    text-align: center;
    font-weight: bold;
    font-size: 14px;
    color: #495057;
    transform-origin: 50% 100px;
    line-height: 20px;
    top: 0.1px;
    left: calc(50% - 10px);
}

.hand {
    position: absolute;
    bottom: 50%;
    left: 50%;
    transform-origin: bottom;
    border-radius: 4px;
    transition: transform 0.1s ease;
}

.hour-hand {
    width: 4px;
    height: 60px;
    background: #343a40;
    margin-left: -2px;
    transform-origin: 50% 100%;
}

.minute-hand {
    width: 3px;
    height: 80px;
    background: #6c757d;
    margin-left: -1.5px;
    transform-origin: 50% 100%;
}

.second-hand {
    width: 2px;
    height: 90px;
    background: #dc3545;
    margin-left: -1px;
    transform-origin: 50% 100%;
}

.center-dot {
    position: absolute;
    width: 12px;
    height: 12px;
    background: #007bff;
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.time-display {
    background: #e9ecef;
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 8px 12px;
    text-align: center;
    font-weight: bold;
    font-size: 16px;
    color: #495057;
    margin-bottom: 10px;
}

.time-input {
    text-align: center;
    font-weight: bold;
    font-size: 16px;
    color: #495057;
    border: 2px solid #ced4da;
    border-radius: 4px;
    padding: 8px 12px;
    transition: all 0.3s ease;
}

.time-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    outline: none;
}

.time-input:hover {
    border-color: #adb5bd;
}

.clock-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: center;
}

.clock-buttons .btn {
    font-size: 0.8rem;
    padding: 6px 12px;
}

/* Estados activos del reloj */
.clock.active {
    border-color: #28a745;
    box-shadow: 0 4px 12px rgba(40,167,69,0.3);
}

.clock.setting-arrival {
    border-color: #007bff;
    box-shadow: 0 4px 12px rgba(0,123,255,0.3);
}

.clock.setting-departure {
    border-color: #28a745;
    box-shadow: 0 4px 12px rgba(40,167,69,0.3);
}

/* Responsive para el reloj */
@media (max-width: 768px) {
    .clock {
        width: 150px;
        height: 150px;
        border-width: 6px;
    }
    
    .hour-mark {
        font-size: 10px;
        transform-origin: 10% 65px;
        top: 8px;
        left: calc(50% - 8px);
    }
    
    .hour-hand {
        height: 45px;
    }
    
    .minute-hand {
        height: 60px;
    }
    
    .second-hand {
        height: 67px;
    }
    
    .clock-buttons {
        flex-direction: column;
    }
    
    .clock-buttons .btn {
        width: 100%;
    }
}
 
/* Estilos para campos de solo lectura */
.form-control[readonly],
.form-select[disabled] {
    background-color: #f8f9fa !important;
    border-color: #dee2e6;
    color: #495057;
    cursor: not-allowed;
    opacity: 0.8;
}
 
.form-control[readonly]:focus,
.form-select[disabled]:focus {
    box-shadow: none;
    border-color: #dee2e6;
}
 
.form-control[readonly]:hover,
.form-select[disabled]:hover {
    background-color: #f8f9fa !important;
    border-color: #dee2e6;
}
 
/* Estilo para el mensaje de alerta */
.alert-link {
    text-decoration: underline;
    font-weight: 600;
}
 
.alert-link:hover {
    text-decoration: none;
}
 
/* Estilos para el campo de requisitos obligatorios */
#special_requirements {
    background-color: #f8f9fa !important;
    border-color: #dee2e6;
    color: #495057;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    line-height: 1.5;
    white-space: pre-line;
}
 
#special_requirements:focus {
    box-shadow: none;
    border-color: #dee2e6;
    background-color: #f8f9fa !important;
}
 
#special_requirements:read-only {
    cursor: default;
    opacity: 1;
}
 
/* Estilo para el texto de ayuda */
.form-text {
    font-size: 13px;
    color: #6c757d;
    margin-top: 5px;
}
 
/* Estilos para los cuadros de requisitos obligatorios */
.requirement-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 15px;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
 
.requirement-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}
 
.requirement-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 12px 20px;
    border-radius: 8px 8px 0 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}
 
.requirement-header i {
    font-size: 18px;
}
 
.requirement-content {
    padding: 20px;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    line-height: 1.6;
    color: #495057;
    white-space: pre-line;
}
 
.requirement-content ul {
    margin: 0;
    padding-left: 20px;
}
 
.requirement-content li {
    margin-bottom: 8px;
    position: relative;
}
 
.requirement-content li:before {
    content: "•";
    color: #007bff;
    font-weight: bold;
    position: absolute;
    left: -15px;
}
 
/* Animación de entrada para los cuadros */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
 
.requirement-card {
    animation: slideInUp 0.3s ease-out;
}
 
/* Responsive para los cuadros */
@media (max-width: 768px) {
    .requirement-header {
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .requirement-content {
        padding: 15px;
        font-size: 13px;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-plus me-2"></i>
                        Solicitud de Visita al CEFA
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('visits.submit') }}" id="visitForm">
                        @csrf
                        
                        <!-- Información General de la Visita -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Información General de la Visita
                                </h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="visit_date" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>
                                    Fecha de Visita *
                                </label>
                                
                                <!-- Mini Calendario -->
                                <div class="calendar-container">
                                    <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="prevMonth">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <h6 class="mb-0" id="currentMonth">Cargando...</h6>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="nextMonth">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="calendar-body">
                                        <div class="calendar-weekdays">
                                            <div class="calendar-day-header">Dom</div>
                                            <div class="calendar-day-header">Lun</div>
                                            <div class="calendar-day-header">Mar</div>
                                            <div class="calendar-day-header">Mié</div>
                                            <div class="calendar-day-header">Jue</div>
                                            <div class="calendar-day-header">Vie</div>
                                            <div class="calendar-day-header">Sáb</div>
                                        </div>
                                        <div class="calendar-days" id="calendarDays">
                                            <!-- Los días se cargarán dinámicamente -->
                                        </div>
                                    </div>
                                    
                                    <!-- Input oculto para el formulario -->
                                    <input type="hidden" 
                                           id="visit_date" 
                                           name="visit_date" 
                                           value="{{ old('visit_date') }}" 
                                           required>
                                </div>
                                
                                <!-- Leyenda del calendario -->
                                <div class="calendar-legend mt-2">
                                    <small class="text-muted">
                                        <span class="legend-item">
                                            <span class="legend-color available"></span> Disponible
                                        </span>
                                        <span class="legend-item ms-3">
                                            <span class="legend-color occupied"></span> Días Agendados
                                        </span>
                                        <span class="legend-item ms-3">
                                            <span class="legend-color selected"></span> Seleccionado
                                        </span>
                                        <span class="legend-item ms-3">
                                            <span class="legend-color past"></span> Dias No Disponibles
                                        </span>
                                    </small>
                                </div>
                                
                                @error('visit_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-clock me-1"></i>
                                    Horario de Visita *
                                </label>
                                
                                <!-- Reloj Circular -->
                                <div class="clock-container">
                                    <div class="clock-wrapper">
                                        <div class="clock" id="clock">
                                            <!-- Marcas de horas -->
                                            <div class="hour-marks">
                                                <div class="hour-mark" style="transform: rotate(0deg)">12</div>
                                                <div class="hour-mark" style="transform: rotate(30deg)">1</div>
                                                <div class="hour-mark" style="transform: rotate(60deg)">2</div>
                                                <div class="hour-mark" style="transform: rotate(90deg)">3</div>
                                                <div class="hour-mark" style="transform: rotate(120deg)">4</div>
                                                <div class="hour-mark" style="transform: rotate(150deg)">5</div>
                                                <div class="hour-mark" style="transform: rotate(180deg)">6</div>
                                                <div class="hour-mark" style="transform: rotate(210deg)">7</div>
                                                <div class="hour-mark" style="transform: rotate(240deg)">8</div>
                                                <div class="hour-mark" style="transform: rotate(270deg)">9</div>
                                                <div class="hour-mark" style="transform: rotate(300deg)">10</div>
                                                <div class="hour-mark" style="transform: rotate(330deg)">11</div>
                                            </div>
                                            
                                            <!-- Manecillas -->
                                            <div class="hand hour-hand" id="hourHand"></div>
                                            <div class="hand minute-hand" id="minuteHand"></div>
                                            <div class="hand second-hand" id="secondHand"></div>
                                            
                                            <!-- Centro del reloj -->
                                            <div class="center-dot"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Controles del reloj -->
                                    <div class="clock-controls mt-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label">Hora de Llegada</label>
                                                <input type="time" 
                                                       class="form-control time-input" 
                                                       id="arrivalTimeInput" 
                                                       value="08:00" 
                                                       required>
                                                <input type="hidden" id="arrival_time" name="arrival_time" value="08:00" required>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Hora de Salida</label>
                                                <input type="time" 
                                                       class="form-control time-input" 
                                                       id="departureTimeInput" 
                                                       value="09:00" 
                                                       required>
                                                <input type="hidden" id="departure_time" name="departure_time" value="09:00" required>
                                            </div>
                                        </div>
                                        
                                        <!-- Botones de control -->
                                        <div class="clock-buttons mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="setArrivalBtn">
                                                <i class="fas fa-sign-in-alt me-1"></i>Establecer Llegada
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-success" id="setDepartureBtn">
                                                <i class="fas fa-sign-out-alt me-1"></i>Establecer Salida
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" id="resetClockBtn">
                                                <i class="fas fa-undo me-1"></i>Reiniciar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                @error('arrival_time')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('departure_time')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="expected_participants" class="form-label">
                                    <i class="fas fa-users me-1"></i>
                                    Número de Personas *
                                </label>
                                <input type="number" 
                                       class="form-control @error('expected_participants') is-invalid @enderror" 
                                       id="expected_participants" 
                                       name="expected_participants" 
                                       value="{{ old('expected_participants') }}" 
                                       min="1" 
                                       max="100" 
                                       required>
                                @error('expected_participants')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="visit_purpose" class="form-label">
                                    <i class="fas fa-bullseye me-1"></i>
                                    Propósito de la Visita *
                                </label>
                                <textarea class="form-control @error('visit_purpose') is-invalid @enderror" 
                                          id="visit_purpose" 
                                          name="visit_purpose" 
                                          rows="3" 
                                          placeholder="Describe el propósito de la visita..."
                                          required>{{ old('visit_purpose') }}</textarea>
                                @error('visit_purpose')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-address-card me-2"></i>
                                    Información de Contacto
                                </h5>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Información de tu cuenta:</strong> Los siguientes campos muestran la información de tu perfil. Si necesitas actualizar algún dato, ve a <a href="{{ route('admin.settings.index') }}" class="alert-link">Configuración</a>.
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="contact_person" class="form-label">
                                    <i class="fas fa-user me-1"></i>
                                    Persona de Contacto *
                                </label>
                                <input type="text" 
                                       class="form-control bg-light" 
                                       id="contact_person" 
                                       name="contact_person" 
                                       value="{{ auth()->user()->name }}" 
                                       readonly
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="contact_phone" class="form-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Teléfono de Contacto *
                                </label>
                                <input type="tel" 
                                       class="form-control bg-light" 
                                       id="contact_phone" 
                                       name="contact_phone" 
                                       value="{{ auth()->user()->phone ?? 'No especificado' }}" 
                                       readonly
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="contact_email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>
                                    Email de Contacto *
                                </label>
                                <input type="email" 
                                       class="form-control bg-light" 
                                       id="contact_email" 
                                       name="contact_email" 
                                       value="{{ auth()->user()->email }}" 
                                       readonly
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="institution_name" class="form-label">
                                    <i class="fas fa-building me-1"></i>
                                    Nombre de la Empresa *
                                </label>
                                <input type="text" 
                                       class="form-control bg-light" 
                                       id="institution_name" 
                                       name="institution_name" 
                                       value="{{ auth()->user()->institution_name ?? 'No especificado' }}" 
                                       readonly
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="institution_type" class="form-label">
                                    <i class="fas fa-tag me-1"></i>
                                    Tipo de Visita *
                                </label>
                                <select class="form-select bg-light" 
                                        id="institution_type" 
                                        name="institution_type" 
                                        disabled
                                        required>
                                    <option value="">Selecciona el tipo</option>
                                    <option value="empresa" {{ auth()->user()->institution_type == 'empresa' ? 'selected' : '' }}>Empresa</option>
                                    <option value="universidad" {{ auth()->user()->institution_type == 'universidad' ? 'selected' : '' }}>Universidad</option>
                                    <option value="colegio" {{ auth()->user()->institution_type == 'colegio' ? 'selected' : '' }}>Colegio</option>
                                    <option value="otro" {{ auth()->user()->institution_type == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                <!-- Input oculto para enviar el valor del select deshabilitado -->
                                <input type="hidden" name="institution_type" value="{{ auth()->user()->institution_type ?? '' }}">
                            </div>
                        </div>

                        <!-- Actividades de Interés -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-list-check me-2"></i>
                                    Actividades de Interés
                                </h5>
                                <p class="text-muted">Selecciona las actividades que te interesan para la visita (opcional):</p>
                            </div>
                            
                            <div class="col-12">
                                <div class="row">
                                    @foreach($activities as $activity)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input @error('activities') is-invalid @enderror" 
                                                       type="checkbox" 
                                                       name="activities[]" 
                                                       value="{{ $activity->id }}" 
                                                       id="activity_{{ $activity->id }}"
                                                       {{ in_array($activity->id, old('activities', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="activity_{{ $activity->id }}">
                                                    <strong>{{ $activity->name }}</strong><br>
                                                    <small class="text-muted">{{ $activity->description }}</small>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <!-- Campo "Otro" para actividades personalizadas -->
                                    <div class="col-12 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="other_activities_check" 
                                                   id="other_activities_check"
                                                   {{ old('other_activities_check') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="other_activities_check">
                                                <strong>Otras actividades de interés</strong><br>
                                                <small class="text-muted">Especifica actividades adicionales que te gustaría realizar</small>
                                            </label>
                                        </div>
                                        
                                        <!-- Campo de texto para actividades personalizadas -->
                                        <div class="mt-2" id="other_activities_container" style="display: none;">
                                            <textarea class="form-control @error('other_activities') is-invalid @enderror" 
                                                      id="other_activities" 
                                                      name="other_activities" 
                                                      rows="3" 
                                                      placeholder="Describe las actividades específicas que te gustaría realizar durante la visita...">{{ old('other_activities') }}</textarea>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Ejemplos: Charlas específicas, talleres particulares, visitas a áreas específicas, etc.
                                            </small>
                                            @error('other_activities')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @error('activities')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Requisitos Especiales -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-star me-2"></i>
                                    Requisitos Obligatorios
                                </h5>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <div id="requirements-container">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Los requisitos obligatorios serán determinados por el administrador según las actividades que describas.
                                    </div>
                                </div>
                                
                                <!-- Campo oculto para enviar los requisitos -->
                                <input type="hidden" id="special_requirements" name="special_requirements" value="">
                            </div>
                        </div>

                        <!-- Servicios Adicionales -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-utensils me-2"></i>
                                    Servicios Adicionales
                                </h5>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="restaurant_service" 
                                           id="restaurant_service"
                                           value="1"
                                           {{ old('restaurant_service') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="restaurant_service">
                                        <strong>Requiere servicio de restaurante</strong>
                                    </label>
                                </div>
                                
                                <div class="alert alert-warning mt-2">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Importante:</strong> Es necesario indicar con antelación el tipo de servicio y la cantidad de personas.
                                </div>
                                
                                <!-- Información del restaurante -->
                                <div class="card mt-3">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Información del Restaurante
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-2">
                                                    <strong>Costo del almuerzo:</strong><br>
                                                    <span class="text-success fw-bold">$12.000 por persona</span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-2">
                                                    <strong>Contacto del restaurante:</strong><br>
                                                    <span class="fw-bold">Señor Jhon Bedoya</span>
                                                </p>
                                                <p class="mb-0">
                                                    <strong>Celulares:</strong><br>
                                                    <span class="text-primary">313 403 1807 / 313 403 1809</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Campos adicionales para el restaurante (se muestran si está marcado) -->
                                <div id="restaurant-fields" class="mt-3" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="restaurant_participants" class="form-label">
                                                <i class="fas fa-users me-1"></i>
                                                Cantidad de personas para el almuerzo *
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('restaurant_participants') is-invalid @enderror" 
                                                   id="restaurant_participants" 
                                                   name="restaurant_participants" 
                                                   value="{{ old('restaurant_participants') }}" 
                                                   min="1" 
                                                   max="100">
                                            @error('restaurant_participants')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="restaurant_notes" class="form-label">
                                                <i class="fas fa-sticky-note me-1"></i>
                                                Notas adicionales para el restaurante
                                            </label>
                                            <textarea class="form-control @error('restaurant_notes') is-invalid @enderror" 
                                                      id="restaurant_notes" 
                                                      name="restaurant_notes" 
                                                      rows="3" 
                                                      placeholder="Especificaciones especiales, restricciones alimentarias, etc...">{{ old('restaurant_notes') }}</textarea>
                                            @error('restaurant_notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('dashboard.visitor') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Enviar Solicitud
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables del calendario
    let currentDate = new Date();
    let selectedDate = null;
    let availableDates = [];
    let occupiedDates = [];
    
    // Elementos del DOM
    const calendarDays = document.getElementById('calendarDays');
    const currentMonthElement = document.getElementById('currentMonth');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    const visitDateInput = document.getElementById('visit_date');
    
    // Cargar fechas disponibles al iniciar
    loadAvailableDates();
    
    // Event listeners
    prevMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });
    
    nextMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });
    
    // Función para cargar fechas disponibles
    function loadAvailableDates() {
        fetch('{{ route("visits.available-dates") }}')
            .then(response => response.json())
            .then(data => {
                availableDates = data.available_dates;
                occupiedDates = data.occupied_dates;
                renderCalendar();
            })
            .catch(error => {
                console.error('Error cargando fechas disponibles:', error);
                renderCalendar(); // Renderizar sin datos
            });
    }
    
    // Función para renderizar el calendario
    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        // Actualizar título del mes
        const monthNames = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        currentMonthElement.textContent = `${monthNames[month]} ${year}`;
        
        // Obtener primer día del mes y último día
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());
        
        // Limpiar calendario
        calendarDays.innerHTML = '';
        
        // Generar días del calendario
        for (let i = 0; i < 42; i++) { // 6 semanas * 7 días
            const currentDay = new Date(startDate);
            currentDay.setDate(startDate.getDate() + i);
            
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.textContent = currentDay.getDate();
            
            const dateString = currentDay.toISOString().split('T')[0];
            const today = new Date().toISOString().split('T')[0];
            
            // Determinar el estado del día
            if (currentDay.getMonth() !== month) {
                // Día de otro mes
                dayElement.classList.add('disabled');
            } else if (dateString < today) {
                // Día pasado
                dayElement.classList.add('past');
            } else if (currentDay.getDay() === 0 || currentDay.getDay() === 6) {
                // Fines de semana (domingo = 0, sábado = 6)
                dayElement.classList.add('weekend');
            } else if (occupiedDates.includes(dateString)) {
                // Día ocupado
                dayElement.classList.add('occupied');
            } else {
                // Día disponible
                dayElement.classList.add('available');
                dayElement.addEventListener('click', () => selectDate(dateString, dayElement));
            }
            
            // Marcar día actual
            if (dateString === today) {
                dayElement.classList.add('today');
            }
            
            // Marcar día seleccionado
            if (dateString === selectedDate) {
                dayElement.classList.add('selected');
            }
            
            calendarDays.appendChild(dayElement);
        }
    }
    
    // Función para seleccionar fecha
    function selectDate(dateString, dayElement) {
        // Remover selección anterior
        const previousSelected = calendarDays.querySelector('.selected');
        if (previousSelected) {
            previousSelected.classList.remove('selected');
        }
        
        // Seleccionar nueva fecha
        selectedDate = dateString;
        dayElement.classList.add('selected');
        
        // Actualizar input oculto
        visitDateInput.value = dateString;
        
        // Mostrar fecha seleccionada
        const date = new Date(dateString);
        const formattedDate = date.toLocaleDateString('es-ES', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Crear o actualizar notificación
        let notification = document.getElementById('dateNotification');
        if (!notification) {
            notification = document.createElement('div');
            notification.id = 'dateNotification';
            notification.className = 'alert alert-info mt-2';
            notification.innerHTML = `
                <i class="fas fa-calendar-check me-2"></i>
                <strong>Fecha seleccionada:</strong> ${formattedDate}
            `;
            calendarDays.parentNode.parentNode.appendChild(notification);
        } else {
            notification.innerHTML = `
                <i class="fas fa-calendar-check me-2"></i>
                <strong>Fecha seleccionada:</strong> ${formattedDate}
            `;
        }
    }
    
    // Validación de hora de salida después de llegada
    const arrivalTime = document.getElementById('arrival_time');
    const departureTime = document.getElementById('departure_time');
    
    if (arrivalTime && departureTime) {
        arrivalTime.addEventListener('change', function() {
            departureTime.min = this.value;
        });
    }
    
    // ===== RELOJ CIRCULAR =====
    const clock = document.getElementById('clock');
    const hourHand = document.getElementById('hourHand');
    const minuteHand = document.getElementById('minuteHand');
    const secondHand = document.getElementById('secondHand');
    const arrivalTimeInput = document.getElementById('arrivalTimeInput');
    const departureTimeInput = document.getElementById('departureTimeInput');
    const setArrivalBtn = document.getElementById('setArrivalBtn');
    const setDepartureBtn = document.getElementById('setDepartureBtn');
    const resetClockBtn = document.getElementById('resetClockBtn');
    
    let isDragging = false;
    let currentMode = 'arrival'; // 'arrival' o 'departure'
    let currentHour = 8;
    let currentMinute = 0;
    
    // Inicializar reloj
    function initClock() {
        updateClockDisplay();
        updateHands();
        
        // Event listeners para el reloj
        clock.addEventListener('mousedown', startDragging);
        clock.addEventListener('touchstart', startDragging);
        document.addEventListener('mousemove', drag);
        document.addEventListener('touchmove', drag);
        document.addEventListener('mouseup', stopDragging);
        document.addEventListener('touchend', stopDragging);
        
        // Event listeners para botones
        setArrivalBtn.addEventListener('click', () => setMode('arrival'));
        setDepartureBtn.addEventListener('click', () => setMode('departure'));
        resetClockBtn.addEventListener('click', resetClock);
        
        // Event listeners para campos de tiempo
        arrivalTimeInput.addEventListener('change', handleArrivalTimeChange);
        departureTimeInput.addEventListener('change', handleDepartureTimeChange);
    }
    
    // Iniciar arrastre
    function startDragging(e) {
        e.preventDefault();
        isDragging = true;
        clock.classList.add('active');
    }
    
    // Arrastrar manecillas
    function drag(e) {
        if (!isDragging) return;
        
        e.preventDefault();
        const rect = clock.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        
        let clientX, clientY;
        if (e.type === 'mousemove') {
            clientX = e.clientX;
            clientY = e.clientY;
        } else {
            clientX = e.touches[0].clientX;
            clientY = e.touches[0].clientY;
        }
        
        const deltaX = clientX - centerX;
        const deltaY = clientY - centerY;
        const angle = Math.atan2(deltaY, deltaX) * 180 / Math.PI;
        
        // Convertir ángulo a hora y minutos
        let hour = Math.round((angle + 90) / 30) % 12;
        if (hour <= 0) hour = 12;
        
        let minute = Math.round((angle + 90) / 6) % 60;
        if (minute < 0) minute += 60;
        
        currentHour = hour;
        currentMinute = minute;
        
        updateHands();
        updateClockDisplay();
    }
    
    // Detener arrastre
    function stopDragging() {
        isDragging = false;
        clock.classList.remove('active');
        
        // Establecer la hora según el modo actual
        if (currentMode === 'arrival') {
            setArrivalTime();
        } else {
            setDepartureTime();
        }
    }
    
    // Actualizar manecillas
    function updateHands() {
        const hourAngle = (currentHour % 12) * 30 + currentMinute * 0.5;
        const minuteAngle = currentMinute * 6;
        const secondAngle = 0; // Por ahora no usamos segundos
        
        hourHand.style.transform = `rotate(${hourAngle}deg)`;
        minuteHand.style.transform = `rotate(${minuteAngle}deg)`;
        secondHand.style.transform = `rotate(${secondAngle}deg)`;
    }
    
    // Actualizar display de tiempo
    function updateClockDisplay() {
        const timeString = `${currentHour.toString().padStart(2, '0')}:${currentMinute.toString().padStart(2, '0')}`;
        
        if (currentMode === 'arrival') {
            arrivalTimeInput.value = timeString;
        } else {
            departureTimeInput.value = timeString;
        }
    }
    
    // Establecer modo
    function setMode(mode) {
        currentMode = mode;
        clock.classList.remove('setting-arrival', 'setting-departure');
        
        if (mode === 'arrival') {
            clock.classList.add('setting-arrival');
            setArrivalBtn.classList.add('active');
            setDepartureBtn.classList.remove('active');
        } else {
            clock.classList.add('setting-departure');
            setDepartureBtn.classList.add('active');
            setArrivalBtn.classList.remove('active');
        }
    }
    
    // Establecer hora de llegada
    function setArrivalTime() {
        const timeString = `${currentHour.toString().padStart(2, '0')}:${currentMinute.toString().padStart(2, '0')}`;
        arrivalTimeInput.value = timeString;
        document.getElementById('arrival_time').value = timeString;
        
        // Validar que la hora de salida sea después de la llegada
        const departureInput = document.getElementById('departure_time');
        if (departureInput.value && timeString >= departureInput.value) {
            // Ajustar automáticamente la hora de salida
            const [hour, minute] = timeString.split(':').map(Number);
            const newDepartureHour = hour + 1;
            const newDepartureTime = `${newDepartureHour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
            departureInput.value = newDepartureTime;
            departureTimeInput.value = newDepartureTime; // Actualizar el campo de entrada
        }
    }
    
    // Establecer hora de salida
    function setDepartureTime() {
        const timeString = `${currentHour.toString().padStart(2, '0')}:${currentMinute.toString().padStart(2, '0')}`;
        departureTimeInput.value = timeString;
        document.getElementById('departure_time').value = timeString;
    }
    
    // Manejar cambio en campo de llegada
    function handleArrivalTimeChange() {
        const timeValue = arrivalTimeInput.value;
        if (timeValue) {
            const [hours, minutes] = timeValue.split(':').map(Number);
            
            // Actualizar variables del reloj
            currentHour = hours;
            currentMinute = minutes;
            
            // Actualizar manecillas del reloj
            updateHands();
            
            // Actualizar input oculto
            document.getElementById('arrival_time').value = timeValue;
            
            // Validar que la hora de salida sea después de la llegada
            const departureValue = departureTimeInput.value;
            if (departureValue && timeValue >= departureValue) {
                // Ajustar automáticamente la hora de salida
                const newDepartureHour = hours + 1;
                const newDepartureTime = `${newDepartureHour.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
                departureTimeInput.value = newDepartureTime;
                document.getElementById('departure_time').value = newDepartureTime;
            }
        }
    }
    
    // Manejar cambio en campo de salida
    function handleDepartureTimeChange() {
        const timeValue = departureTimeInput.value;
        if (timeValue) {
            const [hours, minutes] = timeValue.split(':').map(Number);
            
            // Actualizar variables del reloj
            currentHour = hours;
            currentMinute = minutes;
            
            // Actualizar manecillas del reloj
            updateHands();
            
            // Actualizar input oculto
            document.getElementById('departure_time').value = timeValue;
        }
    }
    
    // Reiniciar reloj
    function resetClock() {
        currentHour = 8;
        currentMinute = 0;
        currentMode = 'arrival';
        
        updateHands();
        updateClockDisplay();
        
        // Restablecer valores por defecto
        document.getElementById('arrival_time').value = '08:00';
        document.getElementById('departure_time').value = '09:00';
        arrivalTimeInput.value = '08:00';
        departureTimeInput.value = '09:00';
        
        // Restablecer estados visuales
        clock.classList.remove('setting-arrival', 'setting-departure', 'active');
        setArrivalBtn.classList.remove('active');
        setDepartureBtn.classList.remove('active');
    }
    
    // Inicializar reloj cuando el DOM esté listo
    if (clock) {
        initClock();
        setMode('arrival'); // Modo inicial
    }
     
     // ===== REQUISITOS OBLIGATORIOS =====
     // Mapeo de actividades con sus requisitos obligatorios
     const activityRequirements = {
         1: "• Ropa cómoda y cerrada\n• Zapatos cerrados\n• Camisa manga larga\n• Gorra para protección solar\n• Agua potable\n• Protector solar",
         2: "• Botas industriales o de goma (OBLIGATORIAS)\n• Ropa de trabajo\n• Protección personal\n• Agua potable\n• Protector solar",
         3: "• Ropa cómoda y cerrada\n• Zapatos cerrados\n• Gorra para protección solar\n• Agua potable\n• Protector solar\n• Repelente de insectos",
         4: "• Botas industriales o de goma (OBLIGATORIAS)\n• Ropa de trabajo\n• Agua potable\n• Protector solar",
         5: "• Ropa cómoda y cerrada\n• Zapatos cerrados\n• Agua potable\n• Cuaderno y lápiz",
         6: "• Ropa cómoda y cerrada\n• Zapatos cerrados\n• Agua potable\n• Cuaderno y lápiz",
         7: "• Batas de laboratorio (OBLIGATORIAS)\n• Ropa cómoda y cerrada\n• Zapatos cerrados\n• Agua potable\n• Cuaderno y lápiz",
         8: "• Batas de laboratorio (OBLIGATORIAS)\n• Ropa cómoda y cerrada\n• Zapatos cerrados\n• Agua potable\n• Cuaderno y lápiz",
         9: "• Ropa cómoda y cerrada\n• Zapatos cerrados\n• Gorra para protección solar\n• Agua potable\n• Protector solar\n• Cámara fotográfica (opcional)"
     };
     
     // Función para actualizar requisitos obligatorios
     function updateRequirements() {
         const selectedActivities = document.querySelectorAll('input[name="activities[]"]:checked');
         const requirementsContainer = document.getElementById('requirements-container');
         const requirementsField = document.getElementById('special_requirements');
         let requirementsText = '';
         
         if (selectedActivities.length === 0) {
             requirementsContainer.innerHTML = `
                 <div class="alert alert-info">
                     <i class="fas fa-info-circle me-2"></i>
                     Los requisitos obligatorios serán determinados por el administrador según las actividades que describas.
                 </div>
             `;
             requirementsField.value = '';
         } else {
             let containerHTML = `
                 <div class="alert alert-info mb-3">
                     <i class="fas fa-info-circle me-2"></i>
                     <strong>Requisitos obligatorios para las actividades seleccionadas:</strong>
                 </div>
             `;
             
             selectedActivities.forEach((checkbox, index) => {
                 const activityId = checkbox.value;
                 const activityLabel = checkbox.nextElementSibling.querySelector('strong').textContent;
                 
                 if (activityRequirements[activityId]) {
                     // Agregar al texto para el campo oculto
                     if (index > 0) {
                         requirementsText += '\n\n';
                     }
                     requirementsText += `📋 ${activityLabel}:\n${activityRequirements[activityId]}`;
                     
                     // Crear cuadro individual para cada actividad
                     containerHTML += `
                         <div class="requirement-card">
                             <div class="requirement-header">
                                 <i class="fas fa-clipboard-list"></i>
                                 ${activityLabel}
                             </div>
                             <div class="requirement-content">
                                 ${activityRequirements[activityId].replace(/\n/g, '<br>')}
                             </div>
                         </div>
                     `;
                 }
             });
             
             requirementsContainer.innerHTML = containerHTML;
             requirementsField.value = requirementsText;
         }
     }
     
     // Agregar event listeners a todos los checkboxes de actividades
     const activityCheckboxes = document.querySelectorAll('input[name="activities[]"]');
     const otherActivitiesCheckbox = document.getElementById('other_activities_check');
     const otherActivitiesField = document.getElementById('other_activities');
     
     // Event listeners para checkboxes de actividades
     activityCheckboxes.forEach(checkbox => {
         checkbox.addEventListener('change', updateRequirements);
     });
     
     // Event listener para checkbox de otras actividades
     if (otherActivitiesCheckbox) {
         otherActivitiesCheckbox.addEventListener('change', function() {
             if (this.checked) {
                 otherActivitiesField.parentElement.style.display = 'block';
                 otherActivitiesField.required = true;
             } else {
                 otherActivitiesField.parentElement.style.display = 'none';
                 otherActivitiesField.required = false;
                 otherActivitiesField.value = '';
             }
             updateRequirements();
         });
     }

     // Event listener para el checkbox de servicio de restaurante
     const restaurantServiceCheckbox = document.getElementById('restaurant_service');
     const restaurantFieldsContainer = document.getElementById('restaurant-fields');

     if (restaurantServiceCheckbox) {
         restaurantServiceCheckbox.addEventListener('change', function() {
             if (this.checked) {
                 restaurantFieldsContainer.style.display = 'block';
                 document.getElementById('restaurant_participants').required = true;
             } else {
                 restaurantFieldsContainer.style.display = 'none';
                 document.getElementById('restaurant_participants').required = false;
                 document.getElementById('restaurant_participants').value = '';
                 document.getElementById('restaurant_notes').value = '';
             }
         });
     }
     
     // Inicializar requisitos
     updateRequirements();
});
</script>
@endpush
