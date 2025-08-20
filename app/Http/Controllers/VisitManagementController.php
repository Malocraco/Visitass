<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\User;
use App\Models\VisitActivity;
use App\Models\VisitSchedule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VisitManagementController extends Controller
{
    /**
     * Mostrar solicitudes pendientes
     */
    public function pendingRequests()
    {
        $pendingVisits = Visit::with(['user', 'activities'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.visits.pending', compact('pendingVisits'));
    }

    /**
     * Mostrar todas las visitas
     */
    public function allVisits()
    {
        $visits = Visit::with(['user', 'activities'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Visit::count(),
            'pending' => Visit::where('status', 'pending')->count(),
            'approved' => Visit::where('status', 'approved')->count(),
            'completed' => Visit::where('status', 'completed')->count(),
            'rejected' => Visit::where('status', 'rejected')->count(),
        ];

        return view('admin.visits.all', compact('visits', 'stats'));
    }

    /**
     * Mostrar visitas aprobadas (para Administrador)
     */
    public function approvedVisits()
    {
        $approvedVisits = Visit::with(['user', 'activities'])
            ->where('status', 'approved')
            ->orderBy('confirmed_date', 'asc')
            ->paginate(15);

        $stats = [
            'total_approved' => Visit::where('status', 'approved')->count(),
            'today_visits' => Visit::where('status', 'approved')
                ->whereDate('confirmed_date', today())
                ->count(),
            'this_week_visits' => Visit::where('status', 'approved')
                ->whereBetween('confirmed_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count(),
            'completed_visits' => Visit::where('status', 'completed')->count(),
        ];

        return view('admin.visits.approved', compact('approvedVisits', 'stats'));
    }

    /**
     * Mostrar reportes
     */
    public function reports()
    {
        // Estadísticas generales
        $totalVisits = Visit::count();
        $thisMonthVisits = Visit::whereMonth('created_at', Carbon::now()->month)->count();
        $thisYearVisits = Visit::whereYear('created_at', Carbon::now()->year)->count();

        // Visitas por estado
        $visitsByStatus = Visit::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Visitas por mes (últimos 12 meses)
        $visitsByMonth = Visit::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month', 'year')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Top instituciones visitantes
        $topInstitutions = Visit::with('user')
            ->select('user_id', DB::raw('count(*) as total'))
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        return view('admin.visits.reports', compact(
            'totalVisits',
            'thisMonthVisits',
            'thisYearVisits',
            'visitsByStatus',
            'visitsByMonth',
            'topInstitutions'
        ));
    }

    /**
     * Mostrar calendario de visitas
     */
    public function calendar(Request $request)
    {
        $year = (int) $request->get('year', Carbon::now()->year);
        $month = (int) $request->get('month', Carbon::now()->month);
        
        // Validar y ajustar mes/año si es necesario
        if ($month < 1) {
            $month = 12;
            $year--;
        } elseif ($month > 12) {
            $month = 1;
            $year++;
        }
        
        // Obtener todas las visitas del mes seleccionado
        $visits = Visit::where(function($query) use ($year, $month) {
                $query->whereYear('preferred_date', $year)
                      ->whereMonth('preferred_date', $month);
            })
            ->orWhere(function($query) use ($year, $month) {
                $query->whereYear('confirmed_date', $year)
                      ->whereMonth('confirmed_date', $month);
            })
            ->with(['user', 'activities'])
            ->get();

        // Crear array de eventos para el calendario
        $events = [];
        
        foreach ($visits as $visit) {
            $status = $visit->status;
            $color = '';
            $title = '';
            
            // Todas las visitas se muestran en amarillo (días agendados)
            $color = '#ffc107'; // Amarillo para todas las visitas
            $title = "Visita #{$visit->id} - {$visit->user->name} ({$status})";
            
            $eventDate = $visit->confirmed_date ?? $visit->preferred_date;
            $events[] = [
                'id' => $visit->id,
                'title' => $title,
                'start' => $eventDate->format('Y-m-d'),
                'color' => $color,
                'visit' => $visit
            ];
        }

        // Días no disponibles (fines de semana, días festivos y días pasados)
        $unavailableDays = $this->getUnavailableDays($year, $month);
        
        return view('admin.visits.calendar', compact('events', 'unavailableDays', 'year', 'month'));
    }

    /**
     * Obtener días no disponibles (fines de semana, días festivos y días pasados)
     */
    private function getUnavailableDays($year, $month)
    {
        $unavailableDays = [];
        
        // Obtener el primer y último día del mes
        $firstDay = Carbon::create($year, $month, 1);
        $lastDay = $firstDay->copy()->endOfMonth();
        
        // Días festivos (puedes agregar más según necesites)
        $holidays = [
            '01-01', // Año Nuevo
            '05-01', // Día del Trabajo
            '07-20', // Independencia
            '08-07', // Batalla de Boyacá
            '12-25', // Navidad
        ];
        
        $currentDay = $firstDay->copy();
        $today = Carbon::today();
        
        while ($currentDay <= $lastDay) {
            $dayOfWeek = $currentDay->dayOfWeek;
            $dateString = $currentDay->format('m-d');
            
            // Días pasados (antes de hoy)
            if ($currentDay->lt($today)) {
                $unavailableDays[] = [
                    'date' => $currentDay->format('Y-m-d'),
                    'reason' => 'Día pasado',
                    'type' => 'past'
                ];
            }
            // Fines de semana (0 = domingo, 6 = sábado)
            elseif ($dayOfWeek == 0 || $dayOfWeek == 6) {
                $unavailableDays[] = [
                    'date' => $currentDay->format('Y-m-d'),
                    'reason' => 'Fin de semana',
                    'type' => 'weekend'
                ];
            }
            // Días festivos
            elseif (in_array($dateString, $holidays)) {
                $unavailableDays[] = [
                    'date' => $currentDay->format('Y-m-d'),
                    'reason' => 'Día festivo',
                    'type' => 'holiday'
                ];
            }
            
            $currentDay->addDay();
        }
        
        return $unavailableDays;
    }

    /**
     * Aprobar una visita
     */
    public function approveVisit(Request $request, $id)
    {
        $visit = Visit::findOrFail($id);
        
        $visit->update([
            'status' => 'approved',
            'approved_at' => Carbon::now(),
            'approved_by' => auth()->id(),
            'admin_notes' => $request->input('admin_notes', '')
        ]);

        return redirect()->back()->with('success', 'Visita aprobada exitosamente.');
    }

    /**
     * Rechazar una visita
     */
    public function rejectVisit(Request $request, $id)
    {
        $visit = Visit::findOrFail($id);
        
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $visit->update([
            'status' => 'rejected',
            'rejected_at' => Carbon::now(),
            'rejected_by' => auth()->id(),
            'rejection_reason' => $request->rejection_reason,
            'admin_notes' => $request->input('admin_notes', '')
        ]);

        return redirect()->back()->with('success', 'Visita rechazada exitosamente.');
    }

    /**
     * Marcar visita como completada
     */
    public function completeVisit(Request $request, $id)
    {
        $visit = Visit::findOrFail($id);
        
        $visit->update([
            'status' => 'completed',
            'completed_at' => Carbon::now(),
            'completed_by' => auth()->id(),
            'completion_notes' => $request->input('completion_notes', '')
        ]);

        return redirect()->back()->with('success', 'Visita marcada como completada.');
    }

    /**
     * Mostrar detalles de una visita
     */
    public function visitDetails($id)
    {
        $visit = Visit::with(['user', 'activities', 'attendees'])
            ->findOrFail($id);

        return view('admin.visits.details', compact('visit'));
    }
}
