<?php

namespace Ml\Fuzzy;

use App\Models\Fuzzy\Log;

class Logger implements \Psr\Log\LoggerInterface
{

    /**
     * @inheritDoc
     */
    public function emergency($message, array $context = array())
    {
        // TODO: Implement emergency() method.
    }

    /**
     * @inheritDoc
     */
    public function alert($message, array $context = array())
    {
        // TODO: Implement alert() method.
    }

    /**
     * @inheritDoc
     */
    public function critical($message, array $context = array())
    {
        // TODO: Implement critical() method.
    }

    /**
     * @inheritDoc
     */
    public function error($message, array $context = array())
    {
        // TODO: Implement error() method.
    }

    /**
     * @inheritDoc
     */
    public function warning($message, array $context = array())
    {
        // TODO: Implement warning() method.
    }

    /**
     * @inheritDoc
     */
    public function notice($message, array $context = array())
    {
        // TODO: Implement notice() method.
    }

    /**
     * @inheritDoc
     */
    public function info($message, array $context = array())
    {
            Log::create([
            'text' => $message,
            'level' => 'info',
            'context' => json_encode($context),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function debug($message, array $context = array())
    {
        // TODO: Implement debug() method.
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array())
    {
        Log::create([
            'text' => $message,
            'level' => $level,
            'context' => json_encode($context),
        ]);
    }
}
