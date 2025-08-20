<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Helpers\SettingsHelper;

class SettingsController extends Controller
{
    /**
     * Verificar permisos de SuperAdmin y Administrador
     */
    private function checkAdminPermissions()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        return null;
    }

    /**
     * Mostrar página de configuración de cuenta
     */
    public function index()
    {
        $permissionCheck = $this->checkAdminPermissions();
        if ($permissionCheck) {
            return $permissionCheck;
        }

        $user = auth()->user();
        
        return view('admin.settings.index', compact('user'));
    }

    /**
     * Actualizar información del perfil
     */
    public function updateProfile(Request $request)
    {
        $permissionCheck = $this->checkAdminPermissions();
        if ($permissionCheck) {
            return $permissionCheck;
        }

        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'institution' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'institution' => $request->institution,
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Información del perfil actualizada exitosamente.');
    }

    /**
     * Cambiar contraseña
     */
    public function changePassword(Request $request)
    {
        $permissionCheck = $this->checkAdminPermissions();
        if ($permissionCheck) {
            return $permissionCheck;
        }

        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.current_password' => 'La contraseña actual es incorrecta.',
            'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ]);

        $user = auth()->user();
        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Contraseña cambiada exitosamente.');
    }




}
