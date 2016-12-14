<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Services;

use DateTime;
use Illuminate\Support\Facades\Log;
use Webaccess\ProjectSquarePayment\Contracts\Logger;
use Webaccess\ProjectSquarePayment\Requests\Request;
use Webaccess\ProjectSquarePayment\Responses\Response;

class LaravelLoggerService implements Logger
{
    /**
     * @param $message
     * @param array $parameters
     * @param null $file
     * @param null $line
     */
    public function error($message, $parameters = [], $file = null, $line = null)
    {
        Log::error('Date : ' . (new DateTime())->format('Y-m-d H:i:s'));
        Log::error('--------------------------------------------------');
        Log::error('Message : ' . $message);
        Log::error('File : ' . $file);
        Log::error('Line : ' . $line);
        Log::error('Parameters : ' . json_encode($parameters));
        Log::error('--------------------------------------------------');
    }

    public function info($message, $parameters = [])
    {
        Log::info('Date : ' . (new DateTime())->format('Y-m-d H:i:s'));
        Log::info('--------------------------------------------------');
        Log::info('Message : ' . $message);
        Log::info('Parameters : ' . json_encode($parameters));
        Log::info('--------------------------------------------------');
    }

    public function logRequest($class, Request $request = null)
    {
        $class = (new \ReflectionClass($class))->getShortName();
        Log::info("\n" . '[REQUEST] ==> ' . $class . "\n" . json_encode($request, JSON_PRETTY_PRINT) . "\n");
    }

    public function logResponse($class, Response $response = null)
    {
        $class = (new \ReflectionClass($class))->getShortName();
        Log::info("\n" . '[RESPONSE] ==> ' . $class . "\n" .json_encode($response, JSON_PRETTY_PRINT) . "\n");
    }
}