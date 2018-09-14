<?php

use Maatwebsite\Excel\Excel;

return [
    'exports'            => [

        /*
        |--------------------------------------------------------------------------
        | Chunk size
        |--------------------------------------------------------------------------
        |
        | When using FromQuery, the query is automatically chunked.
        | Here you can specify how big the chunk should be.
        |
        */
        'chunk_size' => 1000,

        /*
        |--------------------------------------------------------------------------
        | Temporary path
        |--------------------------------------------------------------------------
        |
        | When exporting files, we use a temporary file, before storing
        | or downloading. Here you can customize that path.
        |
        */
        'temp_path'  => sys_get_temp_dir(),

        /*
        |--------------------------------------------------------------------------
        | CSV Settings
        |--------------------------------------------------------------------------
        |
        | Configure e.g. delimiter, enclosure and line ending for CSV exports.
        |
        */
        'csv'        => [
            'delimiter'              => ',',
            'enclosure'              => '"',
            'line_ending'            => PHP_EOL,
            'use_bom'                => false,
            'include_separator_line' => false,
            'excel_compatibility'    => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Extension detector
    |--------------------------------------------------------------------------
    |
    | Configure here which writer type should be used when
    | the package needs to guess the correct type
    | based on the extension alone.
    |
    */
    'extension_detector' => [
        'xlsx'     => Excelvthree::XLSX,
        'xlsm'     => Excelvthree::XLSX,
        'xltx'     => Excelvthree::XLSX,
        'xltm'     => Excelvthree::XLSX,
        'xls'      => Excelvthree::XLS,
        'xlt'      => Excelvthree::XLS,
        'ods'      => Excelvthree::ODS,
        'ots'      => Excelvthree::ODS,
        'slk'      => Excelvthree::SLK,
        'xml'      => Excelvthree::XML,
        'gnumeric' => Excelvthree::GNUMERIC,
        'htm'      => Excelvthree::HTML,
        'html'     => Excelvthree::HTML,
        'csv'      => Excelvthree::CSV,
        'tsv'      => Excelvthree::TSV,

        /*
        |--------------------------------------------------------------------------
        | PDF Extension
        |--------------------------------------------------------------------------
        |
        | Configure here which Pdf driver should be used by default.
        |
        | Available options: Excelvthree::MPDF | Excelvthree::TCPDF | Excelvthree::DOMPDF
        |
        */
        'pdf'      => Excelvthree::DOMPDF,
    ],
];
