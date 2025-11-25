<?php

declare(strict_types=1);

namespace App\Services\Wphcp;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class ShellService
{
    public function run(string $command, array $arguments = []): ShellResult
    {
        $escapedArgs = array_map(fn ($arg) => escapeshellarg((string) $arg), $arguments);
        $fullCommand = $command . ' ' . implode(' ', $escapedArgs);

        Log::info('Executing shell command', ['command' => $fullCommand]);

        $process = Process::fromShellCommandline($fullCommand);
        $process->run();

        $result = new ShellResult(
            exitCode: $process->getExitCode(),
            stdout: $process->getOutput(),
            stderr: $process->getErrorOutput()
        );

        if (! $result->isSuccessful()) {
            Log::error('Shell command failed', [
                'command' => $fullCommand,
                'exit_code' => $result->exitCode,
                'stderr' => $result->stderr,
            ]);
        }

        return $result;
    }

    public function validateDomain(string $domain): bool
    {
        return (bool) preg_match('/^[a-z0-9.-]+$/i', $domain);
    }
}

