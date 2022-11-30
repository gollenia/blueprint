<?php

/**
 * routes.php
 * 
 * Hier werden die Controller einzelnen Routes, Ereignisen oder Spezialfällen zugewiesen.
 * Da manchmal mehrere Bedignungen erfüllt sein können (zb. erfüllt is_page('foo') auch
 * gleichzeitig is_page()), müssen die Routes so sortiert werden, dass die allgemeinen
 * Anweisungen zum Schluss kommen, weil die for-Schleife beim ersten "true" beendet wird.
 * 
 * @since 1.0
 * 
 * @todo remove this, as it sould be solved differently
 * @deprecated 2.0
 * 
 */

return [
    "Error" => is_404(),                      // Seite existiert nicht - könnte in den normalen Controller übergehen

    //"Events" => get_option("dbem_cp_events_slug") ? is_page(get_option("dbem_cp_events_slug")) : false,          // Wird ausgegliedert

    "Post" => is_single(),

    //"Categories" => is_category()  ,       // Kategorie oder Tag

    //"Frontpage" => is_front_page(),                    // Es handelt sich um eine normale Seite

    "Page" => true                          // Default
];