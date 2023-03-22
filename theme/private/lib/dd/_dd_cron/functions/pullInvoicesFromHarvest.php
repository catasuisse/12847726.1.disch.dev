<?php

$invoices = dd_api::pull('harvest', 'invoices');

if(!$invoices) {
    return true;
}

$harvestIds = array_column($invoices, 'id');

$query = '

            DELETE FROM
            dd_invoice
            WHERE
            harvest_id != ""

        ';

if($harvestIds) {
    $query .= '

                AND
                harvest_id NOT IN (' . rex_sql::factory()->in($harvestIds) . ')

            ';
}

rex_sql::factory()->setQuery($query);

if($invoices) {
    foreach($invoices as $value) {
        if(
            (
                $value['progress'] != 'open' &&
                $value['progress'] != 'paid'
            ) ||
            (
                $value['payment'] &&
                strtotime($value['payment']) - 1 < time() - 86400 * 7
            )
        ) {
            rex_sql::factory()->setQuery('

                        DELETE FROM
                        dd_invoice
                        WHERE
                        harvest_id = :harvest_id

                    ', [

                'harvest_id' => $value['id'],

            ]);

            continue;
        }

        $invoice = rex_sql::factory()
            ->getArray('

                        SELECT
                        *
                        FROM
                        dd_invoice
                        WHERE
                        harvest_id = :harvest_id

                    ', [

                'harvest_id' => $value['id'],

            ]);

        if($invoice) {
            $invoice = $invoice[0];

            rex_sql::factory()
                ->setQuery('

                            UPDATE
                            dd_invoice
                            SET
                            amount = :amount,
                            company = :company,
                            currency = :currency,
                            debit = :debit,
                            harvest_id = :harvest_id,
                            number = :number,
                            payment = :payment,
                            progress = :progress,
                            target = :target,
                            token = :token,
                            updatedate = :updatedate
                            WHERE
                            id = :id

                        ', [

                    'amount' => $value['amount'],
                    'company' => $value['company'],
                    'currency' => $value['currency'],
                    'debit' => $value['debit'],
                    'harvest_id' => $value['id'],
                    'id' => $invoice['id'],
                    'number' => $value['number'],
                    'payment' => $value['payment'],
                    'progress' => $value['progress'],
                    'target' => $value['target'],
                    'token' => $value['token'],
                    'updatedate' => date('Y-m-d H:i:s', time()),

                ]);
        } else {
            rex_sql::factory()
                ->setQuery('

                            INSERT INTO
                            dd_invoice
                            SET
                            amount = :amount,
                            company = :company,
                            createdate = :createdate,
                            currency = :currency,
                            debit = :debit,
                            harvest_id = :harvest_id,
                            number = :number,
                            payment = :payment,
                            progress = :progress,
                            status = :status,
                            target = :target,
                            token = :token,
                            updatedate = :updatedate

                        ', [

                    'amount' => $value['amount'],
                    'company' => $value['company'],
                    'createdate' => date('Y-m-d H:i:s', time()),
                    'currency' => $value['currency'],
                    'debit' => $value['debit'],
                    'harvest_id' => $value['id'],
                    'number' => $value['number'],
                    'payment' => $value['payment'],
                    'progress' => $value['progress'],
                    'status' => 1,
                    'target' => $value['target'],
                    'token' => $value['token'],
                    'updatedate' => date('Y-m-d H:i:s', time()),

                ]);
        }
    }

    dd_sql::reindex('dd_invoice');
}

return true;