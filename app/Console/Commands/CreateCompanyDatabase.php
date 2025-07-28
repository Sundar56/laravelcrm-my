<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateCompanyDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-company-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Company Database and Migrate tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Now, run the queue:listen command with a timeout of 600 seconds
        $this->info('Starting queue listener with 600-second timeout...');
        error_log('Migration Started at: ' . now());
        $exitCode = Artisan::call('queue:listen', [
            '--timeout' => 600,
        ]);
        error_log('Migration ended at: ' . now());
        $this->info('Database created and Tables migrated...');

        // Output the result
        if ($exitCode === 0) {
            $this->info('Queue listener started successfully.');
        } else {
            $this->error('An error occurred while starting the queue listener.');
        }
    }
}
// php artisan app:create-company-database