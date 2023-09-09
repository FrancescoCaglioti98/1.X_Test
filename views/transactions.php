<!DOCTYPE html>
<html>

<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th,
        table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th,
        tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }

        .amount{
            font-weight: 700;
        }
        .expense{
            color: red;
        }
        .income{
            color: green;
        }

    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Check #</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $key => $single_transaction) { ?>

                <tr>
                    <td><?php echo formatDate( $single_transaction["date"] ) ?></td>
                    <td><?php echo $single_transaction["checkNumber"] ?></td>
                    <td><?php echo $single_transaction["description"] ?></td>
                    <td class="amount <?php echo ( $single_transaction["amount"] < 0 ) ? 'expense' : 'income' ?>" ><?php echo formatDollarAmount($single_transaction["amount"]) ?></td>
                </tr>

            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Income:</th>
                <td><?php echo formatDollarAmount($totals["total_income"]) ?></td>
            </tr>
            <tr>
                <th colspan="3">Total Expense:</th>
                <td><?php echo formatDollarAmount($totals["total_expense"]) ?></td>
            </tr>
            <tr>
                <th colspan="3">Net Total:</th>
                <td><?php echo formatDollarAmount($totals["net_totals"]) ?></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>