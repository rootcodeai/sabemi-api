<?php

namespace App\Support\Traits;

use Illuminate\Support\Facades\Log;
use Throwable;

trait HasErrorLogging
{
    protected function logError(Throwable $e, string $message, string $context): void
    {
        Log::error("[{$context}] {$message}: " . $e->getMessage(), [
            'exception' => $e,
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
    }
}
