<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportSqliteData extends Command
{
    protected $signature = 'app:import-sqlite';
    protected $description = 'Import data dari SQLite ke MySQL';

    public function handle()
    {
        $tables = DB::connection('sqlite_old')
            ->select("SELECT name FROM sqlite_master WHERE type='table'");

        foreach ($tables as $tableObj) {

            $table = $tableObj->name;

            if (in_array($table, [
    'sqlite_sequence',
    'migrations',
    'cache',
    'cache_locks',
    'jobs',
    'job_batches',
    'failed_jobs',
    'sessions',
    'password_reset_tokens',
])) {
    continue;
}

            if (!Schema::hasTable($table)) {
                $this->warn("Lewati: {$table}");
                continue;
            }

            $this->info("Import {$table}");

            $rows = DB::connection('sqlite_old')
                ->table($table)
                ->get();

            foreach ($rows as $row) {
                DB::table($table)->insert(
                    (array) $row
                );
            }

            $this->info("Selesai {$table}");
        }

        $this->info('IMPORT SELESAI');
    }
}