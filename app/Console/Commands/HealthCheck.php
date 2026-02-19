<?php

namespace App\Console\Commands;

use Throwable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class HealthCheck extends Command
{
    protected $signature = 'health:check {--json : Output machine-readable JSON}';

    protected $description = 'Run application health checks (critical database tables)';

    public function handle(): int
    {
        $criticalTables = config('health.critical_tables', [
            'users',
            'products',
            'categories',
            'orders',
            'hero_slides',
        ]);
        $missingTables = [];

        try {
            foreach ($criticalTables as $table) {
                if (! Schema::hasTable($table)) {
                    $missingTables[] = $table;
                }
            }
        } catch (Throwable $exception) {
            return $this->renderFailure([
                'status' => 'error',
                'connection' => config('database.default'),
                'message' => $exception->getMessage(),
                'missing_tables' => [],
            ]);
        }

        if ($missingTables !== []) {
            return $this->renderFailure([
                'status' => 'failed',
                'connection' => config('database.default'),
                'message' => 'Critical tables are missing.',
                'missing_tables' => $missingTables,
            ]);
        }

        if ($this->option('json')) {
            $this->line(json_encode([
                'status' => 'ok',
                'connection' => config('database.default'),
                'checked_tables' => $criticalTables,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } else {
            $this->info('Health check passed.');
            $this->line('Connection: '.config('database.default'));
            $this->line('Checked tables: '.implode(', ', $criticalTables));
        }

        return self::SUCCESS;
    }

    private function renderFailure(array $payload): int
    {
        if ($this->option('json')) {
            $this->line(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } else {
            $this->error('Health check failed.');
            $this->line('Connection: '.$payload['connection']);
            $this->line('Reason: '.$payload['message']);

            if (! empty($payload['missing_tables'])) {
                $this->line('Missing tables: '.implode(', ', $payload['missing_tables']));
            }
        }

        return self::FAILURE;
    }
}
