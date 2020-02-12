<?php

/**
 * routes.php
 * 
 * Hier werden die Controller einzelnen Routes, Ereignisen oder Spezialfällen zugewiesen.
 * Da manchmal mehrere Bedignungen erfüllt sein können (zb. erfüllt is_page('foo') auch
 * gleichzeitig is_page()), müssen die Routes so sortiert werden, dass die allgemeinen
 * Anweisungen zum Schluss kommen, weil die for-Schleife beim ersten "true" beendet wird.
 * 
 */

return [
    "404" => is_404(),                      // Seite existiert nicht

    "Event" => is_singular('event'),        // Seite ist ein einzelnes Event

    "Events" => is_page('events'),          // Seite beinhaltet eine Eventliste

    "News" => is_single(),

    "Freizeiten" => in_category('freizeiten') && is_singular('event'),

    "Page" => is_page()                    // Es handelt sich um eine normale Seite
];