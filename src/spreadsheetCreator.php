<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function spreadsheetCreator($arr, $filename) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet()
        ->fromArray(
            $arr,
            null,
            'A1'
        );
    $sheet = $spreadsheet->getActiveSheet()->setAutoFilter(
        $spreadsheet->getActiveSheet()
            ->calculateWorksheetDimension()
    );

    $writer = new Xlsx($spreadsheet);
    $writer->save($filename);
}
