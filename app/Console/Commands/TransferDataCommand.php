<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CompanyDatabase;

class TransferDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transfer-data-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer data from one table to another in different databases';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting the data transfer...');
        // Log the source database name
        Log::info('Source Database: ' . env('DB_SOURCE_DATABASE'));
        Log::info('Source HOST: ' . env('DB_SOURCE_HOST'));
        Log::info('Source USERNAME: ' . env('DB_SOURCE_USERNAME'));
        Log::info('Source PASSWORD: ' . env('DB_SOURCE_PASSWORD'));
        // Fetch data from the source database (cloud_sso_data table)
        $sourceData = DB::connection('mysql_source')->table('cloud_sso_users')->get();
        // DB::statement("GRANT ALL PRIVILEGES ON cloud_sso.* TO 'cloudcrmuser'@'%' IDENTIFIED BY 'CC6mafF1Q321!'");
        // DB::statement("FLUSH PRIVILEGES");
        // Log the source data for debugging purposes
        Log::info('Source Data:', $sourceData->toArray()); // This will log the source data as an array.

        // Alternatively, you can use $this->info() to output the data to the console
        $this->info("Source Data: " . json_encode($sourceData));

        if ($sourceData->isEmpty()) {
            $this->info('No data to transfer.');
            return;
        }

        // Fetch all company-specific databases
        $companies = CompanyDatabase::all();

        foreach ($companies as $company) {
            $this->info("Transferring data to company database: {$company->name}");

            // Dynamically switch the target database connection
            $targetConnection = DB::connection($company->database_connection); // Assuming `database_connection` is a column in CompanyDatabase model that stores the connection name
            Log::info('Target Database: ' . $targetConnection);
            // Check if data already exists in the target database
            $existingData = $targetConnection->table('cloud_sso_users')->pluck('id'); // Assuming 'id' is the primary key or unique identifier

            // Filter out the source data that already exists in the target database
            $dataToInsert = $sourceData->filter(function ($item) use ($existingData) {
                return !$existingData->contains($item->id); // Compare by primary key
            });

            // If there is data to insert, perform the insert
            if ($dataToInsert->isNotEmpty()) {
                $inserted = $targetConnection->table('cloud_sso_users')->insert(
                    $dataToInsert->toArray()
                );

                if ($inserted) {
                    $this->info("Data transferred successfully to {$company->name}.");
                } else {
                    $this->error("Data transfer failed for {$company->name}.");
                }
            } else {
                $this->info("No new data to transfer to {$company->name}.");
            }
        }
    }
}
