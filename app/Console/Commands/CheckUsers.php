<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Http\Middleware\CheckRole;

class CheckUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check users and their roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::with('roles')->get();
        
        $this->info('Usuarios y sus roles:');
        $this->info('==================');
        
        foreach ($users as $user) {
            $roles = $user->roles->pluck('name')->implode(', ');
            $this->line("{$user->name} ({$user->email}) - Roles: {$roles}");
            
            // Verificar métodos de roles
            $this->line("  - isSuperAdmin(): " . ($user->isSuperAdmin() ? 'true' : 'false'));
            $this->line("  - isAdmin(): " . ($user->isAdmin() ? 'true' : 'false'));
            $this->line("  - isVisitor(): " . ($user->isVisitor() ? 'true' : 'false'));
            $this->line("  - hasRole('administrador'): " . ($user->hasRole('administrador') ? 'true' : 'false'));
            $this->line("  - hasAnyRole(['administrador']): " . ($user->hasAnyRole(['administrador']) ? 'true' : 'false'));
            $this->line("  - hasAnyRole(['superadmin', 'administrador']): " . ($user->hasAnyRole(['superadmin', 'administrador']) ? 'true' : 'false'));
            $this->line("");
        }
        
        return 0;
    }
}
