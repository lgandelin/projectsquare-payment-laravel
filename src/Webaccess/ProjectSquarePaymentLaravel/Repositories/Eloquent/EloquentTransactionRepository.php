<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent;

use Webaccess\ProjectSquarePaymentLaravel\Models\Transaction;

class EloquentTransactionRepository
{
    /**
     * @param $transactionIdentifier
     * @return mixed
     */
    public function getByIdentifier($transactionIdentifier)
    {
        return Transaction::where('identifier', '=', $transactionIdentifier)->first();
    }

    /**
     * @param $platformID
     * @param $amount
     * @return string
     */
    public function initTransaction($platformID, $amount)
    {
        $transaction = new Transaction();
        $transaction->identifier = uniqid();
        $transaction->platform_id = $platformID;
        $transaction->amount = $amount;
        $transaction->status = Transaction::TRANSACTION_STATUS_IN_PROGRESS;
        $transaction->save();

        return $transaction->identifier;
    }
}