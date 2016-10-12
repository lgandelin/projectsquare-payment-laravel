<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent;

use Webaccess\ProjectSquarePayment\Entities\Transaction as TransactionEntity;
use Webaccess\ProjectSquarePayment\Repositories\TransactionRepository;
use Webaccess\ProjectSquarePaymentLaravel\Models\Transaction;

class EloquentTransactionRepository implements TransactionRepository
{
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

    /**
     * @param TransactionEntity $transaction
     * @return mixed
     */
    public function persist(TransactionEntity $transaction)
    {
        $transactionModel = ($transaction->getId()) ? Transaction::find($transaction->getID()) : new Transaction();
        $transactionModel->identifier = $transaction->getIdentifier();
        $transactionModel->response_code = $transaction->getResponseCode();
        $transactionModel->payment_mean = $transaction->getPaymentMean();
        $transactionModel->platform_id = $transaction->getPlatformID();
        $transactionModel->amount = $transaction->getAmount();
        $transactionModel->status = $transaction->getStatus();
        $transactionModel->save();

        return $transactionModel->id;
    }

    /**
     * @param $transactionIdentifier
     * @return mixed
     */
    public function getByIdentifier($transactionIdentifier)
    {
        if ($transactionModel = Transaction::where('identifier', '=', $transactionIdentifier)->first()) {
            return $this->convertModelToEntity($transactionModel);
        }

        return false;
    }

    private function convertModelToEntity($transactionModel)
    {
        $transaction = new TransactionEntity();
        $transaction->setId($transactionModel->id);
        $transaction->setIdentifier($transactionModel->identifier);
        $transaction->setResponseCode($transactionModel->response_code);
        $transaction->setPaymentMean($transactionModel->payment_mean);
        $transaction->setPlatformID($transactionModel->platform_id);
        $transaction->setAmount($transactionModel->amount);
        $transaction->setStatus($transactionModel->status);

        return $transaction;
    }
}