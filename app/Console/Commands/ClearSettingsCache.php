<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\SettingsHelper;

class ClearSettingsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar la caché de configuraciones del sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        SettingsHelper::clearCache();
        
        $this->info('✅ Caché de configuraciones limpiada exitosamente.');
        
        return Command::SUCCESS;
    }
}
