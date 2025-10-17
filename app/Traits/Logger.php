<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait Logger
{
    /**
     * Écrit un message dans storage/logs/laravel.log
     * $level: emergency|alert|critical|error|warning|notice|info|debug
     */
    protected function logMessage(string $message, array $context = [], string $level = 'info'): void
    {
        $levels = ['emergency','alert','critical','error','warning','notice','info','debug'];
        $level = in_array($level, $levels, true) ? $level : 'info';

        Log::{$level}($message, $context);
    }

    protected function logInfo(string $message, array $context = []): void
    {
        $this->logMessage($message, $context, 'info');
    }

    protected function logError(string $message, array $context = []): void
    {
        $this->logMessage($message, $context, 'error');
    }
}
