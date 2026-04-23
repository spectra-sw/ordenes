<?php

if (!function_exists('vasset')) {
    /**
     * Genera una URL de asset con query string basada en la fecha de modificación
     * del archivo, forzando al navegador a recargar el archivo cuando cambie.
     *
     * Uso en Blade: {{ vasset('js/scripts_jornada.js') }}
     */
    function vasset(string $path): string
    {
        $fullPath = public_path($path);
        $version  = file_exists($fullPath) ? filemtime($fullPath) : time();
        return asset($path) . '?v=' . $version;
    }
}
