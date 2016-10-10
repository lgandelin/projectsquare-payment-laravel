<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Utils;

use DateTime;
use Illuminate\Support\Facades\Log;

class Logger
{
    /**
     * @param $message
     * @param $file
     * @param $line
     * @param array $parameters
     */
    public static function error($message, $file, $line, $parameters = [])
    {
        Log::error('Date : ' . (new DateTime())->format('Y-m-d H:i:s'));
        Log::error('--------------------------------------------------');
        Log::error('Message : ' . $message);
        Log::error('File : ' . $file);
        Log::error('Line : ' . $line);
        Log::error('Parameters : ' . json_encode($parameters));
        Log::error('--------------------------------------------------');
    }

    public static function info($message, $parameters = [])
    {
        Log::info('Date : ' . (new DateTime())->format('Y-m-d H:i:s'));
        Log::info('--------------------------------------------------');
        Log::info('Message : ' . $message);
        Log::info('Parameters : ' . json_encode($parameters));
        Log::info('--------------------------------------------------');
    }
}