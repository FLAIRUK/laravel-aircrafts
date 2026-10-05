<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database
    |--------------------------------------------------------------------------
    |
    | The in-memory lookup API (the Aircrafts facade) works without a database.
    | These settings only apply if you publish the migration and seed the
    | aircrafts into a table, e.g. so other tables can reference them.
    |
    */

    'table' => env('AIRCRAFTS_TABLE', 'aircrafts'),

    'connection' => env('AIRCRAFTS_DB_CONNECTION'),

];
