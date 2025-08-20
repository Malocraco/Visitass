@extends('layouts.app')

@section('title', 'Solicitar Visita - Sistema de Visitas')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-plus me-2"></i>
                        Solicitud de Visita a la Institución
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

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
                                <input type="date" 
                                       class="form-control @error('visit_date') is-invalid @enderror" 
                                       id="visit_date" 
                                       name="visit_date" 
                                       value="{{ old('visit_date') }}" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       required>
                                @error('visit_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="visit_time" class="form-label">
                                    <i class="fas fa-clock me-1"></i>
                                    Horario de Visita *
                                </label>
                                <select class="form-select @error('visit_time') is-invalid @enderror" 
                                        id="visit_time" 
                                        name="visit_time" 
                                        required>
                                    <option value="">Selecciona un horario</option>
                                    @foreach($schedules as $schedule)
                                        <option value="{{ $schedule->time_slot }}" 
                                                {{ old('visit_time') == $schedule->time_slot ? 'selected' : '' }}>
                                            {{ $schedule->time_slot }} ({{ $schedule->duration }} minutos)
                                        </option>
                                    @endforeach
                                </select>
                                @error('visit_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="group_size" class="form-label">
                                    <i class="fas fa-users me-1"></i>
                                    Número de Personas *
                                </label>
                                <input type="number" 
                                       class="form-control @error('group_size') is-invalid @enderror" 
                                       id="group_size" 
                                       name="group_size" 
                                       value="{{ old('group_size') }}" 
                                       min="1" 
                                       max="100" 
                                       required>
                                @error('group_size')
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
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="contact_person" class="form-label">
                                    <i class="fas fa-user me-1"></i>
                                    Persona de Contacto *
                                </label>
                                <input type="text" 
                                       class="form-control @error('contact_person') is-invalid @enderror" 
                                       id="contact_person" 
                                       name="contact_person" 
                                       value="{{ old('contact_person') }}" 
                                       required>
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="contact_phone" class="form-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Teléfono de Contacto *
                                </label>
                                <input type="tel" 
                                       class="form-control @error('contact_phone') is-invalid @enderror" 
                                       id="contact_phone" 
                                       name="contact_phone" 
                                       value="{{ old('contact_phone') }}" 
                                       required>
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="contact_email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>
                                    Email de Contacto *
                                </label>
                                <input type="email" 
                                       class="form-control @error('contact_email') is-invalid @enderror" 
                                       id="contact_email" 
                                       name="contact_email" 
                                       value="{{ old('contact_email') }}" 
                                       required>
                                @error('contact_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="institution_name" class="form-label">
                                    <i class="fas fa-building me-1"></i>
                                    Nombre de la Institución *
                                </label>
                                <input type="text" 
                                       class="form-control @error('institution_name') is-invalid @enderror" 
                                       id="institution_name" 
                                       name="institution_name" 
                                       value="{{ old('institution_name') }}" 
                                       required>
                                @error('institution_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="institution_type" class="form-label">
                                    <i class="fas fa-tag me-1"></i>
                                    Tipo de Institución *
                                </label>
                                <select class="form-select @error('institution_type') is-invalid @enderror" 
                                        id="institution_type" 
                                        name="institution_type" 
                                        required>
                                    <option value="">Selecciona el tipo</option>
                                    <option value="empresa" {{ old('institution_type') == 'empresa' ? 'selected' : '' }}>Empresa</option>
                                    <option value="universidad" {{ old('institution_type') == 'universidad' ? 'selected' : '' }}>Universidad</option>
                                    <option value="colegio" {{ old('institution_type') == 'colegio' ? 'selected' : '' }}>Colegio</option>
                                    <option value="otro" {{ old('institution_type') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('institution_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Actividades de Interés -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-list-check me-2"></i>
                                    Actividades de Interés
                                </h5>
                                <p class="text-muted">Selecciona las actividades que te interesan para la visita:</p>
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
                                </div>
                                @error('activities')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Información de Transporte -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-car me-2"></i>
                                    Información de Transporte
                                </h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="transportation_method" class="form-label">
                                    <i class="fas fa-route me-1"></i>
                                    Método de Transporte *
                                </label>
                                <select class="form-select @error('transportation_method') is-invalid @enderror" 
                                        id="transportation_method" 
                                        name="transportation_method" 
                                        required>
                                    <option value="">Selecciona el método</option>
                                    <option value="bus" {{ old('transportation_method') == 'bus' ? 'selected' : '' }}>Bus</option>
                                    <option value="carro_particular" {{ old('transportation_method') == 'carro_particular' ? 'selected' : '' }}>Carro Particular</option>
                                    <option value="taxi" {{ old('transportation_method') == 'taxi' ? 'selected' : '' }}>Taxi</option>
                                    <option value="transporte_publico" {{ old('transportation_method') == 'transporte_publico' ? 'selected' : '' }}>Transporte Público</option>
                                    <option value="otro" {{ old('transportation_method') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('transportation_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="arrival_time" class="form-label">
                                    <i class="fas fa-clock me-1"></i>
                                    Hora de Llegada *
                                </label>
                                <input type="time" 
                                       class="form-control @error('arrival_time') is-invalid @enderror" 
                                       id="arrival_time" 
                                       name="arrival_time" 
                                       value="{{ old('arrival_time') }}" 
                                       required>
                                @error('arrival_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="departure_time" class="form-label">
                                    <i class="fas fa-clock me-1"></i>
                                    Hora de Salida *
                                </label>
                                <input type="time" 
                                       class="form-control @error('departure_time') is-invalid @enderror" 
                                       id="departure_time" 
                                       name="departure_time" 
                                       value="{{ old('departure_time') }}" 
                                       required>
                                @error('departure_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Requisitos Especiales -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-star me-2"></i>
                                    Requisitos Especiales
                                </h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="special_requirements" class="form-label">
                                    <i class="fas fa-clipboard-list me-1"></i>
                                    Requisitos Especiales
                                </label>
                                <textarea class="form-control @error('special_requirements') is-invalid @enderror" 
                                          id="special_requirements" 
                                          name="special_requirements" 
                                          rows="3" 
                                          placeholder="Describe cualquier requisito especial...">{{ old('special_requirements') }}</textarea>
                                @error('special_requirements')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dietary_restrictions" class="form-label">
                                    <i class="fas fa-utensils me-1"></i>
                                    Restricciones Alimentarias
                                </label>
                                <textarea class="form-control @error('dietary_restrictions') is-invalid @enderror" 
                                          id="dietary_restrictions" 
                                          name="dietary_restrictions" 
                                          rows="3" 
                                          placeholder="Alergias, dietas especiales...">{{ old('dietary_restrictions') }}</textarea>
                                @error('dietary_restrictions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="accessibility_needs" class="form-label">
                                    <i class="fas fa-wheelchair me-1"></i>
                                    Necesidades de Accesibilidad
                                </label>
                                <textarea class="form-control @error('accessibility_needs') is-invalid @enderror" 
                                          id="accessibility_needs" 
                                          name="accessibility_needs" 
                                          rows="3" 
                                          placeholder="Necesidades especiales de movilidad...">{{ old('accessibility_needs') }}</textarea>
                                @error('accessibility_needs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contacto de Emergencia -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Contacto de Emergencia
                                </h5>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="emergency_contact_name" class="form-label">
                                    <i class="fas fa-user me-1"></i>
                                    Nombre del Contacto de Emergencia *
                                </label>
                                <input type="text" 
                                       class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                       id="emergency_contact_name" 
                                       name="emergency_contact_name" 
                                       value="{{ old('emergency_contact_name') }}" 
                                       required>
                                @error('emergency_contact_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="emergency_contact_phone" class="form-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Teléfono de Emergencia *
                                </label>
                                <input type="tel" 
                                       class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                       id="emergency_contact_phone" 
                                       name="emergency_contact_phone" 
                                       value="{{ old('emergency_contact_phone') }}" 
                                       required>
                                @error('emergency_contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="emergency_contact_relationship" class="form-label">
                                    <i class="fas fa-heart me-1"></i>
                                    Relación con el Contacto *
                                </label>
                                <input type="text" 
                                       class="form-control @error('emergency_contact_relationship') is-invalid @enderror" 
                                       id="emergency_contact_relationship" 
                                       name="emergency_contact_relationship" 
                                       value="{{ old('emergency_contact_relationship') }}" 
                                       placeholder="Padre, madre, tutor..."
                                       required>
                                @error('emergency_contact_relationship')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
    // Validación de fecha mínima
    const visitDate = document.getElementById('visit_date');
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    visitDate.min = tomorrow.toISOString().split('T')[0];

    // Validación de hora de salida después de llegada
    const arrivalTime = document.getElementById('arrival_time');
    const departureTime = document.getElementById('departure_time');
    
    arrivalTime.addEventListener('change', function() {
        departureTime.min = this.value;
    });
});
</script>
@endpush
