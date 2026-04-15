<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Festivo;

class SyncFestivos extends Command
{
    protected $signature = 'festivos:sync {year? : Año a sincronizar (por defecto el año actual y el siguiente)}';
    protected $description = 'Sincroniza los festivos de Colombia desde la API de Nager.Date';

    public function handle()
    {
        $year = $this->argument('year');
        $years = $year ? [(int) $year] : [now()->year, now()->year + 1];

        foreach ($years as $y) {
            $this->syncYear($y);
        }

        $this->info('Festivos sincronizados correctamente.');
    }

    private function syncYear(int $year): void
    {
        $this->line("Sincronizando festivos {$year}...");

        $response = Http::timeout(10)->get("https://date.nager.at/api/v3/PublicHolidays/{$year}/CO");

        if (!$response->successful()) {
            $this->error("No se pudo conectar a la API para el año {$year}.");
            return;
        }

        $festivos = $response->json();
        $insertados = 0;
        $omitidos = 0;

        foreach ($festivos as $festivo) {
            $fecha = $festivo['date'];
            if (!Festivo::where('fecha', $fecha)->exists()) {
                Festivo::create(['fecha' => $fecha]);
                $insertados++;
            } else {
                $omitidos++;
            }
        }

        $this->line("  Año {$year}: {$insertados} insertados, {$omitidos} ya existían.");
    }
}
