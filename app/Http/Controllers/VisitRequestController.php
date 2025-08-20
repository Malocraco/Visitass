<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\VisitActivity;
use App\Models\VisitSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VisitRequestController extends Controller
{
    /**
     * Mostrar el formulario de solicitud de visita
     */
    public function showForm()
    {
        // Obtener actividades disponibles
        $activities = VisitActivity::where('is_active', true)->get();
        
        // Obtener horarios disponibles
        $schedules = VisitSchedule::where('is_active', true)->get();
        
        return view('visits.request-form', compact('activities', 'schedules'));
    }

    /**
     * Procesar la solicitud de visita
     */
    public function submitRequest(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'visit_date' => 'required|date|after:today',
            'visit_time' => 'required|string',
            'group_size' => 'required|integer|min:1|max:100',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email',
            'institution_name' => 'required|string|max:255',
            'institution_type' => 'required|string|in:empresa,universidad,colegio,otro',
            'visit_purpose' => 'required|string|max:1000',
            'special_requirements' => 'nullable|string|max:1000',
            'activities' => 'required|array|min:1',
            'activities.*' => 'exists:visit_activities,id',
            'transportation_method' => 'required|string|in:bus,carro_particular,taxi,transporte_publico,otro',
            'arrival_time' => 'required|string',
            'departure_time' => 'required|string|after:arrival_time',
            'dietary_restrictions' => 'nullable|string|max:500',
            'accessibility_needs' => 'nullable|string|max:500',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'emergency_contact_relationship' => 'required|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            // Crear la visita
            $visit = Visit::create([
                'user_id' => Auth::id(),
                'visit_date' => $request->visit_date,
                'visit_time' => $request->visit_time,
                'group_size' => $request->group_size,
                'contact_person' => $request->contact_person,
                'contact_phone' => $request->contact_phone,
                'contact_email' => $request->contact_email,
                'institution_name' => $request->institution_name,
                'institution_type' => $request->institution_type,
                'visit_purpose' => $request->visit_purpose,
                'special_requirements' => $request->special_requirements,
                'transportation_method' => $request->transportation_method,
                'arrival_time' => $request->arrival_time,
                'departure_time' => $request->departure_time,
                'dietary_restrictions' => $request->dietary_restrictions,
                'accessibility_needs' => $request->accessibility_needs,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'emergency_contact_relationship' => $request->emergency_contact_relationship,
                'status' => 'pending',
                'requested_at' => now(),
            ]);

            // Asociar actividades seleccionadas
            $visit->activities()->attach($request->activities);

            // Crear log de la solicitud
            $visit->logs()->create([
                'action' => 'request_created',
                'description' => 'Solicitud de visita creada',
                'user_id' => Auth::id(),
                'details' => json_encode([
                    'visit_date' => $request->visit_date,
                    'group_size' => $request->group_size,
                    'activities_count' => count($request->activities)
                ])
            ]);

            DB::commit();

            return redirect()->route('dashboard.visitor')
                ->with('success', '¡Solicitud de visita enviada exitosamente! Será revisada por nuestros administradores.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Error al enviar la solicitud. Por favor, inténtalo de nuevo.');
        }
    }

    /**
     * Mostrar las solicitudes del usuario
     */
    public function myRequests()
    {
        $visits = Auth::user()->visits()
            ->with(['activities', 'logs'])
            ->latest()
            ->paginate(10);

        return view('visits.my-requests', compact('visits'));
    }

    /**
     * Mostrar detalles de una solicitud específica
     */
    public function showRequest($id)
    {
        $visit = Auth::user()->visits()
            ->with(['activities', 'logs', 'messages'])
            ->findOrFail($id);

        return view('visits.request-details', compact('visit'));
    }
}
