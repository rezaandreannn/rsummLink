<?php

return [

    /*
     * This is the name of the table that will be created by the migration and
     * used by the Activity model shipped with this package.
     */
    'log_table_name' => 'satusehat_log',
    'token_table_name' => 'satusehat_token',
    'icd10_table_name' => 'satusehat_icd10',
    'icd9cm_table_name' => 'satusehat_icd9cm',
    'kode_wilayah_indonesia_table_name' => 'kode_wilayah_indonesia',
    'encounter_table_name' => 'satusehat_encounter',
    'mapping_encounter_table_name' => 'satusehat_mapping_encounter',
    'organization_table_name' => 'satusehat_organization',
    'location_table_name' => 'satusehat_location',

    /*
     * Override the SATUSEHAT environment, organization, ClientID, and ClientSecret to use
     * non environment variable
     */

    'ss_parameter_override' => false,

    /*
     * This is the database connection that will be used by the migration and
     * the Activity model shipped with this following Laravel's database.default
     * If not set, it will use mysql instead.
     */
    'database_connection_master' => env('DB_CONNECTION_MASTER', 'sqlsrv'),
    'database_connection_satusehat' => env('DB_CONNECTION', 'sqlsrv'),
];
