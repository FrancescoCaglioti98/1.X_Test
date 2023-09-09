<?php

declare(strict_types=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Your Code

function getTransactionFile(string $directory): array
{

    $file_list = [];

    $directory_scan = scandir($directory);

    foreach ($directory_scan as $file) {

        if ($file == '..' || $file == '.') {
            continue;
        }

        if( is_dir($directory . $file) ) {
            $file_list = array_merge( $file_list, getTransactionFile( $directory . $file . DIRECTORY_SEPARATOR ) );
        } else {
            $file_list[] =  $directory . $file;
        }

    }

    return $file_list;
}

function getTransactions(string $fileName, ?callable $transactionHandler = null): array
{
    if (!file_exists($fileName)) {
        trigger_error('File "' . $fileName . '" does not exist.', E_USER_ERROR);
    }


    $fileObj = fopen($fileName, 'r');
    fgetcsv($fileObj);


    $file_transactions = [];
    while (($transaction = fgetcsv($fileObj)) !== false) {

        if ($transactionHandler !== null) {
            $transaction = $transactionHandler($transaction);
        }

        $file_transactions[] = $transaction;
    }

    return $file_transactions;
}

function extractTransaction(array $transactionRow): array
{

    $amount = (float) str_replace(['$', ','], '', $transactionRow[3]);

    return [
        'date'        => $transactionRow[0],
        'checkNumber' => $transactionRow[1],
        'description' => $transactionRow[2],
        'amount'      => $amount,
    ];
}

function calculateTotals(array $transactions): array
{
    $totals = [
        "total_income" => 0,
        "total_expense" => 0,
        "net_totals" => 0
    ];


    foreach ($transactions as $key => $single_transaction) {

        $transaction_value = $single_transaction["amount"];

        $totals["net_totals"] += $transaction_value;


        if ($transaction_value > 0) {
            $totals["total_income"] += $transaction_value;
        } else {
            $totals["total_expense"] += $transaction_value;
        }
    }


    return $totals;
}
