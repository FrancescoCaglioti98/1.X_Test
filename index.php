<?php

declare(strict_types = 1);

$root = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR;

define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH', $root . 'transaction_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);

/* YOUR CODE (Instructions in README.md) */

include_once APP_PATH . "App.php";
include_once APP_PATH . "Helpers.php";

$transaction_files = getTransactionFile(FILES_PATH);

$transactions = [];
foreach ($transaction_files as $key => $single_file) {
    $transactions = array_merge($transactions, getTransactions($single_file, 'extractTransaction'));
}


$totals = calculateTotals( $transactions );

include_once VIEWS_PATH . "transactions.php";